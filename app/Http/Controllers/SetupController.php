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
use Illuminate\Support\Facades\Storage;

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
        } elseif ($user->role === 'teknisi') {
            // Filter hanya setup yang maintenance_name-nya adalah user yang sedang login
            // dan statusnya belum completed
            $query->where('maintenance_name', $user->id);
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


        $busyTeknisiIds = array_merge(
            Setup::whereIn('status', ['Waiting', 'In Progress', 'Waiting QC Approve', 'Pending QC'])
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
        $mouldCategories = ['Mold Connector', 'Mold Inner', 'Mold Plug', 'Mold Grommet'];
        return view('setup.create', compact('user', 'mesins', 'mouldCategories', 'availableTeknisiUsers'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'leader' => 'required',
            'line' => 'required',
            'schedule_datetime' => 'required|date',
            'maintenance_name' => [
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
                        $fail('This technician is working on another setup that is still active.');
                    }

                    if ($busyInDowntime) {
                        $fail('This technician is handling active downtime.');
                    }
                }
            ],
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
                        $fail('Machine is already registered in active Downtime with status ' . $existingDowntime->status);
                    }

                    if ($existingSetup) {
                        $fail('The machine is already registered in the active Setup');
                    }
                }
            ]
        ]);



        $validated['status'] = 'Waiting';
        $validated['tanggal_submit'] = now()->toDateString();
        $validated['jam_submit'] = now()->toTimeString();
        $validated['user_id'] = $user->id;


        $setup = Setup::create($validated);

        // Create notifications for technicians
        $assignedTechnician = User::findOrFail($validated['maintenance_name']);
        $notification = Notifikasi::create([
            'user_id' => $assignedTechnician->id,
            'title' => 'New Setup Job - Molding M/C ' . $validated['molding_machine'],
            'message' => 'You have been assigned to a new setup job for Molding M/C ' . $validated['molding_machine'],
            'is_read' => false,
            'data' => json_encode([
                'setup_id' => $setup->id,
                'molding_machine' => $validated['molding_machine'],
                'redirect_url' => route('setup.index', $setup->id)
            ])
        ]);
        event(new NewNotification($notification));

        return redirect()->route('setup.create')
            ->with('success', 'Setup request created successfully!');
    }

    public function show(Setup $setup)
    {
        $mesins = Mesin::all();
        return view('setup.show-rekap', compact('setup', 'mesins'));
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

            $setup->status = 'In Progress';

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
            'maintenance_name' => 'required|exists:users,id',
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


        // Update data
        $setup->update($validated);
        return back()->with('success', 'The setup request was updated successfully.');
    }


    public function destroy(Setup $setup)
    {
        app(NotifikasiController::class)->deleteRelatedNotifications($setup->id, 'setup');

        $setup->delete();
        return redirect()->route('setup.index')
            ->with('success', 'Setup request successfully deleted.');
    }


    //================== FINISH SETUP MANAGEMENT ===================//


    public function finishSetupCreate()
    {
        // Ambil data setup yang belum selesai beserta ID nya
        $registeredMachines = Setup::Select('molding_machine', 'mould_type_mtc', 'marking_type_mtc', 'cable_grip_size_mtc')
            ->where('status', 'In Progress')
            ->orderBy('molding_machine')
            ->get();

        $setups = Setup::with('mesin')
            ->where('status', 'In Progress')
            ->get();
        return view('setup.createfinish', compact('registeredMachines', 'setups'));
    }
    public function finishSetupStore(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'molding_machine' => [
                'required',
                'exists:setup,id',
                function ($attribute, $value, $fail) {
                    $setup = Setup::find($value);
                    if (!$setup) {
                        return $fail('Setup tidak ditemukan.');
                    }
                    if (!$setup->tanggal_start || !$setup->jam_start) {
                        return $fail('Setup of this molding machine has not yet begun.');
                    }
                    if ($setup->tanggal_finish) {
                        return $fail('This molding machine setup has already been completed.');
                    }
                }
            ],

            'asset_no_bt' => 'required|string',
            'setup_problem' => 'required|string',
            'mould_type_mtc' => 'required|string',
            'marking_type_mtc' => 'required|string',
            'cable_grip_size_mtc' => 'required|string',
            'ampere_rating' => 'required|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,pdf|max:5120' // Menerima file gambar, video, dan PDF
        ]);

        try {
            $setup = Setup::findOrFail($validated['molding_machine']);

            // Siapkan data untuk update
            $updateData = [

                'asset_no_bt' => $validated['asset_no_bt'],
                'setup_problem' => $validated['setup_problem'],
                'mould_type_mtc' => $validated['mould_type_mtc'],
                'marking_type_mtc' => $validated['marking_type_mtc'],
                'cable_grip_size_mtc' => $validated['cable_grip_size_mtc'],
                'ampere_rating' => $validated['ampere_rating'],
                'status' => 'Waiting QC Approve'
            ];

            // Upload dokumentasi jika ada
            if ($request->hasFile('dokumentasi')) {
                $file = $request->file('dokumentasi');
                $filename = 'setup' . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('dokumentasi/', $filename, 'public');
                $updateData['dokumentasi'] = 'dokumentasi/' . $filename;
            }

            // Update setup record
            $setup->update($updateData);

            // Kirim notifikasi ke IPQC
            $ipqcUsers = User::where('role', 'ipqc')->get();
            foreach ($ipqcUsers as $ipqc) {
                Notifikasi::create([
                    'user_id' => $ipqc->id,
                    'title' => 'Setup Waiting Approval',
                    'message' => "There are setups that require QC approval for machines {$setup->molding_machine}",
                    'is_read' => false,
                    'data' => json_encode([
                        'downtime_id' => $setup->id,
                        'redirect_url' => route('setup.index', $setup->id)
                    ])
                ]);
            }

            return redirect()->route('setup.index')->with('success', 'Setup successfully Finish and waiting QC Approve');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to complete setup:  ' . $e->getMessage());
        }
    }
    public function finishSetupEdit($id)
    {
        // Get the specific setup that needs editing
        $setup = Setup::findOrFail($id);

        // Check if the setup is in the correct state to be edited
        if ($setup->status !== 'Waiting QC Approve') {
            return redirect()->back()->with('error', 'Only setups with Waiting QC Approve status can be changed');
        }

        return view('setup.editfinish', compact('setup'));
    }

    public function finishSetupUpdate(Request $request, $id)
    {
        $validated = $request->validate([

            'asset_no_bt' => 'required',
            'setup_problem' => 'required',
            'mould_type_mtc' => 'required',
            'marking_type_mtc' => 'required',
            'cable_grip_size_mtc' => 'required',
            'ampere_rating' => 'required',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,pdf|max:5120' // Menerima file gambar, video, dan PDF
        ]);

        try {
            // Find the setup by ID
            $setup = Setup::findOrFail($id);

            // Verify that the setup is in the correct state to be updated
            if ($setup->status !== 'Waiting QC Approve') {
                return redirect()->back()->with('error', 'Only setups with a status of Waiting QC Approve can be changed.');
            }

            // Prepare update data
            $updateData = [

                'asset_no_bt' => $validated['asset_no_bt'],
                'setup_problem' => $validated['setup_problem'],
                'mould_type_mtc' => $validated['mould_type_mtc'],
                'marking_type_mtc' => $validated['marking_type_mtc'],
                'cable_grip_size_mtc' => $validated['cable_grip_size_mtc'],
                'ampere_rating' => $validated['ampere_rating']
            ];

            // Upload dokumentasi if provided
            if ($request->hasFile('dokumentasi')) {
                $file = $request->file('dokumentasi');
                $filename = 'setup' . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('dokumentasi/', $filename, 'public');
                $updateData['dokumentasi'] = 'dokumentasi/' . $filename;

                // Delete old file if exists (optional)
                if ($setup->dokumentasi && Storage::disk('public')->exists($setup->dokumentasi)) {
                    Storage::disk('public')->delete($setup->dokumentasi);
                }
            }

            // Update the setup with all data including dokumentasi if provided
            $result = $setup->update($updateData);

            if ($result) {
                return redirect()->back()->with('success', 'Setup request updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to update setup request.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update setup:  ' . $e->getMessage());
        }
    }



    public function approve(Request $request, $id)
    {
        try {
            $setup = Setup::findOrFail($id);
            // Validasi status
            if ($setup->status !== 'Waiting QC Approve') {
                return redirect()->back()->with('error', 'Invalid setup status for approval');
            }

            // Validasi input dengan pesan bahasa Indonesia
            $validated = $request->validate([
                'marking' => 'required|in:Pass,Failed',
                'relief' => 'required|in:Pass,Failed',
                'mismatch' => 'required|in:Pass,Failed',
                'pin_bar_connector' => 'required|in:Pass,Failed',
                'marking_remarks' => 'required_if:marking,Failed',
                'relief_remarks' => 'required_if:relief,Failed',
                'mismatch_remarks' => 'required_if:mismatch,Failed',
                'pin_bar_connector_remarks' => 'required_if:pin_bar_connector,Failed',
                'qc_approve' => [
                    'required',
                    'string',
                    'regex:/^[^\/]+\/[^\/]+$/',
                ]
            ], [
                'marking.required' => 'Status marking check must be selected',
                'marking.in' => 'Status marking check is invalid',
                'relief.required' => 'Status relief check must be selected',
                'relief.in' => 'Status relief check is invalid',
                'mismatch.required' => 'Status mismatch check must be selected',
                'mismatch.in' => 'Status mismatch check is invalid',
                'pin_bar_connector.required' => 'Status pin bar check must be selected',
                'pin_bar_connector.in' => 'Status pin bar check is invalid',
                'marking_remarks.required_if' => 'Please provide remarks for marking check failure',
                'relief_remarks.required_if' => 'Please provide remarks for relief check failure',
                'mismatch_remarks.required_if' => 'Please provide remarks for mismatch check failure',
                'pin_bar_connector_remarks.required_if' => 'Please provide remarks for pin bar connector check failure',
                'qc_approve.required' => 'QC name and badge field must be filled',
                'qc_approve.regex' => 'QC writing format must be: name/badge',
            ]);

            // Determine the status based on check results
            $allPassed =
                $validated['marking'] === 'Pass' &&
                $validated['relief'] === 'Pass' &&
                $validated['mismatch'] === 'Pass' &&
                $validated['pin_bar_connector'] === 'Pass';

            // Ubah status menjadi "Pending QC" jika ada yang gagal, "Completed" jika semua lulus
            $newStatus = $allPassed ? 'Completed' : 'Pending QC';

            // Prepare data for update
            $updateData = [
                'qc_approve' => $validated['qc_approve'],
                'status' => $newStatus
            ];

            // Set the values for each check
            // If failed, store the value with remarks; if passed, store just "Pass"
            $updateData['marking'] = $validated['marking'] === 'Failed'
                ? 'Failed: ' . $request->input('marking_remarks')
                : 'Pass';

            $updateData['relief'] = $validated['relief'] === 'Failed'
                ? 'Failed: ' . $request->input('relief_remarks')
                : 'Pass';

            $updateData['mismatch'] = $validated['mismatch'] === 'Failed'
                ? 'Failed: ' . $request->input('mismatch_remarks')
                : 'Pass';

            $updateData['pin_bar_connector'] = $validated['pin_bar_connector'] === 'Failed'
                ? 'Failed: ' . $request->input('pin_bar_connector_remarks')
                : 'Pass';

            // Only set finish date and time if all checks pass
            if ($allPassed) {
                $updateData['tanggal_finish'] = now()->toDateString();
                $updateData['jam_finish'] = now()->format('H:i');
            }

            // Update the setup record
            $setup->update($updateData);

            if ($allPassed) {
                return redirect()->route('setup.index')
                    ->with('success', 'Setup successfully approved and completed');
            } else {
                return redirect()->route('setup.index')
                    ->with('warning', 'Setup was checked but some checks failed. Status changed to Pending QC.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to Approve: ' . $e->getMessage());
        }
    }

    public function QcUpdate(Request $request, $id)
    {
        try {
            $setup = Setup::findOrFail($id);
            // Validate status
            if ($setup->status !== 'Pending QC') {
                return redirect()->back()->with('error', 'Invalid setup status for update');
            }

            // Validate input
            $validated = $request->validate([
                'marking' => 'required|in:Pass,Failed',
                'relief' => 'required|in:Pass,Failed',
                'mismatch' => 'required|in:Pass,Failed',
                'pin_bar_connector' => 'required|in:Pass,Failed',
                'marking_remarks' => 'required_if:marking,Failed',
                'relief_remarks' => 'required_if:relief,Failed',
                'mismatch_remarks' => 'required_if:mismatch,Failed',
                'pin_bar_connector_remarks' => 'required_if:pin_bar_connector,Failed',
                'qc_approve' => [
                    'required',
                    'string',
                    'regex:/^[^\/]+\/[^\/]+$/',
                ]
            ], [
                'marking.required' => 'Status marking check must be selected',
                'marking.in' => 'Status marking check is invalid',
                'relief.required' => 'Status relief check must be selected',
                'relief.in' => 'Status relief check is invalid',
                'mismatch.required' => 'Status mismatch check must be selected',
                'mismatch.in' => 'Status mismatch check is invalid',
                'pin_bar_connector.required' => 'Status pin bar check must be selected',
                'pin_bar_connector.in' => 'Status pin bar check is invalid',
                'marking_remarks.required_if' => 'Please provide remarks for marking check failure',
                'relief_remarks.required_if' => 'Please provide remarks for relief check failure',
                'mismatch_remarks.required_if' => 'Please provide remarks for mismatch check failure',
                'pin_bar_connector_remarks.required_if' => 'Please provide remarks for pin bar connector check failure',
                'qc_approve.required' => 'QC name and badge field must be filled',
                'qc_approve.regex' => 'QC writing format must be: name/badge',
            ]);

            // Determine the status based on check results
            $allPassed =
                $validated['marking'] === 'Pass' &&
                $validated['relief'] === 'Pass' &&
                $validated['mismatch'] === 'Pass' &&
                $validated['pin_bar_connector'] === 'Pass';

            // Update status to "Completed" if all checks pass, keep as "Pending QC" otherwise
            $newStatus = $allPassed ? 'Completed' : 'Pending QC';

            // Prepare data for update
            $updateData = [
                'qc_approve' => $validated['qc_approve'],
                'status' => $newStatus
            ];

            // Set the values for each check
            // If failed, store the value with remarks; if passed, store just "Pass"
            $updateData['marking'] = $validated['marking'] === 'Failed'
                ? 'Failed: ' . $request->input('marking_remarks')
                : 'Pass';

            $updateData['relief'] = $validated['relief'] === 'Failed'
                ? 'Failed: ' . $request->input('relief_remarks')
                : 'Pass';

            $updateData['mismatch'] = $validated['mismatch'] === 'Failed'
                ? 'Failed: ' . $request->input('mismatch_remarks')
                : 'Pass';

            $updateData['pin_bar_connector'] = $validated['pin_bar_connector'] === 'Failed'
                ? 'Failed: ' . $request->input('pin_bar_connector_remarks')
                : 'Pass';

            // Only set finish date and time if all checks pass
            if ($allPassed) {
                $updateData['tanggal_finish'] = now()->toDateString();
                $updateData['jam_finish'] = now()->format('H:i');
            }

            // Update the setup record
            $setup->update($updateData);

            if ($allPassed) {
                return redirect()->route('setup.index')
                    ->with('success', 'Setup successfully updated and completed');
            } else {
                return redirect()->route('setup.index')
                    ->with('warning', 'Setup has been updated but some checks still failed. Status remains as Pending QC.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to Update: ' . $e->getMessage());
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
                $query->where('status', 'Waiting QC Approve')
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
        $user = Auth::user();
        $mesins = Mesin::all(); // Assuming you have a Mesin model
        return view('setup.show-rekap', compact('setup', 'mesins', 'user'));
    }

    public function RekapEdit($setup)
    {
        // Ambil data setup untuk diedit
        $setup = Setup::findOrFail($setup);
        $mesins = Mesin::all(); // Assuming you have a Mesin model
        return view('setup.show-rekap', compact('setup', 'mesins '));
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

        return redirect()->route('setup.index')
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
            return redirect()->route('setup.index')
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
        return redirect()->route('setup.index')
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
