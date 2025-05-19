<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Downtime;
use App\Models\Setup;
use App\Models\Mesin;
use App\Models\Defect;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Traits\HasNotifications;
use App\Events\NewNotification;

use Carbon\Carbon;

class DowntimeController extends Controller
{
    use HasNotifications;

    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('show', 10);
        $search = $request->input('search');
        $filterType = $request->input('filter_type', 'all');
        $status = $request->input('status');

        $query = Downtime::with('user', 'mesin', 'defect');

        // Role-based filtering
        if ($user->role === 'leader') {
            // Filter hanya downtime yang terkait dengan user leader dan mesin valid
            $query->where('user_id', $user->id)
                ->whereHas('mesin', function ($q) {
                    $q->whereNotNull('molding_mc');
                });
        } elseif ($user->role === 'teknisi') {
            // Filter hanya setup yang maintenance_repair-nya adalah user yang sedang login
            // dan statusnya belum completed
            $query->where('maintenance_repair', $user->id);
        }
        // Status filtering if specified
        if ($status) {
            $query->where('status', $status);
        }

        // Search functionality
        if ($search) {
            $query->where(function ($query) use ($search, $filterType) {
                switch ($filterType) {
                    case 'badge':
                        $query->where('badge', 'like', "%{$search}%");
                        break;
                    case 'line':
                        $query->where('line', 'like', "%{$search}%");
                        break;
                    case 'leader':
                        $query->where('leader', 'like', "%{$search}%");
                        break;

                    case 'defect_category':
                        $query->where(function ($q) use ($search) {
                            // Search in current table's defect_category column
                            $q->where('defect_category', 'like', "%{$search}%")
                                // Search in related defects table
                                ->orWhereHas('defect', function ($query) use ($search) {
                                    $query->where('defect_category', 'like', "%{$search}%");
                                });
                        });
                        break;
                    case 'molding_mc':
                        $query->whereHas('mesin', function ($q) use ($search) {
                            $q->whereNotNull('molding_mc') // Pastikan molding_mc tidak null
                                ->where('molding_mc', 'like', "%{$search}%");
                        });

                        break;
                    default:
                        $query->where(function ($q) use ($search) {
                            $q->where('badge', 'like', "%{$search}%")
                                ->orWhere('line', 'like', "%{$search}%")
                                ->orWhere('leader', 'like', "%{$search}%")
                                ->orWhere('defect_category', 'like', "%{$search}%")
                                ->orWhereHas('defect', function ($dq) use ($search) {
                                    $dq->where('defect_category', 'like', "%{$search}%");
                                })
                                ->orWhereHas('mesin', function ($mq) use ($search) {
                                    $mq->where('molding_mc', 'like', "%{$search}%");
                                });
                        });
                }
            });
        }

        $downtimes = $query->latest()->paginate($perPage);
        $mesins = Mesin::all();
        $defects = Defect::all();

        return view('downtime.index', compact(
            'downtimes',
            'mesins',
            'defects',
            'perPage',
            'search',
            'filterType',
            'status',
            'user'
        ));
    }

    public function show(Downtime $downtime)
    {
        $mesins = Mesin::all();
        $defects = Defect::all();
        return view('downtime.show', compact('downtime', 'mesins', 'defects'));
    }
    public function edit(Downtime $downtime)
    {
        $mesins = Mesin::all();
        $defects = Defect::all();
        return view('downtime.edit', compact('downtime', 'mesins', 'defects'));
    }
    public function create()
    {
        $user = Auth::user();
        $mesins = Mesin::all();
        $defects = Defect::all();

        $busyTeknisiIds = array_merge(
            Setup::whereIn('status', ['Waiting', 'In Progress', 'Pending QC', 'Waiting QC Approve'])
                ->whereNotNull('maintenance_name')
                ->pluck('maintenance_name')
                ->toArray(),
            Downtime::whereIn('status', ['Waiting', 'In Progress', 'Waiting QC Approve'])
                ->whereNotNull('maintenance_repair')
                ->pluck('maintenance_repair')
                ->toArray()
        );

        // Ambil teknisi yang tersedia
        $availableTeknisiUsers = User::where('role', 'teknisi')
            ->whereNotIn('id', $busyTeknisiIds)
            ->get();
        return view('downtime.create', compact('user', 'mesins', 'defects', 'availableTeknisiUsers'));
    }
    public function store(Request $request)
    {
        $user = Auth::user();

        // Aturan validasi dasar
        $validationRules = [
            'badge' => 'required',
            'line' => 'required',
            'leader' => 'required',
            'raised_ipqc' => 'required',
            'raised_operator' => 'required',
            'maintenance_repair' => [
                'required',
                'exists:users,id,role,teknisi',
                function ($attribute, $value, $fail) {
                    // Cek apakah teknisi sedang menangani setup yang aktif
                    $busyInSetup = Setup::whereIn('status', ['Waiting', 'In Progress', 'Waiting QC Approve'])
                        ->where('maintenance_name', $value)
                        ->exists();

                    // Cek apakah teknisi sedang menangani downtime yang aktif
                    $busyInDowntime = Downtime::whereIn('status', ['Waiting', 'In Progress', 'Waiting QC Approve'])
                        ->where('maintenance_repair', $value)
                        ->exists();

                    if ($busyInSetup) {
                        $fail('Teknisi ini sedang menangani setup lain yang masih aktif.');
                    }

                    if ($busyInDowntime) {
                        $fail('This technician is handling active downtime.');
                    }
                }
            ],
            'problem_defect' => 'required',
            'molding_machine' => [
                'required',
                'exists:mesin,id',
                function ($attribute, $value, $fail) {
                    // Cek apakah mesin sudah terdaftar di setup
                    $existingSetup = Setup::where('molding_machine', $value)
                        ->whereNull('tanggal_finish')
                        ->first();

                    // Cek apakah mesin sudah terdaftar di downtime
                    $existingDowntime = Downtime::where('molding_machine', $value)
                        ->whereNull('tanggal_finish')
                        ->first();

                    // Pesan error yang akan ditampilkan
                    if ($existingSetup) {
                        $fail('The machine is already registered in active Setup with the status ' . $existingSetup->status);
                    }

                    if ($existingDowntime) {
                        $fail('Machine is already registered in active Downtime');
                    }
                }
            ]
        ];
        // Validasi berbeda untuk defect kategori kustom dan standar
        if ($request->input('is_custom_defect', false)) {
            // Jika kustom, validasi input text
            $validationRules['custom_defect_category'] = 'required|string|max:255';
        } else {
            // Jika standar, validasi ID harus ada di tabel defects
            $validationRules['defect_category'] = 'required|exists:defects,id';
        }

        $validated = $request->validate($validationRules);

        // Tentukan nilai defect_category yang akan disimpan
        if ($request->input('is_custom_defect', false)) {
            $validated['defect_category'] = $request->custom_defect_category;
        }

        // Tambah data tambahan
        $validated['status'] = 'Waiting';
        $validated['tanggal_submit'] = now()->toDateString();
        $validated['jam_submit'] = now()->toTimeString();
        $validated['user_id'] = $user->id;

        // Simpan data
        $downtime = Downtime::create($validated);
        // Kirim notifikasi hanya ke teknisi yang ditugaskan
        $assignedTechnician = User::findOrFail($validated['maintenance_repair']);

        $notification = Notifikasi::create([
            'user_id' => $assignedTechnician->id,
            'title' => 'New Downtime Report - Molding M/C ' . $validated['molding_machine'],
            'message' => 'There is a new downtime report for Molding M/C ' . $validated['molding_machine'],
            'is_read' => false,
            'data' => json_encode([
                'downtime_id' => $downtime->id,
                'molding_machine' => $validated['molding_machine'],
                'redirect_url' => route('downtime.index', $downtime->id)
            ])
        ]);

        event(new NewNotification($notification));
        // broadcast(new NewNotification($notification))->toOthers();


        return redirect()->route('downtime.create')
            ->with('success', 'Downtime successfully created!');
    }

    public function update(Request $request, Downtime $downtime)
    {
        // Aturan validasi dasar
        $validationRules = [
            'badge' => 'required',
            'line' => 'required',
            'molding_machine' => 'required|exists:mesin,id',
            'leader' => 'required',
            'raised_ipqc' => 'required',
            'raised_operator' => 'required',

            'problem_defect' => 'required'
        ];

        // Validasi berbeda untuk defect kategori kustom dan standar
        if ($request->input('is_custom_defect', false)) {
            $validationRules['custom_defect_category'] = 'required|string|max:255';
        } else {
            $validationRules['defect_category'] = 'required|exists:defects,id';
        }

        $validated = $request->validate($validationRules);

        // Tentukan nilai defect_category yang akan diupdate
        if ($request->input('is_custom_defect', false)) {
            $validated['defect_category'] = $request->custom_defect_category;
        }

        $validated['tanggal_submit'] = now()->toDateString();
        $validated['jam_submit'] = now()->format('H:i');

        $downtime->update($validated);

        return redirect()->back()->with('success', 'Downtime successfully updated.');
    }

    public function destroy(Downtime $downtime)
    {
        // Hapus notifikasi terkait
        app(NotifikasiController::class)->deleteRelatedNotifications($downtime->id, 'downtime');


        $downtime->delete();

        return redirect()->route('downtime.index')
            ->with('success', 'Downtime successfully removed.');
    }

    public function start(Request $request, $id)
    {
        try {
            $downtime = Downtime::findOrFail($id);


            $downtime->status = 'In Progress';
            $downtime->tanggal_start = $request->input('date', now()->toDateString());
            $downtime->jam_start = $request->input('time', now()->toTimeString());
            $downtime->save();


            return response()->json([
                'success' => true,
                'status' => $downtime->status,
                'date' => $downtime->tanggal_start_formatted,
                'time' => $downtime->jam_start_formatted
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error starting downtime: ' . $e->getMessage()
            ], 500);
        }
    }

    // Finish Downtime
    public function finishDowntimeCreate()
    {
        // Ambil data downtime yang belum selesai dan status In Progress
        $registeredMachines = Downtime::select('root_cause', 'action_taken', 'maintenance_repair',)
            ->where('status', 'In Progress')
            ->orderBy('molding_machine')
            ->get();

        $downtimes = Downtime::with('mesin')
            ->where('status', 'In Progress')
            ->get();

        return view('downtime.create-finish', compact('registeredMachines', 'downtimes'));
    }
    public function finishDowntimeStore(Request $request)
    {
        $validated = $request->validate([
            'molding_machine' => [
                'required',
                'exists:downtimes,id',
                function ($attribute, $value, $fail) {
                    $downtime = Downtime::findOrFail($value);
                    if (!$downtime->tanggal_start || !$downtime->jam_start) {
                        $fail('This molding machine downtime has not yet started.');
                    }
                    if ($downtime->tanggal_finish) {
                        $fail('This molding machine downtime has already been completed.');
                    }
                }
            ],
            'root_cause' => 'required',
            'action_taken' => 'required',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,pdf|max:5120'
        ]);
        try {
            $finishdowntime = Downtime::findOrFail($validated['molding_machine']);

            // Data untuk update
            $updateData = [
                'root_cause' => $validated['root_cause'],
                'action_taken' => $validated['action_taken'],
                'status' => 'Waiting QC Approve'
            ];

            // Jika ada file dokumentasi yang diupload
            if ($request->hasFile('dokumentasi')) {
                $file = $request->file('dokumentasi');
                $filename = 'downtime' . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('dokumentasi/', $filename, 'public');
                $updateData['dokumentasi'] = 'dokumentasi/' . $filename;
            }

            $result = $finishdowntime->update($updateData);

            if ($result) {
                // Notify IPQC
                $ipqcUsers = User::where('role', 'ipqc')->get();
                foreach ($ipqcUsers as $ipqc) {
                    Notifikasi::create([
                        'user_id' => $ipqc->id,
                        'title' => 'Downtime Waiting Approval',
                        'message' => "There was downtime that required QC approval for the machine {$finishdowntime->molding_machine}",
                        'is_read' => false,
                        'data' => json_encode([
                            'downtime_id' => $finishdowntime->id,
                            'redirect_url' => route('downtime.index', $finishdowntime->id)
                        ])
                    ]);
                }
                return redirect()->route('downtime.index')
                    ->with('success', 'Downtime successfully finalized and waiting for QC approval.');
            }
            return redirect()->back()->with('error', 'Gagal menyimpan downtime');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan downtime: ' . $e->getMessage());
        }
    }


    public function finishDowntimeUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'root_cause' => 'required',
            'action_taken' => 'required',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,pdf|max:5120'
        ]);
        try {
            $downtime = Downtime::findOrFail($id);
            // Check if downtime is in a valid state for updating
            if (!$downtime->tanggal_start || !$downtime->jam_start) {
                return redirect()->back()->with('error', 'The molding machines downtime has not yet started.');
            }
            // Determine if status should be updated or preserved
            $status = $downtime->status;
            if ($status == 'Finish' || $status == 'Ditolak') {
                $status = 'Waiting QC Approve';
            }
            // Update the downtime record
            $updateData = [
                'root_cause' => $validated['root_cause'],
                'action_taken' => $validated['action_taken'],
                'status' => $status
            ];
            if ($request->hasFile('dokumentasi')) {
                $file = $request->file('dokumentasi');
                $filename = 'downtime' . '_' .   $file->getClientOriginalName();
                $path = $file->storeAs('dokumentasi/', $filename, 'public');
                // Delete old file if exists
                if ($downtime->dokumentasi) {
                    Storage::disk('public')->delete($downtime->dokumentasi);
                }
                $updateData['dokumentasi'] = 'dokumentasi/' . $filename;
            }
            $result = $downtime->update($updateData);
            if ($result) {
                return redirect()->back()->with('success', 'Downtime data is successfully updated');
            }
            return redirect()->back()->with('error', 'Failed to update downtime data');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update downtime data: ' . $e->getMessage());
        }
    }
    public function approve(Request $request, $id)
    {
        try {
            $downtime = Downtime::findOrFail($id);
            if ($downtime->status !== 'Waiting QC Approve') {
                return redirect()->back()->with('error', 'Invalid downtime status for approval');
            }

            // Aturan validasi dengan pesan dalam Bahasa Indonesia
            $validated = $request->validate([
                'qc_approve' => [
                    'required',
                    'string',
                    'regex:/^[^\/]+\/[^\/]+$/', // Validasi format: text/text
                ],
                'production_verify' => [
                    'required',
                    'string',
                    'regex:/^[^\/]+\/[^\/]+$/', // Validasi format: text/text
                ]
            ], [
                'qc_approve.required' => 'Name and QC badge fields are required',
                'qc_approve.regex' => 'QC writing format must match: name/badge',
                'production_verify.required' => 'Name and Production badge fields required',
                'production_verify.regex' => 'Production writing format must match: name/badge'
            ]);

            $downtime->update([
                'qc_approve' => $validated['qc_approve'],
                'production_verify' => $validated['production_verify'],
                'status' => 'Completed',
                'tanggal_finish' => now()->toDateString(),
                'jam_finish' => now()->format('H:i')
            ]);

            return redirect()->route('downtime.index')
                ->with('success', 'Downtime successfully approved and completed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Redirect ke halaman index dengan pesan error untuk kesalahan format
            if ($e->validator->errors()->has('qc_approve') || $e->validator->errors()->has('production_verify')) {
                return redirect()->route('downtime.index')
                    ->with('error', 'Approval failed: Inappropriate input format. Please use name/badge format');
            }
            // Untuk error validasi lainnya, kembali ke halaman sebelumnya
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed approval: ' . $e->getMessage());
        }
    }
    public function RekapIndex(Request $request)
    {
        try {
            $perPage = $request->input('show', 10);
            $user = Auth::user();
            $mesins = Mesin::all();
            $defects = Defect::all();

            $query = Downtime::with('user');

            // Filter based on user role
            if ($user->role === 'ipqc') {
                $query->where('status', 'Waiting QC Approve')
                    ->whereNull('qc_approve'); // Add condition for empty qc_approve
            } else {
                // For leader, teknisi, and admin
                $query->where('status', 'Completed');
            }

            $downtimes = $query->latest()
                ->paginate($perPage);

            return view('downtime.index-rekap', compact('downtimes', 'perPage', 'mesins', 'defects'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data rekap: ' . $e->getMessage());
        }
    }

    public function RekapShow($downtime)
    {
        $downtime = Downtime::findOrFail($downtime);
        $mesins = Mesin::all();
        $defects = Defect::all();
        return view('downtime.show-rekap', compact('downtime', 'mesins', 'defects'));
    }

    public function RekapEdit($downtime)
    {
        $downtime = Downtime::findOrFail($downtime);
        return view('downtime.show-rekap', compact('downtime'));
    }



    public function RekapUpdate(Request $request, $downtime)
    {
        try {
            // Temukan record downtime yang sudah ada
            $downtime = Downtime::findOrFail($downtime);

            // Inisialisasi aturan validasi dasar
            $validationRules = [
                'badge' => 'required',
                'line' => 'required',
                'leader' => 'required',
                'maintenance_repair' => 'nullable|string',
                'molding_machine' => 'nullable|string',
                'raised_ipqc' => 'nullable|string',
                'raised_operator' => 'nullable|string',
                'problem_defect' => 'nullable|string',
                'root_cause' => 'nullable|string',
                'action_taken' => 'nullable|string',
                'production_verify' => 'nullable|string',
                'qc_approve' => 'nullable|string',
            ];

            // Tambahkan validasi untuk kategori defect berdasarkan pilihan kustom atau standar
            if ($request->input('is_custom_defect', false)) {
                $validationRules['custom_defect_category'] = 'required|string|max:255';
            } else {
                $validationRules['defect_category'] = 'required|exists:defects,id';
            }

            // Validasi semua input sekaligus
            $validated = $request->validate($validationRules);

            // Tentukan nilai defect_category yang akan diupdate
            if ($request->input('is_custom_defect', false)) {
                $validated['defect_category'] = $request->input('custom_defect_category');
            }

            // Update record
            $downtime->update($validated);

            // Alihkan dengan pesan sukses
            return redirect()->route('downtime.index')
                ->with('success', 'Downtime recap updated successfully.');
        } catch (\Exception $e) {
            // Log error dan alihkan kembali dengan pesan error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update data:' . $e->getMessage());
        }
    }

    public function RekapStore(Request $request)
    {
        try {
            // Inisialisasi aturan validasi dasar
            $validationRules = [
                'badge' => 'required',
                'line' => 'required',
                'leader' => 'required',
                'maintenance_repair' => 'nullable|string',
                'molding_machine' => 'nullable|string',
                'raised_ipqc' => 'nullable|string',
                'raised_operator' => 'nullable|string',
                'problem_defect' => 'nullable|string',
                'root_cause' => 'nullable|string',
                'action_taken' => 'nullable|string',
                'production_verify' => 'nullable|string',
                'qc_approve' => 'nullable|string',
                'tanggal_submit' => 'nullable|date',
                'jam_submit' => 'nullable|date_format:H:i:s',
                'tanggal_start' => 'nullable|date',
                'jam_start' => 'nullable|date_format:H:i:s',
                'tanggal_finish' => 'nullable|date',
                'jam_finish' => 'nullable|date_format:H:i:s'
            ];

            // Tambahkan validasi untuk kategori defect berdasarkan pilihan kustom atau standar
            if ($request->input('is_custom_defect', false)) {
                $validationRules['custom_defect_category'] = 'required|string|max:255';
            } else {
                $validationRules['defect_category'] = 'required|exists:defects,id';
            }

            // Validasi semua input sekaligus
            $validated = $request->validate($validationRules);

            // Proses field defect_category
            if ($request->input('is_custom_defect', false)) {
                $validated['defect_category'] = $request->input('custom_defect_category');
            }

            // Buat record Downtime baru dengan semua data yang telah divalidasi
            $downtime = Downtime::create([
                'badge' => $validated['badge'],
                'line' => $validated['line'],
                'leader' => $validated['leader'],
                'maintenance_repair' => $validated['maintenance_repair'] ?? null,
                'molding_machine' => $validated['molding_machine'] ?? null,
                'raised_ipqc' => $validated['raised_ipqc'] ?? null,
                'raised_operator' => $validated['raised_operator'] ?? null,
                'defect_category' => $validated['defect_category'] ?? null,
                'problem_defect' => $validated['problem_defect'] ?? null,
                'root_cause' => $validated['root_cause'] ?? null,
                'action_taken' => $validated['action_taken'] ?? null,
                'production_verify' => $validated['production_verify'] ?? null,
                'qc_approve' => $validated['qc_approve'] ?? null,
                'tanggal_submit' => $validated['tanggal_submit'] ?? now()->toDateString(),
                'jam_submit' => $validated['jam_submit'] ?? now()->toTimeString(),
                'tanggal_start' => $validated['tanggal_start'] ?? null,
                'jam_start' => $validated['jam_start'] ?? null,
                'tanggal_finish' => $validated['tanggal_finish'] ?? null,
                'jam_finish' => $validated['jam_finish'] ?? null,
                // Opsional: 'user_id' => Auth::id(),
            ]);

            // Alihkan dengan pesan sukses
            return redirect()->route('downtime.index')
                ->with('success', 'Downtime recap successfully created.');
        } catch (\Exception $e) {
            // Log error dan alihkan kembali dengan pesan error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to recap downtime:' . $e->getMessage());
        }
    }


    public function RekapDestroy(Downtime $downtime)
    {
        $downtime->delete();

        return redirect()->route('downtime.index')
            ->with('success', 'Downtime recap successfully deleted.');
    }

    // Controller
    public function RekapSearch(Request $request)
    {
        $perPage = $request->input('show', 10);
        $search = trim($request->input('search', ''));
        $filterType = $request->input('filter_type', 'all');

        // Buat query dasar
        $query = Downtime::query();

        // Filter untuk memastikan tanggal_finish tidak null dan tidak kosong
        $query->whereNotNull('tanggal_finish')
            ->where('tanggal_finish', '!=', '');

        // Terapkan pencarian jika ada search term
        if (!empty($search)) {
            $query->where(function ($query) use ($search, $filterType) {
                switch ($filterType) {
                    case 'badge':
                        $query->where('badge', 'like', "%{$search}%");
                        break;

                    case 'line':
                        $query->where('line', 'like', "%{$search}%");
                        break;

                    case 'leader':
                        $query->where('leader', 'like', "%{$search}%");
                        break;

                    case 'maintenance_repair':
                        $query->where('maintenance_repair', 'like', "%{$search}%");
                        break;

                    case 'qc_approve':
                        $query->where('qc_approve', 'like', "%{$search}%");
                        break;

                    case 'molding_mc':
                        $query->whereHas('mesin', function ($q) use ($search) {
                            $q->where('molding_mc', 'like', "%{$search}%");
                        });
                        break;

                    default: // 'all'
                        $query->where(function ($q) use ($search) {
                            $q->where('badge', 'like', "%{$search}%")
                                ->orWhere('line', 'like', "%{$search}%")
                                ->orWhere('leader', 'like', "%{$search}%")
                                ->orWhere('maintenance_repair', 'like', "%{$search}%")
                                ->orWhere('qc_approve', 'like', "%{$search}%")
                                ->orWhereHas('mesin', function ($mq) use ($search) {
                                    $mq->where('molding_mc', 'like', "%{$search}%");
                                });
                        });
                }
            });
        }

        // Urutkan berdasarkan tanggal submit
        $query->orderBy('tanggal_finish', 'desc');

        // Lakukan paginasi
        $downtimes = $query->latest()->paginate($perPage);

        $defects = Defect::all();
        $mesins = Mesin::all();


        return view('downtime.index-rekap', compact(
            'downtimes',
            'search',
            'perPage',
            'defects',
            'mesins',
            'filterType'
        ));
    }
    public function getUnfinishedDowntimes()
    {
        $count = Downtime::where('status', '!=', 'Completed')->count();
        return response()->json(['count' => $count]);
    }
}
