<?php

namespace App\Http\Controllers;

use App\Models\Setup;
use App\Models\Downtime;
use App\Models\Mesin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Notifikasi;
use App\Traits\HasNotifications;
use App\Events\NewNotification;

class SetupController extends Controller
{
    use HasNotifications;
    public function index(Request $request)
    {
        // Get authenticated user
        $user = Auth::user();

        // Get pagination and search parameters
        $perPage = $request->input('show', 10);
        $search = $request->input('search');
        $filterType = $request->input('filter_type', 'all');
        $status = $request->input('status');

        // Initialize base query with relationships
        $query = Setup::with('user', 'mesin');

        // Role-based access control for incomplete records
        if ($user->role === 'leader') {
            // Filter hanya downtime yang terkait dengan user leader dan mesin valid
            $query->where('user_id', $user->id)
                ->whereHas('mesin', function ($q) {
                    $q->whereNotNull('molding_mc');
                });
        } else {
            // Other roles see all records but only with status 'Menunggu' or 'Sedang Diproses'
            $query->whereIn('status', ['Menunggu', 'Sedang Diproses', 'Menunggu QC Approve']);
        }



        if ($status) {
            $query->where('status', $status);
        }


        // Apply search filters if search term exists
        if ($search) {
            $query->where(function ($query) use ($search, $filterType) {
                switch ($filterType) {
                    case 'line':
                        $query->where('line', 'like', "%{$search}%");
                        break;

                    case 'mould_type':
                        $query->where('mould_type', 'like', "%{$search}%");
                        break;

                    case 'part_number':
                        $query->where('part_number', 'like', "%{$search}%");
                        break;

                    case 'customer':
                        $query->where('customer', 'like', "%{$search}%");
                        break;
                    case 'leader':
                        $query->where('leader', 'like', "%{$search}%");
                        break;

                    case 'schedule_datetime':
                        $query->where('schedule_datetime', 'like', "%{$search}%");
                        break;

                    case 'mould_category':
                        $query->where('mould_category', 'like', "%{$search}%");
                        break;

                    case 'molding_mc':
                        $query->whereHas('mesin', function ($q) use ($search) {
                            $q->where('molding_mc', 'like', "%{$search}%");
                        });
                        break;

                    default: // 'all'
                        // Search across all relevant fields
                        $query->where(function ($q) use ($search) {
                            $q->where('line', 'like', "%{$search}%")
                                ->orWhere('mould_type', 'like', "%{$search}%")
                                ->orWhere('part_number', 'like', "%{$search}%")
                                ->orWhere('customer', 'like', "%{$search}%")
                                ->orWhere('leader', 'like', "%{$search}%")
                                ->orWhere('schedule_datetime', 'like', "%{$search}%")
                                ->orWhere('mould_category', 'like', "%{$search}%")
                                ->orWhereHas('mesin', function ($mq) use ($search) {
                                    $mq->where('molding_mc', 'like', "%{$search}%");
                                });
                        });
                }
            });
        }

        // Execute query with pagination
        $setups = $query->latest()->paginate($perPage);
        $mesins = Mesin::all();

        // Return view with all necessary data
        return view('setup.index', compact(
            'setups',
            'mesins',
            'perPage',
            'search',
            'filterType',
            'user'
        ));
    }
    public function create()
    {
        $user = Auth::user();
        $mesins = Mesin::all();
        $mouldCategories = ['Mold Connector', 'Mold Inner', 'Mold Plug', 'Mold Grommet'];
        return view('setup.create', compact('user', 'mesins', 'mouldCategories'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'leader' => 'required',
            'line' => 'required',
            'schedule_datetime' => 'required|date',
            'part_number' => 'required',
            'qty_product' => 'required|numeric',
            'customer' => 'required',
            'mould_type' => 'required',
            'mould_cavity' => 'required',
            'mould_category' => 'required|in:Mold Connector,Mold Inner,Mold Plug,Mold Grommet',
            'marking_type' => 'required',
            'job_request' => 'required',
            'cable_grip_size' => 'required',
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
                    if ($existingDowntime) {
                        $fail('Mesin sudah terdaftar dalam Downtime aktif dengan status ' . $existingDowntime->status);
                    }
    
                    if ($existingSetup) {
                        $fail('Mesin sudah terdaftar dalam Setup aktif');
                    }
                }
            ]
        ]);


        // $validated['issued_date'] = $validated['schedule_datetime'];
        $validated['status'] = 'Menunggu';
        $validated['tanggal_submit'] = now()->toDateString();
        $validated['jam_submit'] = now()->toTimeString();
        // $validated['tanggal_start'] = null;
        // $validated['jam_start'] = null;
        $validated['user_id'] = $user->id;


        $setup = Setup::create($validated);

        // Create notifications for technicians
        $teknisiUsers = User::where('role', 'teknisi')->get();

        foreach ($teknisiUsers as $teknisi) {
            $notification = Notifikasi::create([
                'user_id' => $teknisi->id,
                'title' => 'Permintaan Setup Baru',
                'message' => 'Ada laporan Setup',
                'is_read' => false,
                'data' => json_encode([
                    'setup_id' => $setup->id,
                    'redirect_url' => route('setup.index', $setup->id)
                ])
            ]);
            broadcast(new NewNotification($notification))->toOthers();
        }
        return redirect()->route('setup.create')
            ->with('success', 'Permintaan setup berhasil dibuat!');
    }



    public function show(Setup $setup)
    {
        $mesins = Mesin::all();
        return view('setup.show', compact('setup', 'mesins'));
    }


    public function edit(Setup $setup)
    {
        // $mouldCategories = ['Mould A', 'Mould B', 'Mould C'];
        $mesins = Mesin::all();
        return view('setup.edit', compact('setup', 'mesins'));
    }

    public function start(Request $request, $id)
    {
        try {
            $setup = Setup::findOrFail($id);

            $setup->status = 'Sedang Diproses';

            // Gunakan data yang dikirim dari JavaScript
            $setup->tanggal_start = $request->input('date', now()->toDateString());
            $setup->jam_start = $request->input('time', now()->toTimeString());
            $setup->save();

            return response()->json([
                'success' => true,
                'status' => $setup->status,
                'date' => $setup->tanggal_start_formatted,
                'time' => $setup->jam_start_formatted
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error starting setup: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Setup $setup)
    {
        $validated = $request->validate([
            'line' => 'required',
            'leader' => 'required',
            'schedule_datetime' => 'required|date',
            'part_number' => 'required',
            'qty_product' => 'required|numeric',
            'customer' => 'required',
            'mould_type' => 'required',
            'mould_category' => 'required|in:Mold Connector,Mold Inner,Mold Plug,Mold Grommet',
            'marking_type' => 'required',
            'mould_cavity' => 'required',
            'cable_grip_size' => 'required',
            'molding_machine' => 'required|exists:mesin,id',
            'job_request' => 'required'
        ]);

        // $validated['issued_date'] = $validated['schedule_datetime'];
        // Update data
        $setup->update($validated);
        return redirect()->route('setup.index')->with('success', 'Permintaan setup berhasil diperbarui.');
    }


    public function destroy(Setup $setup)
    {
        $setup->delete();
        return redirect()->route('setup.index')
            ->with('success', 'Setup berhasil dihapus.');
    }











    //================== FINISH SETUP MANAGEMENT ===================//


    public function finishSetupCreate()
    {
        // Ambil data setup yang belum selesai beserta ID nya
        $registeredMachines = Setup::Select('molding_machine', 'mould_type_mtc', 'marking_type_mtc', 'cable_grip_size_mtc', 'issued_date')
            ->where('status', 'Sedang Diproses')
            ->orderBy('molding_machine')
            ->get();

        $setups = Setup::with('mesin')
            ->where('status', 'Sedang Diproses')
            ->get();
        return view('setup.createfinish', compact('registeredMachines', 'setups'));
    }
    public function finishSetupStore(Request $request)
    {

        $validated = $request->validate([
            'molding_machine' => [
                'required',
                'exists:setup,id',
                function ($attribute, $value, $fail) {
                    // Periksa apakah setup sudah dimulai
                    $setup = Setup::findOrFail($value);

                    if (!$setup->tanggal_start || !$setup->jam_start) {
                        $fail('Setup mesin molding ini belum dimulai.');
                    }
                    if ($setup->tanggal_finish) {
                        $fail('Setup mesin molding ini sudah pernah diselesaikan.');
                    }
                }
            ],
            'issued_date' => 'required|date',
            'asset_no_bt' => 'required',
            'maintenance_name' => 'required',
            'setup_problem' => 'required',
            'mould_type_mtc' => 'required',
            'marking_type_mtc' => 'required',
            'cable_grip_size_mtc' => 'required',
            'ampere_rating' => 'required'
        ]);


        try {
            // Gunakan model yang konsisten
            $finishSetup = Setup::findOrFail($validated['molding_machine']);


            $result = $finishSetup->update([
                'issued_date' => $validated['issued_date'],
                'asset_no_bt' => $validated['asset_no_bt'],
                'maintenance_name' => $validated['maintenance_name'],
                'setup_problem' => $validated['setup_problem'],
                'mould_type_mtc' => $validated['mould_type_mtc'],
                'marking_type_mtc' => $validated['marking_type_mtc'],
                'cable_grip_size_mtc' => $validated['cable_grip_size_mtc'],
                'ampere_rating' => $validated['ampere_rating'],
                'status' => 'Menunggu QC Approve'

            ]);


            if ($result) {

                // Notify IPQC
                $ipqcUsers = User::where('role', 'ipqc')->get();
                foreach ($ipqcUsers as $ipqc) {
                    Notifikasi::create([
                        'user_id' => $ipqc->id,
                        'title' => 'Setup Menunggu Approval',
                        'message' => "Ada setup yang memerlukan approval QC untuk mesin {$finishSetup->molding_machine}",
                        'is_read' => false,
                        'data' => json_encode([
                            'downtime_id' => $finishSetup->id,
                            'redirect_url' => route('rekapsetup.index', $finishSetup->id)
                        ])
                    ]);
                }
                return redirect()->route('finishsetup.create')->with('success', 'Setup berhasil diselesaikan dan menunggu QC approve');
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan setup');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan setup: ' . $e->getMessage());
        }
    }




    public function approve(Request $request, $id)
    {
        try {
            $setup = Setup::findOrFail($id);
            // Validasi status
            if ($setup->status !== 'Menunggu QC Approve') {
                return redirect()->back()->with('error', 'Status setup tidak valid untuk persetujuan');
            }

            // Validasi input dengan pesan bahasa Indonesia
            $validated = $request->validate([
                'marking' => 'required|in:Pass,Failed',
                'relief' => 'required|in:Pass,Failed',
                'mismatch' => 'required|in:Pass,Failed',
                'pin_bar_connector' => 'required|in:Pass,Failed',
                'qc_approve' => [
                    'required',
                    'string',
                    'regex:/^[^\/]+\/[^\/]+$/',
                ]
            ], [
                'marking.required' => 'Status marking check wajib dipilih',
                'marking.in' => 'Status marking check tidak valid',
                'relief.required' => 'Status relief check wajib dipilih',
                'relief.in' => 'Status relief check tidak valid',
                'mismatch.required' => 'Status mismatch check wajib dipilih',
                'mismatch.in' => 'Status mismatch check tidak valid',
                'pin_bar_connector.required' => 'Status pin bar check wajib dipilih',
                'pin_bar_connector.in' => 'Status pin bar check tidak valid',
                'qc_approve.required' => 'Kolom nama dan badge QC wajib diisi',
                'qc_approve.regex' => 'Format penulisan QC harus sesuai: nama/badge',
            ]);

            // Update data setup
            $setup->update([
                'marking' => $validated['marking'],
                'relief' => $validated['relief'],
                'mismatch' => $validated['mismatch'],
                'pin_bar_connector' => $validated['pin_bar_connector'],
                'qc_approve' => $validated['qc_approve'],
                'tanggal_finish' => now()->toDateString(),
                'jam_finish' => now()->format('H:i'),
                'status' => 'Completed'
            ]);

            return redirect()->route('rekapsetup.index')
                ->with('success', 'Setup berhasil disetujui dan telah selesai');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal Appeove: ' . $e->getMessage());
        }
    }
    public function RekapIndex(Request $request)
    {
        try {
            $perPage = $request->input('show', 10);
            $user = Auth::user();
            $mesins = Mesin::all();


            // Query dasar untuk Setup
            $query = Setup::with('user');

            // Filter berdasarkan role user
            if ($user->role === 'ipqc') {
                $query->where('status', 'Menunggu QC Approve')
                    ->whereNull('qc_approve');
            } else {
                // Untuk leader, teknisi, dan admin
                $query->where('status', 'Completed');
            }

            $setups = $query->latest()
                ->paginate($perPage);
            return view('setup.index-rekap', compact('setups', 'perPage', 'mesins'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data rekap: ' . $e->getMessage());
        }
    }
    public function RekapShow($setup)
    {
        $setup = Setup::findOrFail($setup);
        return view('setup.show-rekap', compact('setup'));
    }
    public function RekapEdit($setup)
    {
        // Ambil data setup untuk diedit
        $setup = Setup::findOrFail($setup);
        return view('setup.editrekap', compact('setup'));
    }

    public function RekapUpdate(Request $request, $setup)
    {
        // Comprehensive validation
        $validatedData = $request->validate([
            'leader' => 'required',
            'line' => 'required|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'qty_product' => 'nullable|integer',
            'customer' => 'nullable|string|max:255',
            'mould_type' => 'nullable|string|max:255',
            'mould_category' => 'nullable|string|max:255',
            'marking_type' => 'nullable|string|max:255',
            'mould_cavity' => 'nullable|string|max:255',
            'cable_grip_size' => 'nullable|string|max:255',
            'molding_machine' => 'nullable|string|max:255',
            'asset_no_bt' => 'nullable|string|max:255',
            'maintenance_name' => 'required|string|max:255',
            'setup_problem' => 'nullable|string',
            'mould_type_mtc' => 'nullable|string|max:255',
            'marking_type_mtc' => 'nullable|string|max:255',
            'cable_grip_size_mtc' => 'nullable|string|max:255',
            'ampere_rating' => 'nullable|string|max:255',
            'marking' => 'nullable|string',
            'relief' => 'nullable|string',
            'mismatch' => 'nullable|string',
            'pin_bar_connector' => 'nullable|string',
            'qc_approve' => 'nullable|string'

        ]);

        $setup = Setup::findOrFail($setup);
        $setup->update($validatedData);

        return redirect()->route('rekapsetup.index')
            ->with('success', 'Rekap setup berhasil diperbarui');
    }

    public function RekapStore(Request $request, $setup)
    {
        // Validasi input data
        $validated = $request->validate([
            'leader' => 'required',
            'line' => 'required|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'qty_product' => 'nullable|integer',
            'customer' => 'nullable|string|max:255',
            'mould_type' => 'nullable|string|max:255',
            'mould_category' => 'nullable|string|max:255',
            'marking_type' => 'nullable|string|max:255',
            'mould_cavity' => 'nullable|string|max:255',
            'cable_grip_size' => 'nullable|string|max:255',
            'molding_machine' => 'nullable|string|max:255',
            'asset_no_bt' => 'nullable|string|max:255',
            'maintenance_name' => 'required|string|max:255',
            'setup_problem' => 'nullable|string',
            'mould_type_mtc' => 'nullable|string|max:255',
            'marking_type_mtc' => 'nullable|string|max:255',
            'cable_grip_size_mtc' => 'nullable|string|max:255',
            'ampere_rating' => 'nullable|string|max:255',
            'marking' => 'nullable|string',
            'relief' => 'nullable|string',
            'mismatch' => 'nullable|string',
            'pin_bar_connector' => 'nullable|string',
            'qc_approve' => 'nullable|string'
        ]);

        try {

            // Buat instance baru dari model Setup
            $setup = Setup::create($validated);

            // Redirect dengan pesan sukses
            return redirect()->route('rekapsetup.index')
                ->with('success', 'Data Setup berhasil disimpan');
        } catch (\Exception $e) {
            // Tangani error dengan logging atau pesan error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }


    public function RekapDestroy(Setup $setup)
    {
        $setup->delete();
        return redirect()->route('rekapsetup.index')
            ->with('success', 'Rekap setup berhasil dihapus.');
    }

    public function RekapSearch(Request $request)
    {
        $perPage = $request->input('show', 10);
        $search = trim($request->input('search', ''));
        $filterType = $request->input('filter_type', 'all');

        // Buat query dasar
        $query = Setup::query();


        // Filter untuk memastikan tanggal_finish tidak null dan tidak kosong
        $query->whereNotNull('tanggal_finish')
            ->where('tanggal_finish', '!=', '');

        // Terapkan pencarian jika ada search term
        if ($search) {
            $query->where(function ($query) use ($search, $filterType) {
                switch ($filterType) {
                    case 'leader':
                        $query->where('leader', 'like', "%{$search}%");
                        break;

                    case 'line':
                        $query->where('line', 'like', "%{$search}%");
                        break;

                    case 'maintenance_name':
                        $query->where('maintenance_name', 'like', "%{$search}%");
                        break;
                    case 'qc_approve':
                        $query->where('qc_approve', 'like', "%{$search}%");
                        break;

                    case 'mould_type':
                        $query->where('mould_type', 'like', "%{$search}%");
                        break;

                    case 'part_number':
                        $query->where('part_number', 'like', "%{$search}%");
                        break;

                    case 'customer':
                        $query->where('customer', 'like', "%{$search}%");
                        break;

                    case 'schedule_datetime':
                        $query->where('schedule_datetime', 'like', "%{$search}%");
                        break;

                    case 'mould_category':
                        $query->where('mould_category', 'like', "%{$search}%");
                        break;

                    case 'molding_mc':
                        $query->whereHas('mesin', function ($q) use ($search) {
                            $q->where('molding_mc', 'like', "%{$search}%");
                        });
                        break;
                    
                    default: // 'all'
                        // Search across all relevant fields
                        $query->where(function ($q) use ($search) {
                            $q->where('line', 'like', "%{$search}%")
                            ->orWhere('leader', 'like', "%{$search}%")
                            ->orWhere('maintenance_name', 'like', "%{$search}%")
                            ->orWhere('qc_approve', 'like', "%{$search}%")
                                ->orWhere('mould_type', 'like', "%{$search}%")
                                ->orWhere('part_number', 'like', "%{$search}%")
                                ->orWhere('customer', 'like', "%{$search}%")
                                ->orWhere('schedule_datetime', 'like', "%{$search}%")
                                ->orWhere('mould_category', 'like', "%{$search}%")
                                
                                ->orWhereHas('mesin', function ($mq) use ($search) {
                                    $mq->where('molding_mc', 'like', "%{$search}%");
                                });
                        });
                }
            });
        }
        $mesins = Mesin::all();


        // Urutkan berdasarkan tanggal submit
        $query->orderBy('tanggal_finish', 'desc');

        // Lakukan paginasi
        $setups = $query->latest()->paginate($perPage);

        return view('setup.index-rekap', compact(
            'setups',
            'search',
            'mesins',
            'perPage',
            'filterType'
        ));
    }
    public function getUnfinishedSetups()
    {
        $count = Setup::where('status', '!=', 'Completed')->count();
        return response()->json(['count' => $count]);
    }
}
