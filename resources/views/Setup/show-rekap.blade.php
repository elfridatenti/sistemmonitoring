@extends('layout.header-sidebar')

@section('content')

    <!-- Custom CSS -->
    <style>
        /* Card and Container Styles */
        .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .info-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        /* Hover Effects */
        .hover-shadow:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .hover-scale {
            transition: transform 0.2s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .hover-translate {
            transition: transform 0.2s ease;
        }

        .hover-translate:hover {
            transform: translateX(5px);
        }

        /* Timeline Styles */
        .timeline-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .timeline-item:hover .timeline-icon {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Info Item Styles */
        .info-item {
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .info-item:hover {
            background-color: rgba(255, 255, 255, 0.7);
            transform: translateX(5px);
        }

        /* Button Styles */
        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* General Transitions */
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Shadow Styles */
        .shadow-lg {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .shadow-sm {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
        }

        /* Badge Styles */
        .badge {
            padding: 0.5em 1em;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        /* Text and Background Colors */
        .bg-light {
            background-color: #f8f9fa !important;
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        /* Border Styles */
        .border-bottom {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
        }

        .rounded-3 {
            border-radius: 0.5rem !important;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }

            .info-card {
                margin-bottom: 1rem;
            }

            .timeline-item {
                margin-bottom: 1.5rem;
            }
        }

        .bg-gradient-primary {
            background: linear-gradient(120deg, #3a62ac, #2c4b8a);
            color: white;
            border-bottom: none;
        }

        /* Status Badge Colors */
        .badge-waiting {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-in-progress {
            background-color: #17a2b8;
            color: white;
        }

        .badge-waiting-qc-approve {
            background-color: #fd7e14;
            color: white;
        }

        .badge-pending-qc {
            background-color: #f5d017;
            color: white;
        }

        .badge-completed {
            background-color: #28a745;
            color: white;
        }

        /* Status banner */
        .status-banner {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .status-waiting {
            background-color: rgba(255, 193, 7, 0.2);
            border-left: 4px solid #ffc107;
        }

        .status-in-progress {
            background-color: rgba(23, 162, 184, 0.2);
            border-left: 4px solid #17a2b8;
        }

        .status-waiting-qc-approve {
            background-color: rgba(253, 126, 20, 0.2);
            border-left: 4px solid #fd7e14;
        }

        .status-pending-qc {
            background-color: rgba(224, 177, 35, 0.2);
            border-left: 4px solid #decd11;
        }

        .status-completed {
            background-color: rgba(40, 167, 69, 0.2);
            border-left: 4px solid #28a745;
        }

        /* Inline edit styles */
        .editable-field {
            display: block;
            width: 100%;
            border: 1px solid transparent;
            padding: 0.375rem 0;
            transition: all 0.3s;
        }

        .editable-field.active {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
            background-color: #fff;
        }

        .edit-buttons {
            display: none;
        }

        .edit-buttons.show {
            display: flex;
            margin-top: 15px;
        }

        .readonly-field {
            cursor: not-allowed;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg transition-all">

                    <!-- Card Header -->
                    <div class="card-header bg-gradient-primary border-bottom-0 rounded-top-4 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="modal-icon bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-tools text-light fs-4"></i>
                                </div>
                                <h5 class="modal-title mb-0">REQUEST SETUP DETAILS</h5>
                            </div>
                            <div>
                                <a href="{{ route('setup.index') }}" class="btn btn-outline-light hover-scale">
                                    <i class="bi bi-arrow-left me-1"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <div>{{ session('success') }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <div>{{ session('error') }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('info'))
                            <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <div>{{ session('info') }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <!-- Status Banner - Moved here -->
                        <div
                            class="status-banner status-{{ strtolower(str_replace(' ', '-', $setup->status)) }} d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-info-circle me-2"></i>
                                Status: <span
                                    class="badge badge-{{ strtolower(str_replace(' ', '-', $setup->status)) }} me-2 hover-scale">
                                    {{ $setup->status }}
                                </span>
                            </div>

                            @if ($setup->status == 'Completed' && Auth::user()->role == 'admin')
                                <button type="button" id="toggleAdminEdit" class="btn btn-sm btn-primary hover-scale">
                                    <i class="fas fa-edit me-1"></i> <span id="adminEditBtnText">Edit</span>
                                </button>
                            @endif
                        </div>


                        <form id="editProductionForm" action="{{ route('setup.update', $setup) }}" method="POST"
                            class="p-0 m-0">
                            @csrf
                            @method('PUT')
                            <div class="p-3 bg-light rounded-3 info-card hover-shadow mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary mb-3 border-bottom pb-2">Request Item by Production</h6>
                                    <!-- Leader Edit Button (visible only if user is leader and status is Waiting) -->
                                    @if ($setup->status == 'Waiting' && Auth::user()->role == 'leader')
                                        <button type="button" id="toggleEdit"
                                            class="btn btn-sm btn-warning hover-scale mb-3">
                                            <i class="fas fa-edit me-1"></i> <span id="editBtnText">Edit</span>
                                        </button>
                                    @endif
                                </div>

                                <!-- Row 1 - Leader, Line, Schedule -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Leader</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="leader_text">{{ $setup->user->nama ?? 'N/A' }}</span>
                                                <input type="text" name="leader_display" id="leader_input"
                                                    class="form-control d-none" value="{{ $setup->user->nama }}" readonly
                                                    style="cursor: not-allowed; background-color: #f8f9fa;">
                                                <input type="hidden" name="leader" id="leader_hidden"
                                                    value="{{ $setup->user_id }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Line</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="line_text">{{ $setup->line ?? 'N/A' }}</span>
                                                <input type="text" name="line" id="line_input"
                                                    class="form-control d-none" value="{{ $setup->line }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Schedule DateTime</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="schedule_datetime_text">{{ \Carbon\Carbon::parse($setup->schedule_datetime)->format('d M Y, H:i') }}</span>
                                                <input type="datetime-local" name="schedule_datetime"
                                                    id="schedule_datetime_input" class="form-control d-none"
                                                    value="{{ \Carbon\Carbon::parse($setup->schedule_datetime)->format('Y-m-d\TH:i') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 2 - Maintenance, Part Number, Customer -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Maintenance Name</label>
                                            <div class="fw-medium">
                                                <span class="editable-field" id="maintenance_name_text">
                                                    @if ($setup->maintenance_name)
                                                        {{ App\Models\User::where('id', $setup->maintenance_name)->where('role', 'teknisi')->first()->nama ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                                <input type="text" name="maintenance_name_display"
                                                    id="maintenance_name_input" class="form-control d-none"
                                                    value="@if ($setup->maintenance_name) {{ App\Models\User::where('id', $setup->maintenance_name)->where('role', 'teknisi')->first()->nama ?? 'N/A' }}@else N/A @endif"
                                                    readonly style="cursor: not-allowed; background-color: #f8f9fa;">
                                                <input type="hidden" name="maintenance_name"
                                                    id="maintenance_name_hidden" value="{{ $setup->maintenance_name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Part Number</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="part_number_text">{{ $setup->part_number ?? 'N/A' }}</span>
                                                <input type="text" name="part_number" id="part_number_input"
                                                    class="form-control d-none" value="{{ $setup->part_number }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Customer</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="customer_text">{{ $setup->customer ?? 'N/A' }}</span>
                                                <input type="text" name="customer" id="customer_input"
                                                    class="form-control d-none" value="{{ $setup->customer }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 3 - Qty Product, Mould Type, Mould Category -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Quantity Product</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="qty_product_text">{{ $setup->qty_product ?? 'N/A' }}</span>
                                                <input type="number" name="qty_product" id="qty_product_input"
                                                    class="form-control d-none" value="{{ $setup->qty_product }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Mould Type</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="mould_type_text">{{ $setup->mould_type ?? 'N/A' }}</span>
                                                <input type="text" name="mould_type" id="mould_type_input"
                                                    class="form-control d-none" value="{{ $setup->mould_type }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Mould Category</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="mould_category_text">{{ $setup->mould_category ?? 'N/A' }}</span>
                                                <select name="mould_category" id="mould_category_input"
                                                    class="form-select d-none">
                                                    <option value="Mold Connector"
                                                        {{ $setup->mould_category == 'Mold Connector' ? 'selected' : '' }}>
                                                        Mold Connector</option>
                                                    <option value="Mold Inner"
                                                        {{ $setup->mould_category == 'Mold Inner' ? 'selected' : '' }}>
                                                        Mold Inner</option>
                                                    <option value="Mold Plug"
                                                        {{ $setup->mould_category == 'Mold Plug' ? 'selected' : '' }}>
                                                        Mold Plug</option>
                                                    <option value="Mold Grommet"
                                                        {{ $setup->mould_category == 'Mold Grommet' ? 'selected' : '' }}>
                                                        Mold Grommet</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 4 - Marking Type, Mould Cavity, Cable Grip Size -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Marking Type</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="marking_type_text">{{ $setup->marking_type ?? 'N/A' }}</span>
                                                <input type="text" name="marking_type" id="marking_type_input"
                                                    class="form-control d-none" value="{{ $setup->marking_type }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Mould Cavity</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="mould_cavity_text">{{ $setup->mould_cavity ?? 'N/A' }}</span>
                                                <input type="text" name="mould_cavity" id="mould_cavity_input"
                                                    class="form-control d-none" value="{{ $setup->mould_cavity }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Cable Grip Size</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="cable_grip_size_text">{{ $setup->cable_grip_size ?? 'N/A' }}</span>
                                                <input type="text" name="cable_grip_size" id="cable_grip_size_input"
                                                    class="form-control d-none" value="{{ $setup->cable_grip_size }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 5 - Molding Machine, Job Request -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Molding mesin</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="molding_machine_text">{{ $setup->mesin->molding_mc ?? 'N/A' }}</span>
                                                <select name="molding_machine" id="molding_machine_input"
                                                    class="form-select d-none">
                                                    @foreach ($mesins as $mesin)
                                                        <option value="{{ $mesin->id }}"
                                                            {{ $setup->molding_machine == $mesin->id ? 'selected' : '' }}>
                                                            {{ $mesin->molding_mc }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="info-item">
                                            <label class="text-muted small">Job Request</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="job_request_text">{{ $setup->job_request ?? 'N/A' }}</span>
                                                <input type="text" name="job_request" id="job_request_input"
                                                    class="form-control d-none" value="{{ $setup->job_request }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Save and Cancel Buttons (Initially Hidden) -->
                                <div class="edit-buttons d-none" id="editButtons">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Update
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- After Setup by tooling/teknisi Section - Show if status is Waiting QC Approve or Completed -->

                        @if (in_array($setup->status, ['Waiting QC Approve', 'Pending QC', 'Completed']))
                            <form id="editMaintenanceForm" action="{{ route('finishsetup.update', $setup) }}"
                                enctype="multipart/form-data" method="POST" class="p-0 m-0">
                                @csrf
                                @method('PUT')

                                <div class="p-3 bg-light rounded-3 info-card hover-shadow mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-primary mb-3 border-bottom pb-2">After Setup by Technicians
                                        </h6>

                                        <!-- Teknisi Edit Button (visible only if user is teknisi and status isaiting QC Approve) -->
                                        @if ($setup->status == 'Waiting QC Approve' && Auth::user()->role == 'teknisi')
                                            <button type="button" id="toggleMaintenanceEdit"
                                                class="btn btn-sm btn-warning hover-scale mb-3">
                                                <i class="fas fa-edit me-1"></i> <span id="maintenanceEditBtnText">Edit
                                                </span>
                                            </button>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <!-- First row of fields (3 columns) -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label class="text-muted small">Asset No BT</label>
                                                    <div class="fw-medium">
                                                        <span class="editable-field"
                                                            id="asset_no_bt_text">{{ $setup->asset_no_bt ?? 'N/A' }}</span>
                                                        <input type="text" name="asset_no_bt" id="asset_no_bt_input"
                                                            class="form-control d-none" value="{{ $setup->asset_no_bt }}"
                                                            tabindex="2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label class="text-muted small">Mould Type (MTC)</label>
                                                    <div class="fw-medium">
                                                        <span class="editable-field"
                                                            id="mould_type_mtc_text">{{ $setup->mould_type_mtc ?? 'N/A' }}</span>
                                                        <input type="text" name="mould_type_mtc"
                                                            id="mould_type_mtc_input" class="form-control d-none"
                                                            value="{{ $setup->mould_type_mtc }}" tabindex="3">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Second row of fields (3 columns) -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label class="text-muted small">Marking Type (MTC)</label>
                                                    <div class="fw-medium">
                                                        <span class="editable-field"
                                                            id="marking_type_mtc_text">{{ $setup->marking_type_mtc ?? 'N/A' }}</span>
                                                        <input type="text" name="marking_type_mtc"
                                                            id="marking_type_mtc_input" class="form-control d-none"
                                                            value="{{ $setup->marking_type_mtc }}" tabindex="4">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label class="text-muted small">Ampere Rating</label>
                                                    <div class="fw-medium">
                                                        <span class="editable-field"
                                                            id="ampere_rating_text">{{ $setup->ampere_rating ?? 'N/A' }}</span>
                                                        <input type="text" name="ampere_rating"
                                                            id="ampere_rating_input" class="form-control d-none"
                                                            value="{{ $setup->ampere_rating }}" tabindex="5">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label class="text-muted small">Cable Grip Size (MTC)</label>
                                                    <div class="fw-medium">
                                                        <span class="editable-field"
                                                            id="cable_grip_size_mtc_text">{{ $setup->cable_grip_size_mtc ?? 'N/A' }}</span>
                                                        <input type="text" name="cable_grip_size_mtc"
                                                            id="cable_grip_size_mtc_input" class="form-control d-none"
                                                            value="{{ $setup->cable_grip_size_mtc }}" tabindex="6">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Third row: Setup Problem and Dokumentasi in one row -->
                                        <div class="row mb-3">
                                            <div class="col-md-8">
                                                <div class="info-item">
                                                    <label class="text-muted small">Setup Problem</label>
                                                    <div class="fw-medium">
                                                        <span class="editable-field"
                                                            id="setup_problem_text">{{ $setup->setup_problem ?? 'N/A' }}</span>
                                                        <textarea name="setup_problem" id="setup_problem_input" class="form-control d-none" rows="3" tabindex="7">{{ $setup->setup_problem }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label class="text-muted small">Documentation</label>
                                                    <div class="fw-medium">
                                                        <!-- Toggle button for documentation -->
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            id="toggleDokumentasi" tabindex="8">
                                                            <i class="bi bi-eye me-1"></i> View documentation
                                                        </button>

                                                        <!-- Editable field for updating dokumentasi -->
                                                        <div class="editable-field d-none" id="dokumentasi_input_wrapper">
                                                            <input type="file" name="dokumentasi"
                                                                id="dokumentasi_input" class="form-control"
                                                                accept="image/*,video/mp4,video/mov,pdf" tabindex="9">
                                                            <small class="text-muted">Upload a new picture or video
                                                                documentation</small>

                                                            <!-- Tambahkan informasi file dokumentasi saat ini -->
                                                            @if ($setup->dokumentasi)
                                                                <div class="mt-2">
                                                                    <small class="text-info">Current documentation:
                                                                        {{ basename($setup->dokumentasi) }}</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Documentation Modal -->
                                    <div class="modal fade" id="dokumentasiModal" tabindex="-1"
                                        aria-labelledby="dokumentasiModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="dokumentasiModalLabel">Documentation
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <!-- Documentation content will be placed here -->
                                                    @if (Str::endsWith($setup->dokumentasi, ['.jpg', '.jpeg', '.png']))
                                                        <img src="{{ asset('storage/' . $setup->dokumentasi) }}"
                                                            class="img-fluid rounded">
                                                    @elseif(Str::endsWith($setup->dokumentasi, ['.mp4', '.mov']))
                                                        <video controls class="w-100 rounded">
                                                            <source src="{{ asset('storage/' . $setup->dokumentasi) }}"
                                                                type="video/mp4">
                                                            The browser does not support video.
                                                        </video>
                                                    @elseif($setup->dokumentasi)
                                                        <!-- For other file types or if exists but type not recognized -->
                                                        <span>Documentation files available</span>
                                                    @else
                                                        <span>No documentation</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save and Cancel Buttons (Initially Hidden) -->
                                    <div class="edit-buttons d-none" id="maintenanceEditButtons">
                                        <button type="submit" class="btn btn-primary me-2" tabindex="10">
                                            <i class="fas fa-save me-1"></i> Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        <!-- IPQC Checking Item by IPQC Section - Show only if status is Completed -->
                        @if ($setup->status == 'Pending QC' || $setup->status == 'Completed')
                            <div class="p-3 bg-light rounded-3 info-card hover-shadow mb-4">
                                <h6 class="text-primary mb-3 border-bottom pb-2">IPQC Checking Item by IPQC</h6>
                                <div class="row g-3">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        @if (isset($setup->marking))
                                            <div class="info-item mt-3">
                                                <label class="text-muted small">Marking</label>
                                                <div>
                                                    <span
                                                        class="badge {{ $setup->marking === 'Pass' ? 'bg-success' : 'bg-danger' }} hover-scale">
                                                        {{ $setup->marking ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                        @if (isset($setup->relief))
                                            <div class="info-item mt-3">
                                                <label class="text-muted small">Relief</label>
                                                <div>
                                                    <span
                                                        class="badge {{ $setup->relief === 'Pass' ? 'bg-success' : 'bg-danger' }} hover-scale">
                                                        {{ $setup->relief ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                        @if (isset($setup->mismatch))
                                            <div class="info-item mt-3">
                                                <label class="text-muted small">Mismatch</label>
                                                <div>
                                                    <span
                                                        class="badge {{ $setup->mismatch === 'Pass' ? 'bg-success' : 'bg-danger' }} hover-scale">
                                                        {{ $setup->mismatch ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Center Column -->
                                    <div class="col-md-6">
                                        @if (isset($setup->pin_bar_connector))
                                            <div class="info-item mt-3">
                                                <label class="text-muted small">Pin Bar Connector</label>
                                                <div>
                                                    <span
                                                        class="badge {{ $setup->pin_bar_connector === 'Pass' ? 'bg-success' : 'bg-danger' }} hover-scale">
                                                        {{ $setup->pin_bar_connector ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="info-item mt-3">
                                            <label class="text-muted small">QC Approve</label>
                                            <div class="fw-medium">{{ $setup->qc_approve ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Timestamps Section - Show relevant timestamps based on status -->
                        <div class="p-3 bg-light rounded-3 info-card hover-shadow">
                            <h6 class="text-primary mb-3 border-bottom pb-2">Timestamps</h6>
                            <div class="timeline">
                                <!-- Submit Time (always visible) -->
                                <div class="timeline-item mb-3 d-flex align-items-center hover-translate">
                                    <div class="timeline-icon bg-primary rounded-circle p-2 me-3 shadow-sm">
                                        <i class="fas fa-paper-plane text-white small"></i>
                                    </div>
                                    <div>
                                        <label class="text-muted small">Submit Time</label>
                                        <div class="fw-medium">
                                            {{ $setup->tanggal_submit ? $setup->tanggal_submit_formatted : 'N/A' }}
                                            {{ $setup->jam_submit ? $setup->jam_submit_formatted : '' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Start Time (visible if status is In Progress, Waiting QC Approve, or Completed) -->
                                @if (in_array($setup->status, ['In Progress', 'Waiting QC Approve', 'Pending QC', 'Completed']))
                                    <div class="timeline-item mb-3 d-flex align-items-center hover-translate">
                                        <div class="timeline-icon bg-warning rounded-circle p-2 me-3 shadow-sm">
                                            <i class="fas fa-play text-white small"></i>
                                        </div>
                                        <div>
                                            <label class="text-muted small">Start Time</label>
                                            <div class="fw-medium">
                                                {{ $setup->tanggal_start ? $setup->tanggal_start_formatted : 'N/A' }}
                                                {{ $setup->jam_start ? $setup->jam_start_formatted : '' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Finish Time (visible only if status is Completed) -->
                                @if ($setup->status == 'Completed')
                                    <div class="timeline-item mb-3 d-flex align-items-center hover-translate">
                                        <div class="timeline-icon bg-success rounded-circle p-2 me-3 shadow-sm">
                                            <i class="fas fa-check text-white small"></i>
                                        </div>
                                        <div>
                                            <label class="text-muted small">Finish Time</label>
                                            <div class="fw-medium">
                                                {{ $setup->tanggal_finish ? $setup->tanggal_finish_formatted : 'N/A' }}
                                                {{ $setup->jam_finish ? $setup->jam_finish_formatted : '' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Status Progress Bar -->
                        <div class="mt-4">
                            <h6 class="text-primary mb-3">Progress Status</h6>
                            <div class="progress" style="height: 30px;">
                                @if ($setup->status == 'Waiting')
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Waiting (25%)</div>
                                @elseif($setup->status == 'In Progress')
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">In Progress (50%)
                                    </div>
                                @elseif($setup->status == 'Waiting QC Approve')
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 75%"
                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Waiting QC Approve
                                        (75%)</div>
                                @elseif($setup->status == 'Pending QC')
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 85%"
                                        aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">Pending QC
                                        (85%)</div>
                                @elseif($setup->status == 'Completed')
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Completed (100%)</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for inline editing -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Script loaded");
            const toggleEditBtn = document.getElementById('toggleEdit');
            const editBtnText = document.getElementById('editBtnText');
            const editButtons = document.getElementById('editButtons');
            const scheduleInput = document.getElementById('schedule_datetime_input');
            const editForm = document.getElementById('editProductionForm');

            // Fields that can be edited
            const editableTextFields = [
                'line', 'part_number', 'qty_product', 'customer', 'job_request',
                'mould_type', 'marking_type', 'mould_cavity', 'cable_grip_size'
            ];

            // Fields that are read-only (displayed but not editable)
            const readOnlyFields = ['leader', 'maintenance_name'];

            // Select fields
            const selectFields = ['molding_machine', 'mould_category'];

            // Special field: datetime
            const scheduleDateTime = {
                text: document.getElementById('schedule_datetime_text'),
                input: document.getElementById('schedule_datetime_input')
            };

            // Function to set minimum datetime (current time + 10 minutes)
            function updateMinDatetime() {
                const now = new Date();
                // Add 10 minutes to current time
                now.setMinutes(now.getMinutes() + 10);

                // Format date to YYYY-MM-DDThh:mm format required by datetime-local input
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');

                const minDatetime = `${year}-${month}-${day}T${hours}:${minutes}`;

                // Set min attribute on the datetime input
                if (scheduleInput) {
                    scheduleInput.setAttribute('min', minDatetime);
                    scheduleInput.dataset.minDateTime = minDatetime;
                }

                return minDatetime;
            }

            // Validate datetime selection
            function validateScheduleDateTime() {
                if (!scheduleInput) return true;

                const selectedTime = new Date(scheduleInput.value).getTime();
                const minTime = new Date(scheduleInput.dataset.minDateTime).getTime();

                if (selectedTime < minTime) {
                    // Invalid time selected
                    scheduleInput.classList.add('is-invalid');

                    // Add error message if it doesn't exist
                    if (!scheduleInput.nextElementSibling || !scheduleInput.nextElementSibling.classList.contains(
                            'invalid-feedback')) {
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'invalid-feedback';
                        errorMsg.innerHTML = 'Schedule time must be at least 10 minutes from now';
                        scheduleInput.parentNode.appendChild(errorMsg);
                    }
                    return false;
                } else {
                    // Valid time, remove error styling
                    scheduleInput.classList.remove('is-invalid');
                    const errorFeedback = scheduleInput.nextElementSibling;
                    if (errorFeedback && errorFeedback.classList.contains('invalid-feedback')) {
                        errorFeedback.remove();
                    }
                    return true;
                }
            }

            // Handle toggle edit mode
            if (toggleEditBtn) {
                toggleEditBtn.addEventListener('click', function() {
                    console.log("Toggle Edit Button clicked");
                    const isEditing = toggleEditBtn.classList.contains('editing');

                    if (!isEditing) {
                        // Switch to edit mode
                        toggleEditBtn.classList.add('editing');
                        editBtnText.textContent = 'Cancel';
                        editButtons.classList.remove('d-none');
                        editButtons.classList.add('d-block');

                        // Show input fields for editable text inputs, hide text displays
                        editableTextFields.forEach(field => {
                            const textElement = document.getElementById(`${field}_text`);
                            const inputElement = document.getElementById(`${field}_input`);
                            if (textElement && inputElement) {
                                textElement.classList.add('d-none');
                                inputElement.classList.remove('d-none');
                            }
                        });

                        // Handle read-only fields - show input but make it read-only
                        readOnlyFields.forEach(field => {
                            const textElement = document.getElementById(`${field}_text`);
                            const inputElement = document.getElementById(`${field}_input`);
                            if (textElement && inputElement) {
                                textElement.classList.add('d-none');
                                inputElement.classList.remove('d-none');
                                // Make sure it's read-only and has not-allowed cursor
                                inputElement.setAttribute('readonly', 'readonly');
                                inputElement.style.cursor = 'not-allowed';
                                inputElement.style.backgroundColor = '#f8f9fa';
                            }
                        });

                        // Handle select fields
                        selectFields.forEach(field => {
                            const textElement = document.getElementById(`${field}_text`);
                            const inputElement = document.getElementById(`${field}_input`);
                            if (textElement && inputElement) {
                                textElement.classList.add('d-none');
                                inputElement.classList.remove('d-none');
                            }
                        });

                        // Handle datetime field separately
                        if (scheduleDateTime.text && scheduleDateTime.input) {
                            scheduleDateTime.text.classList.add('d-none');
                            scheduleDateTime.input.classList.remove('d-none');

                            // Set minimum datetime when entering edit mode
                            updateMinDatetime();
                        }
                    } else {
                        // Switch back to view mode
                        cancelEditMode();
                    }
                });
            }

            // Function to cancel edit mode
            function cancelEditMode() {
                if (!toggleEditBtn) return;

                toggleEditBtn.classList.remove('editing');
                editBtnText.textContent = 'Edit';
                editButtons.classList.add('d-none');

                // Hide all input fields, show text displays
                const allFields = [...editableTextFields, ...readOnlyFields, ...selectFields];

                allFields.forEach(field => {
                    const textElement = document.getElementById(`${field}_text`);
                    const inputElement = document.getElementById(`${field}_input`);
                    if (textElement && inputElement) {
                        textElement.classList.remove('d-none');
                        inputElement.classList.add('d-none');
                    }
                });

                // Handle datetime field separately
                if (scheduleDateTime.text && scheduleDateTime.input) {
                    scheduleDateTime.text.classList.remove('d-none');
                    scheduleDateTime.input.classList.add('d-none');

                    // Remove any validation errors when canceling
                    scheduleDateTime.input.classList.remove('is-invalid');
                    const errorFeedback = scheduleDateTime.input.nextElementSibling;
                    if (errorFeedback && errorFeedback.classList.contains('invalid-feedback')) {
                        errorFeedback.remove();
                    }
                }
            }

            // Add event listener to validate schedule_datetime on change
            if (scheduleInput) {
                scheduleInput.addEventListener('change', function() {
                    validateScheduleDateTime();
                });
            }

            // Handle form submission
            if (editForm) {
                editForm.addEventListener('submit', function(event) {
                    console.log("Form is being submitted");

                    // Update min datetime in case the form has been open for a while
                    updateMinDatetime();

                    // Validate the schedule datetime
                    if (!validateScheduleDateTime()) {
                        event.preventDefault();

                        // Show alert
                        alert('Schedule time must be at least 10 minutes from now');

                        // Scroll to the error field
                        scheduleInput.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        return false;
                    }

                    // Ensure read-only fields maintain their original values
                    readOnlyFields.forEach(field => {
                        // Get the hidden input that contains the original value
                        const hiddenInput = document.getElementById(`${field}_hidden`);
                        if (hiddenInput) {
                            // Create or update a hidden input field with the original value
                            let input = this.querySelector(`input[name="${field}"]`);
                            if (!input) {
                                input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = field;
                                this.appendChild(input);
                            }
                            input.value = hiddenInput.value;
                            console.log(`Set ${field} value to:`, input.value);
                        }
                    });

                    // Log form data for debugging
                    const formData = new FormData(this);
                    console.log("Form data being submitted:");
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements for maintenance section
            const toggleMaintenanceEditBtn = document.getElementById('toggleMaintenanceEdit');
            const maintenanceEditBtnText = document.getElementById('maintenanceEditBtnText');
            const cancelMaintenanceEditBtn = document.getElementById('cancelMaintenanceEdit');
            const maintenanceEditButtons = document.getElementById('maintenanceEditButtons');

            // Dokumentasi elements
            const toggleDokumentasiBtn = document.getElementById('toggleDokumentasi');
            const dokumentasiInputWrapper = document.getElementById('dokumentasi_input_wrapper');

            // Modal for dokumentasi
            const dokumentasiModal = new bootstrap.Modal(document.getElementById('dokumentasiModal'));

            // Fields to be made editable in maintenance section
            const maintenanceFields = [
                'asset_no_bt', 'setup_problem',
                'mould_type_mtc', 'marking_type_mtc', 'cable_grip_size_mtc', 'ampere_rating'
            ];

           

            // Handle toggle modal for dokumentasi
            if (toggleDokumentasiBtn) {
                toggleDokumentasiBtn.addEventListener('click', function() {
                    dokumentasiModal.show();
                });
            }

            // Handle toggle edit mode for maintenance section
            if (toggleMaintenanceEditBtn) {
                toggleMaintenanceEditBtn.addEventListener('click', function() {
                    const isEditing = toggleMaintenanceEditBtn.classList.contains('editing');
                    if (!isEditing) {
                        // Switch to edit mode
                        toggleMaintenanceEditBtn.classList.add('editing');
                        maintenanceEditBtnText.textContent = 'Cancel';
                        maintenanceEditButtons.classList.remove('d-none');
                        maintenanceEditButtons.classList.add('d-block');

                        // Show input fields, hide text displays
                        maintenanceFields.forEach(field => {
                            const textElement = document.getElementById(`${field}_text`);
                            const inputElement = document.getElementById(`${field}_input`);
                            if (textElement && inputElement) {
                                textElement.classList.add('d-none');
                                inputElement.classList.remove('d-none');
                                inputElement.classList.add('d-block');
                            }
                        });

                        // Handle date field separately
                        if (issuedDate.text && issuedDate.input) {
                            issuedDate.text.classList.add('d-none');
                            issuedDate.input.classList.remove('d-none');
                            issuedDate.input.classList.add('d-block');
                        }

                        // Show dokumentasi upload field
                        if (dokumentasiInputWrapper) {
                            dokumentasiInputWrapper.classList.remove('d-none');
                            dokumentasiInputWrapper.classList.add('d-block');
                        }

                        // Change the dokumentasi button appearance
                        if (toggleDokumentasiBtn) {
                            toggleDokumentasiBtn.innerHTML =
                                '<i class="bi bi-eye me-1"></i> View Current Documentation';
                        }
                    } else {
                        // Switch back to view mode
                        cancelMaintenanceEditMode();
                    }
                });
            }

            // Cancel edit mode for maintenance section
            if (cancelMaintenanceEditBtn) {
                cancelMaintenanceEditBtn.addEventListener('click', function() {
                    cancelMaintenanceEditMode();
                });
            }

            // Function to cancel edit mode for maintenance section
            function cancelMaintenanceEditMode() {
                if (toggleMaintenanceEditBtn) {
                    toggleMaintenanceEditBtn.classList.remove('editing');
                }

                if (maintenanceEditBtnText) {
                    maintenanceEditBtnText.textContent = 'Edit';
                }

                if (maintenanceEditButtons) {
                    maintenanceEditButtons.classList.add('d-none');
                    maintenanceEditButtons.classList.remove('d-block');
                }

                // Hide input fields, show text displays
                maintenanceFields.forEach(field => {
                    const textElement = document.getElementById(`${field}_text`);
                    const inputElement = document.getElementById(`${field}_input`);
                    if (textElement && inputElement) {
                        textElement.classList.remove('d-none');
                        inputElement.classList.add('d-none');
                        inputElement.classList.remove('d-block');
                    }
                });

                // Handle date field separately
                if (issuedDate.text && issuedDate.input) {
                    issuedDate.text.classList.remove('d-none');
                    issuedDate.input.classList.add('d-none');
                    issuedDate.input.classList.remove('d-block');
                }

                // Hide dokumentasi upload field
                if (dokumentasiInputWrapper) {
                    dokumentasiInputWrapper.classList.add('d-none');
                    dokumentasiInputWrapper.classList.remove('d-block');
                }

                // Restore the dokumentasi button appearance
                if (toggleDokumentasiBtn) {
                    toggleDokumentasiBtn.innerHTML = '<i class="bi bi-eye me-1"></i> View Dokumentasi';
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Admin Edit Button Functionality
            const toggleAdminEditBtn = document.getElementById('toggleAdminEdit');
            const adminEditBtnText = document.getElementById('adminEditBtnText');

            if (toggleAdminEditBtn) {
                toggleAdminEditBtn.addEventListener('click', function() {
                    const isEditing = toggleAdminEditBtn.classList.contains('editing');

                    if (!isEditing) {
                        // Switch to edit mode
                        toggleAdminEditBtn.classList.add('editing');
                        adminEditBtnText.textContent = 'Cancel';

                        // Production section fields
                        const productionFields = [
                            'line', 'part_number', 'qty_product', 'customer', 'job_request',
                            'mould_type', 'mould_category', 'marking_type', 'mould_cavity',
                            'cable_grip_size', 'molding_mc'
                        ];

                        // Handle schedule_datetime separately
                        const scheduleDateTime = {
                            text: document.getElementById('schedule_datetime_text'),
                            input: document.getElementById('schedule_datetime_input')
                        };

                        // Make production fields editable
                        productionFields.forEach(field => {
                            const textElement = document.getElementById(`${field}_text`);
                            const inputElement = document.getElementById(`${field}_input`);

                            if (textElement && inputElement) {
                                textElement.classList.add('d-none');
                                inputElement.classList.remove('d-none');
                                inputElement.classList.add('d-block');
                            }
                        });

                        // Make schedule_datetime editable
                        if (scheduleDateTime.text && scheduleDateTime.input) {
                            scheduleDateTime.text.classList.add('d-none');
                            scheduleDateTime.input.classList.remove('d-none');
                            scheduleDateTime.input.classList.add('d-block');
                        }

                        // Maintenance section fields (if they exist)
                        const maintenanceFields = [
                            'asset_no_bt', 'setup_problem',
                            'mould_type_mtc', 'marking_type_mtc', 'cable_grip_size_mtc', 'ampere_rating'
                        ];

                       

                        // Make maintenance fields editable
                        maintenanceFields.forEach(field => {
                            const textElement = document.getElementById(`${field}_text`);
                            const inputElement = document.getElementById(`${field}_input`);

                            if (textElement && inputElement) {
                                textElement.classList.add('d-none');
                                inputElement.classList.remove('d-none');
                                inputElement.classList.add('d-block');
                            }
                        });

                       
                        

                        // Show save buttons on both forms
                        const productionEditButtons = document.getElementById('editButtons');
                        if (productionEditButtons) {
                            productionEditButtons.classList.add('show');
                        }

                        const maintenanceEditButtons = document.getElementById('maintenanceEditButtons');
                        if (maintenanceEditButtons) {
                            maintenanceEditButtons.classList.add('show');
                        }

                    } else {
                        // Switch back to view mode
                        cancelAdminEditMode();
                    }
                });

                // Function to cancel admin edit mode
                function cancelAdminEditMode() {
                    toggleAdminEditBtn.classList.remove('editing');
                    adminEditBtnText.textContent = 'Edit';

                    // Production section fields
                    const productionFields = [
                        'line', 'part_number', 'qty_product', 'customer', 'job_request',
                        'mould_type', 'mould_category', 'marking_type', 'mould_cavity', 'cable_grip_size',
                        'molding_mc'
                    ];

                    // Hide input fields, show text displays
                    productionFields.forEach(field => {
                        const textElement = document.getElementById(`${field}_text`);
                        const inputElement = document.getElementById(`${field}_input`);

                        if (textElement && inputElement) {
                            textElement.classList.remove('d-none');
                            inputElement.classList.add('d-none');
                            inputElement.classList.remove('d-block');
                        }
                    });

                    // Handle schedule_datetime separately
                    const scheduleDateTime = {
                        text: document.getElementById('schedule_datetime_text'),
                        input: document.getElementById('schedule_datetime_input')
                    };

                    if (scheduleDateTime.text && scheduleDateTime.input) {
                        scheduleDateTime.text.classList.remove('d-none');
                        scheduleDateTime.input.classList.add('d-none');
                        scheduleDateTime.input.classList.remove('d-block');
                    }

                    // Maintenance section fields
                    const maintenanceFields = [
                        'asset_no_bt', 'setup_problem',
                        'mould_type_mtc', 'marking_type_mtc', 'cable_grip_size_mtc', 'ampere_rating'
                    ];

                    // Hide input fields, show text displays
                    maintenanceFields.forEach(field => {
                        const textElement = document.getElementById(`${field}_text`);
                        const inputElement = document.getElementById(`${field}_input`);

                        if (textElement && inputElement) {
                            textElement.classList.remove('d-none');
                            inputElement.classList.add('d-none');
                            inputElement.classList.remove('d-block');
                        }
                    });

                   
                    if (issuedDate.text && issuedDate.input) {
                        issuedDate.text.classList.remove('d-none');
                        issuedDate.input.classList.add('d-none');
                        issuedDate.input.classList.remove('d-block');
                    }

                    // Hide save buttons
                    const productionEditButtons = document.getElementById('editButtons');
                    if (productionEditButtons) {
                        productionEditButtons.classList.remove('show');
                    }

                    const maintenanceEditButtons = document.getElementById('maintenanceEditButtons');
                    if (maintenanceEditButtons) {
                        maintenanceEditButtons.classList.remove('show');
                    }
                }

                // Add event listener for Cancel button
                document.addEventListener('click', function(e) {
                    if (e.target && e.target.id === 'cancelEdit' || e.target && e.target.id ===
                        'cancelMaintenanceEdit') {
                        cancelAdminEditMode();
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleDokumentasi');
            const dokumentasiContainer = document.getElementById('dokumentasiContainer');

            toggleButton.addEventListener('click', function() {
                // Toggle the visibility of the documentation container
                if (dokumentasiContainer.classList.contains('d-none')) {
                    dokumentasiContainer.classList.remove('d-none');
                    toggleButton.innerHTML = '<i class="bi bi-eye-slash me-1"></i> Hide Documentation';
                } else {
                    dokumentasiContainer.classList.add('d-none');
                    toggleButton.innerHTML = '<i class="bi bi-eye me-1"></i> View Documentation';
                }
            });
        });
    </script>
@endsection
