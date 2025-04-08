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
        } else {
            // Other roles see all records but only with status 'Menunggu' or 'Sedang Diproses'
            $query->whereIn('status', ['Menunggu', 'Sedang Diproses','Menunggu QC Approve']);
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
                        $query->where(function($q) use ($search) {
                            // Search in current table's defect_category column
                            $q->where('defect_category', 'like', "%{$search}%")
                            // Search in related defects table
                            ->orWhereHas('defect', function($query) use ($search) {
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
                                ->orWhereHas('defect', function($dq) use ($search) {
                                    $dq->where('defect_category', 'like', "%{$search}%"); })                                
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
        return view('downtime.create', compact('user', 'mesins', 'defects'));
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
                        $fail('Mesin sudah terdaftar dalam Setup aktif dengan status ' . $existingSetup->status);
                    }
    
                    if ($existingDowntime) {
                        $fail('Mesin sudah terdaftar dalam Downtime aktif');
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
    $validated['status'] = 'Menunggu';
    $validated['tanggal_submit'] = now()->toDateString();
    $validated['jam_submit'] = now()->toTimeString();
    $validated['user_id'] = $user->id;

    // Simpan data
    $downtime = Downtime::create($validated);
   
    // Kirim notifikasi ke teknisi
    $teknisiUsers = User::where('role', 'teknisi')->get();

    foreach ($teknisiUsers as $teknisi) {
        $notification = Notifikasi::create([
            'user_id' => $teknisi->id,
            'title' => 'Laporan Downtime Baru',
            'message' => 'Ada laporan downtime baru yang perlu ditindaklanjuti',
            'is_read' => false,
            'data' => json_encode([
                'downtime_id' => $downtime->id,
                'redirect_url' => route('downtime.index', $downtime->id)
            ])
        ]);
        event(new NewNotification($notification));
        // broadcast(new NewNotification($notification))->toOthers();
    }
    
    return redirect()->route('downtime.create')
        ->with('success', 'Downtime berhasil dibuat!');
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

    return redirect()->route('downtime.index')
        ->with('success', 'Downtime berhasil diperbarui.');
}    

    public function destroy(Downtime $downtime)
    {
        $downtime->delete();

        return redirect()->route('downtime.index')
            ->with('success', 'Downtime berhasil dihapus.');
    }

    public function start(Request $request, $id)
{
    try {
        $downtime = Downtime::findOrFail($id);
        
        
        $downtime->status = 'Sedang Diproses';
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
        // Ambil data downtime yang belum selesai dan status Sedang Diproses
        $registeredMachines = Downtime::select('root_cause', 'action_taken', 'maintenance_repair', )
            ->where('status', 'Sedang Diproses')
            ->orderBy('molding_machine')
            ->get();

        $downtimes = Downtime::with('mesin')
            ->where('status', 'Sedang Diproses')
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
                        $fail('downtime mesin molding ini belum dimulai.');
                    }
                    if ($downtime->tanggal_finish) {
                        $fail('downtime mesin molding ini sudah pernah diselesaikan.');
                    }
                }
            ],
            'root_cause' => 'required',
            'action_taken' => 'required',
            'maintenance_repair' => 'required',
           
        ]);

        try {
            $finishdowntime = Downtime::findOrFail($validated['molding_machine']);
            $result = $finishdowntime->update([
                'root_cause' => $validated['root_cause'],
                'action_taken' => $validated['action_taken'],
                'maintenance_repair' => $validated['maintenance_repair'],
                'status' => 'Menunggu QC Approve'
            ]);

            if ($result) {
                // Notify IPQC
                $ipqcUsers = User::where('role', 'ipqc')->get();
                foreach ($ipqcUsers as $ipqc) {
                    Notifikasi::create([
                        'user_id' => $ipqc->id,
                        'title' => 'Downtime Menunggu Approval',
                        'message' => "Ada downtime yang memerlukan approval QC untuk mesin {$finishdowntime->molding_machine}",
                        'is_read' => false,
                        'data' => json_encode([
                            'downtime_id' => $finishdowntime->id,
                            'redirect_url' => route('rekapdowntime.index', $finishdowntime->id)
                        ])
                    ]);
                }

                
                return redirect()->route('finishdowntime.create')
                    ->with('success', 'Downtime berhasil diselesaikan dan menunggu QC approve');
            }

            return redirect()->back()->with('error', 'Gagal menyimpan downtime');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan downtime: ' . $e->getMessage());
        }
    }

    public function approve(Request $request, $id)
{
    try {
        $downtime = Downtime::findOrFail($id);
        if ($downtime->status !== 'Menunggu QC Approve') {
            return redirect()->back()->with('error', 'Status downtime tidak valid untuk persetujuan');
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
            'qc_approve.required' => 'Kolom nama dan badge QC wajib diisi',
            'qc_approve.regex' => 'Format penulisan QC harus sesuai: nama/badge',
            'production_verify.required' => 'Kolom nama dan badge Production wajib diisi',
            'production_verify.regex' => 'Format penulisan Production harus sesuai: nama/badge'
        ]);

        $downtime->update([
            'qc_approve' => $validated['qc_approve'],
            'production_verify' => $validated['production_verify'],
            'status' => 'Completed',
            'tanggal_finish' => now()->toDateString(),
            'jam_finish' => now()->format('H:i')
        ]);

        return redirect()->route('rekapdowntime.index')
            ->with('success', 'Downtime berhasil disetujui dan telah selesai');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Redirect ke halaman index dengan pesan error untuk kesalahan format
        if ($e->validator->errors()->has('qc_approve') || $e->validator->errors()->has('production_verify')) {
            return redirect()->route('rekapdowntime.index')
                ->with('error', 'Persetujuan gagal: Format input tidak sesuai. Mohon gunakan format nama/badge');
        }
        // Untuk error validasi lainnya, kembali ke halaman sebelumnya
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal melakukan persetujuan: ' . $e->getMessage());
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
                $query->where('status', 'Menunggu QC Approve')
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
        return view('downtime.show-rekap', compact('downtime'));
    }

    public function RekapEdit($downtime)
    {
        $downtime = Downtime::findOrFail($downtime);
        return view('downtime.show-rekap', compact('downtime'));
    }

    // public function RekapUpdate(Request $request, $downtime)
    // {
    //     // Temukan record downtime yang sudah ada
    //     $downtime = Downtime::findOrFail($downtime);

    //     // Validasi data yang masuk
    //     $validated = $request->validate([
    //         'badge' => 'required',
    //         'line' => 'required',
    //         'leader' => 'required',
    //         'maintenance_repair' => 'nullable|string',
    //         'molding_machine' => 'nullable|string',
    //         'raised_ipqc' => 'nullable|string',
    //         'raised_operator' => 'nullable|string',
    //         'defect_category' => 'nullable|string',
    //         'problem_defect' => 'nullable|string',
    //         'root_cause' => 'nullable|string',
    //         'action_taken' => 'nullable|string',
    //         'production_verify' => 'nullable|string',
    //         'qc_approve' => 'nullable|string',
    //     ]);

    //       // Validasi berbeda untuk defect kategori kustom dan standar
    // if ($request->input('is_custom_defect', false)) {
    //     $validationRules['custom_defect_category'] = 'required|string|max:255';
    // } else {
    //     $validationRules['defect_category'] = 'required|exists:defects,id';
    // }

    // $validated = $request->validate($validationRules);

    // // Tentukan nilai defect_category yang akan diupdate
    // if ($request->input('is_custom_defect', false)) {
    //     $validated['defect_category'] = $request->custom_defect_category;
    // }

        
    //     $downtime->update($validated);

    //     // Alihkan dengan pesan sukses
    //     return redirect()->route('rekapdowntime.index')
    //         ->with('success', 'Rekap downtime berhasil diperbarui.');
    // }
    // public function RekapStore(Request $request, $downtime)
    // {
    //     try {
    //         // Validate the incoming request data
    //         $validated = $request->validate([
    //             'badge' => 'required',
    //             'line' => 'required',
    //             'leader' => 'required',
    //             'maintenance_repair' => 'nullable|string',
    //             'molding_machine' => 'nullable|string',
    //             'raised_ipqc' => 'nullable|string',
    //             'raised_operator' => 'nullable|string',
    //             // 'defect_category' => 'nullable|string',
    //             'problem_defect' => 'nullable|string',
    //             'root_cause' => 'nullable|string',
    //             'action_taken' => 'nullable|string',
    //             'production_verify' => 'nullable|string',
    //             'qc_approve' => 'nullable|string',

    //             // Add date and time fields if they are to be set during store
    //             'tanggal_submit' => 'nullable|date',
    //             'jam_submit' => 'nullable|date_format:H:i:s',
    //             'tanggal_start' => 'nullable|date',
    //             'jam_start' => 'nullable|date_format:H:i:s',
    //             'tanggal_finish' => 'nullable|date',
    //             'jam_finish' => 'nullable|date_format:H:i:s'
    //         ]);

    //         // Create a new Downtime record
    //         $downtime = Downtime::create([
    //             'badge' => $validated['badge'],
    //             'line' => $validated['line'],
    //             'leader' => $validated['leader'],
    //             'maintenance_repair' => $validated['maintenance_repair'] ?? null,
    //             'molding_machine' => $validated['molding_machine'] ?? null,
    //             'raised_ipqc' => $validated['raised_ipqc'] ?? null,
    //             'raised_operator' => $validated['raised_operator'] ?? null,
    //             // 'defect_category' => $validated['defect_category'] ?? null,
    //             'problem_defect' => $validated['problem_defect'] ?? null,
    //             'root_cause' => $validated['root_cause'] ?? null,
    //             'action_taken' => $validated['action_taken'] ?? null,
    //             'production_verify' => $validated['production_verify'] ?? null,
    //             'qc_approve' => $validated['qc_approve'] ?? null,

    //             // Set date and time fields if provided
    //             'tanggal_submit' => $validated['tanggal_submit'] ?? now()->toDateString(),
    //             'jam_submit' => $validated['jam_submit'] ?? now()->toTimeString(),
    //             'tanggal_start' => $validated['tanggal_start'] ?? null,
    //             'jam_start' => $validated['jam_start'] ?? null,
    //             'tanggal_finish' => $validated['tanggal_finish'] ?? null,
    //             'jam_finish' => $validated['jam_finish'] ?? null,

    //             // Optional: Set the user_id if you want to associate the record with the current user
    //                         ]);
    //             // Validasi berbeda untuk defect kategori kustom dan standar
    //             if ($request->input('is_custom_defect', false)) {
    //                 // Jika kustom, validasi input text
    //                 $validationRules['custom_defect_category'] = 'required|string|max:255';
    //             } else {
    //                 // Jika standar, validasi ID harus ada di tabel defects
    //                 $validationRules['defect_category'] = 'required|exists:defects,id';
    //             }

    //             $validated = $request->validate($validationRules);

    //             // Tentukan nilai defect_category yang akan disimpan
    //             if ($request->input('is_custom_defect', false)) {
    //                 $validated['defect_category'] = $request->custom_defect_category;
    //             }


    //         // Redirect with success message
    //         return redirect()->route('rekapdowntime.index')
    //             ->with('success', 'Rekap downtime berhasil dibuat.');
    //     } catch (\Exception $e) {
    //         // Log the error and redirect back with error message

    //         return redirect()->back()
    //             ->withInput()
    //             ->with('error', 'Failed to create downtime record: ' . $e->getMessage());
    //     }
    // }



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
        return redirect()->route('rekapdowntime.index')
            ->with('success', 'Rekap downtime berhasil diperbarui.');
    } catch (\Exception $e) {
        // Log error dan alihkan kembali dengan pesan error
        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
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
        return redirect()->route('rekapdowntime.index')
            ->with('success', 'Rekap downtime berhasil dibuat.');
    } catch (\Exception $e) {
        // Log error dan alihkan kembali dengan pesan error
        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal membuat rekap downtime: ' . $e->getMessage());
    }
}


    public function RekapDestroy(Downtime $downtime)
    {
        $downtime->delete();

        return redirect()->route('rekapdowntime.index')
            ->with('success', 'Rekap downtime berhasil dihapus.');
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
                }      });
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
