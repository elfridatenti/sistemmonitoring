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
                                    <i class="fas fa-clock text-light fs-4"></i>
                                </div>
                                <h5 class="modal-title  mb-0">SUBMITTED DOWNTIME DETAILS</h5>
                            </div>
                            <a href="{{ route('downtime.index') }}" class="btn btn-outline-light hover-scale">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
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
                            class="status-banner status-{{ strtolower(str_replace(' ', '-', $downtime->status)) }} d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-info-circle me-2"></i>
                                Status: <span
                                    class="badge badge-{{ strtolower(str_replace(' ', '-', $downtime->status)) }} me-2 hover-scale">
                                    {{ $downtime->status }}
                                </span>
                            </div>

                            @if ($downtime->status == 'Completed' && Auth::user()->role == 'admin')
                                <button type="button" id="toggleAdminEdit" class="btn btn-sm btn-primary hover-scale">
                                    <i class="fas fa-edit me-1"></i> <span id="adminEditBtnText">Edit All Data</span>
                                </button>
                            @endif
                        </div>

                        <form id="editDowntimeForm" action="{{ route('downtime.update', $downtime) }}" method="POST"
                            class="p-0 m-0">
                            @csrf
                            @method('PUT')
                            <div class="p-3 bg-light rounded-3 info-card hover-shadow mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary mb-3 border-bottom pb-2">Request Item by Production</h6>

                                    <!-- Leader Edit Button (visible only if user is leader and status is Waiting) -->
                                    @if (
                                        $downtime->status =='Waiting' && Auth::user()->role == 'leader')
                                        <button type="button" id="toggleEditDowntime"
                                            class="btn btn-sm btn-warning hover-scale mb-3">
                                            <i class="fas fa-edit me-1"></i> <span id="editDowntimeBtnText">Edit
                                                Request</span>
                                        </button>
                                    @endif
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Leader</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="leader_text">{{ $downtime->user->nama ?? 'N/A' }}</span>
                                                <input type="text" name="leader_display" id="leader_input"
                                                    class="form-control d-none" value="{{ $downtime->user->nama }}" readonly
                                                    style="cursor: not-allowed; background-color: #f8f9fa;">
                                                <input type="hidden" name="leader" id="leader_hidden"
                                                    value="{{ $downtime->user_id }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Badge</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="downtime_badge_text">{{ $downtime->badge ?? 'N/A' }}</span>
                                                <input type="text" name="badge" id="downtime_badge_input"
                                                    class="form-control d-none" value="{{ $downtime->badge }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Raised Operator</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="downtime_raised_operator_text">{{ $downtime->raised_operator ?? 'N/A' }}</span>
                                                <input type="text" name="raised_operator"
                                                    id="downtime_raised_operator_input" class="form-control d-none"
                                                    value="{{ $downtime->raised_operator }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Maintenance Name</label>
                                            <div class="fw-medium">
                                                <span id="maintenance_name_text">
                                                    @if ($downtime->maintenance_repair)
                                                        {{ App\Models\User::where('id', $downtime->maintenance_repair)->where('role', 'teknisi')->first()->nama ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Raised IPQC</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="downtime_raised_ipqc_text">{{ $downtime->raised_ipqc ?? 'N/A' }}</span>
                                                <input type="text" name="raised_ipqc" id="downtime_raised_ipqc_input"
                                                    class="form-control d-none" value="{{ $downtime->raised_ipqc }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">


                                            <label class="text-muted small">Line</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="downtime_line_text">{{ $downtime->line ?? 'N/A' }}</span>
                                                <input type="text" name="line" id="downtime_line_input"
                                                    class="form-control d-none" value="{{ $downtime->line }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Molding Machine</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="downtime_molding_mc_text">{{ $downtime->mesin->molding_mc ?? 'N/A' }}</span>
                                                <select name="molding_machine" id="downtime_molding_mc_input"
                                                    class="form-select d-none">
                                                    <option value="{{ $downtime->mesin->id }}" selected>
                                                        {{ $downtime->mesin->molding_mc }}</option>
                                                    <!-- Add other options from your mesin table -->
                                                    @foreach ($mesins as $mesin)
                                                        @if ($mesin->id != $downtime->mesin->id)
                                                            <option value="{{ $mesin->id }}">{{ $mesin->molding_mc }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Defect Category</label>
                                            <div class="fw-medium">
                                                <span class="editable-field" id="downtime_defect_category_text">
                                                    @if (is_numeric($downtime->defect_category))
                                                        {{ $downtime->defect->defect_category ?? 'N/A' }}
                                                    @else
                                                        {{ $downtime->defect_category }}
                                                    @endif
                                                </span>
                                                <select name="defect_category" id="downtime_defect_category_input"
                                                    class="form-select d-none">
                                                    @if (is_numeric($downtime->defect_category))
                                                        <option value="{{ $downtime->defect_category }}" selected>
                                                            {{ $downtime->defect->defect_category }}</option>
                                                    @else
                                                        <option value="{{ $downtime->defect_category }}" selected>
                                                            {{ $downtime->defect_category }}</option>
                                                    @endif
                                                    <!-- Add other options from your defect table -->
                                                    @foreach ($defects as $defect)
                                                        @if ($defect->id != $downtime->defect_category)
                                                            <option value="{{ $defect->id }}">
                                                                {{ $defect->defect_category }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <label class="text-muted small">Problem/Defect</label>
                                            <div class="fw-medium">
                                                <span class="editable-field"
                                                    id="downtime_problem_defect_text">{{ $downtime->problem_defect ?? 'N/A' }}</span>
                                                <input type="text" name="problem_defect"
                                                    id="downtime_problem_defect_input" class="form-control d-none"
                                                    value="{{ $downtime->problem_defect }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Save Button (Initially Hidden) -->
                                <div class="edit-buttons d-none" id="editDowntimeButtons">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-save me-1"></i> Update
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Maintenance & Problem Section -->
                        @if (in_array($downtime->status, ['Waiting QC Approve', 'Completed']))
                            <form id="editDowntimeForm" action="{{ route('finishdowntime.update', $downtime) }}"
                                enctype="multipart/form-data" method="POST" class="p-0 m-0">
                                @csrf
                                @method('PUT')
                                <div class="p-3 bg-light rounded-3 info-card hover-shadow mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-primary mb-3 border-bottom pb-2">After Repair by Technicians
                                        </h6>

                                        <!-- Teknisi Edit Button (visible only if user is teknisi and status is Waiting QC Approve) -->
                                        @if ($downtime->status == 'Waiting QC Approve' && Auth::user()->role == 'teknisi')
                                            <button type="button" id="toggleDowntimeEdit"
                                                class="btn btn-sm btn-warning hover-scale mb-3">
                                                <i class="fas fa-edit me-1"></i> <span
                                                    id="downtimeEditBtnText">Edit</span>
                                            </button>
                                        @endif
                                    </div>

                                    <div class="row align-items-center">
                                        <!-- Root Cause -->
                                        <div class="col-md-4">
                                            <div class="info-item me-3">
                                                <label class="text-muted small">Root Cause</label>
                                                <div class="fw-medium">
                                                    <span class="editable-field"
                                                        id="root_cause_text">{{ $downtime->root_cause ?? 'N/A' }}</span>
                                                    <textarea name="root_cause" id="root_cause_input" class="form-control d-none" rows="3">{{ $downtime->root_cause }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Taken -->
                                        <div class="col-md-4">
                                            <div class="info-item me-3">
                                                <label class="text-muted small">Action Taken</label>
                                                <div class="fw-medium">
                                                    <span class="editable-field"
                                                        id="action_taken_text">{{ $downtime->action_taken ?? 'N/A' }}</span>
                                                    <textarea name="action_taken" id="action_taken_input" class="form-control d-none" rows="3">{{ $downtime->action_taken }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Documentation -->
                                        <div class="col-md-4">
                                            <div class="info-item">
                                                <label class="text-muted small">Documentation</label>
                                                <div class="fw-medium">
                                                    <!-- Toggle button for documentation -->
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        id="toggleDokumentasi" tabindex="8">
                                                        <i class="bi bi-eye me-1"></i> View Documentation
                                                    </button>

                                                    <!-- Editable field for updating dokumentasi -->
                                                    <div class="editable-field d-none" id="dokumentasi_input_wrapper">
                                                        <input type="file" name="dokumentasi" id="dokumentasi_input"
                                                            class="form-control" accept="image/*,video/mp4,video/mov,pdf"
                                                            tabindex="9">
                                                        <small class="text-muted">Upload a new picture or video
                                                            documentation</small>

                                                        <!-- Tambahkan informasi file dokumentasi saat ini -->
                                                        @if ($downtime->dokumentasi)
                                                            <div class="mt-2">
                                                                <small class="text-info">Current documentation:
                                                                    {{ basename($downtime->dokumentasi) }}</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Documentation Modal (unchanged) -->
                                    <div class="modal fade" id="dokumentasiModal" tabindex="-1"
                                        aria-labelledby="dokumentasiModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="dokumentasiModalLabel">Documentation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <!-- Documentation content will be placed here -->
                                                    @if (Str::endsWith($downtime->dokumentasi, ['.jpg', '.jpeg', '.png']))
                                                        <img src="{{ asset('storage/' . $downtime->dokumentasi) }}"
                                                            class="img-fluid rounded">
                                                    @elseif(Str::endsWith($downtime->dokumentasi, ['.mp4', '.mov']))
                                                        <video controls class="w-100 rounded">
                                                            <source src="{{ asset('storage/' . $downtime->dokumentasi) }}"
                                                                type="video/mp4">
                                                            The browser does not support video.
                                                        </video>
                                                    @elseif($downtime->dokumentasi)
                                                        <!-- For other file types or if exists but type not recognized -->
                                                        <span>Documentation files available/span>
                                                        @else
                                                            <span>No documentation</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Save and Cancel Buttons (Initially Hidden) -->
                                    <div class="edit-buttons d-none" id="downtimeEditButtons">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fas fa-save me-1"></i> Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif

                        <!-- Verification Section -->
                        <div class="col-md-12 mb-4">
                            @if ($downtime->status == 'Completed')
                                <div class="p-3 bg-light rounded-3 info-card hover-shadow h-100">
                                    <h6 class="text-primary mb-3 border-bottom pb-2">IPQC Checking Item by IPQC</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info-item mb-3">
                                                <label class="text-muted small">QC Approve</label>
                                                <div class="fw-medium">{{ $downtime->qc_approve ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item mb-3">
                                                <label class="text-muted small">Production Verify</label>
                                                <div class="fw-medium">{{ $downtime->production_verify ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

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
                                            {{ $downtime->tanggal_submit ? $downtime->tanggal_submit_formatted : 'N/A' }}
                                            {{ $downtime->jam_submit ? $downtime->jam_submit_formatted : '' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Start Time (visible if status is In Progress,Waiting QC Approve, or Completed) -->
                                @if (in_array($downtime->status, ['In Progress', 'Waiting QC Approve', 'Completed']))
                                    <div class="timeline-item mb-3 d-flex align-items-center hover-translate">
                                        <div class="timeline-icon bg-warning rounded-circle p-2 me-3 shadow-sm">
                                            <i class="fas fa-play text-white small"></i>
                                        </div>
                                        <div>
                                            <label class="text-muted small">Start Time</label>
                                            <div class="fw-medium">
                                                {{ $downtime->tanggal_start ? $downtime->tanggal_start_formatted : 'N/A' }}
                                                {{ $downtime->jam_start ? $downtime->jam_start_formatted : '' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Finish Time (visible only if status is Completed) -->
                                @if ($downtime->status == 'Completed')
                                    <div class="timeline-item mb-3 d-flex align-items-center hover-translate">
                                        <div class="timeline-icon bg-success rounded-circle p-2 me-3 shadow-sm">
                                            <i class="fas fa-check text-white small"></i>
                                        </div>
                                        <div>
                                            <label class="text-muted small">Finish Time</label>
                                            <div class="fw-medium">
                                                {{ $downtime->tanggal_finish ? $downtime->tanggal_finish_formatted : 'N/A' }}
                                                {{ $downtime->jam_finish ? $downtime->jam_finish_formatted : '' }}
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
                                @if ($downtime->status == 'Waiting')
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Waiting (25%)</div>
                                @elseif($downtime->status == 'In Progress')
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">In Progress (50%)
                                    </div>
                                @elseif($downtime->status == 'Waiting QC Approve')
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 75%"
                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Waiting QC Approve
                                        (75%)</div>
                                @elseif($downtime->status == 'Pending QC')
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 85%"
                                        aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">Pending QC
                                        (85%)</div>
                                @elseif($downtime->status == 'Completed')
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

    <script>
        function showEditForm() {
            document.getElementById('detail-view').style.display = 'none';
            document.getElementById('edit-form').style.display = 'block';
        }

        function hideEditForm() {
            document.getElementById('detail-view').style.display = 'block';
            document.getElementById('edit-form').style.display = 'none';
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleEditBtn = document.getElementById('toggleEditDowntime');
            const editBtnText = document.getElementById('editDowntimeBtnText');
            const editButtons = document.getElementById('editDowntimeButtons');

            // Fields to be made editable
            const textFields = [
                'downtime_badge', 'downtime_raised_operator', 'downtime_raised_ipqc', 'downtime_line',
                'downtime_molding_mc', 'downtime_defect_category', 'downtime_problem_defect',
                'maintenance_repair'
            ];

            // Handle toggle edit mode
            if (toggleEditBtn) {
                toggleEditBtn.addEventListener('click', function() {
                    const isEditing = toggleEditBtn.classList.contains('editing');
                    if (!isEditing) {
                        // Switch to edit mode
                        toggleEditBtn.classList.add('editing');
                        editBtnText.textContent = 'Cancel';
                        editButtons.classList.remove('d-none');
                        editButtons.classList.add('d-block');

                        // Show input fields, hide text displays
                        textFields.forEach(field => {
                            const textElement = document.getElementById(`${field}_text`);
                            const inputElement = document.getElementById(`${field}_input`);
                            if (textElement && inputElement) {
                                textElement.classList.add('d-none');
                                inputElement.classList.remove('d-none');
                                inputElement.classList.add('d-block');
                            }
                        });
                    } else {
                        // Switch back to view mode
                        cancelEditMode();
                    }
                });
            }

            // Function to cancel edit mode
            function cancelEditMode() {
                toggleEditBtn.classList.remove('editing');
                editBtnText.textContent = 'Edit';
                editButtons.classList.add('d-none');
                editButtons.classList.remove('d-block');

                // Hide input fields, show text displays
                textFields.forEach(field => {
                    const textElement = document.getElementById(`${field}_text`);
                    const inputElement = document.getElementById(`${field}_input`);
                    if (textElement && inputElement) {
                        textElement.classList.remove('d-none');
                        inputElement.classList.add('d-none');
                        inputElement.classList.remove('d-block');
                    }
                });
            }
        });
    </script>


    <script>
        // JavaScript for downtime section inline editing
        document.addEventListener('DOMContentLoaded', function() {
            // Elements for downtime section
            const toggleDowntimeEditBtn = document.getElementById('toggleDowntimeEdit');
            const downtimeEditBtnText = document.getElementById('downtimeEditBtnText');
            const downtimeEditButtons = document.getElementById('downtimeEditButtons');

            // Toggle documentation view
            const toggleDokumentasiBtn = document.getElementById('toggleDokumentasi');
            const dokumentasiModal = new bootstrap.Modal(document.getElementById('dokumentasiModal'));

            // Fields to be made editable in downtime section
            const downtimeFields = [
                'root_cause', 'action_taken'
            ];

            // Documentation edit elements
            const dokumentasiInputWrapper = document.getElementById('dokumentasi_input_wrapper');

            // Handle dokumentasi view button
            if (toggleDokumentasiBtn) {
                toggleDokumentasiBtn.addEventListener('click', function() {
                    // If in edit mode, show file input
                    if (toggleDowntimeEditBtn && toggleDowntimeEditBtn.classList.contains('editing')) {
                        // Toggle visibility of upload input
                        if (dokumentasiInputWrapper.classList.contains('d-none')) {
                            dokumentasiInputWrapper.classList.remove('d-none');
                            dokumentasiInputWrapper.classList.add('d-block');
                            toggleDokumentasiBtn.innerHTML =
                                '<i class="bi bi-x-circle me-1"></i> Cancel Upload';
                        } else {
                            dokumentasiInputWrapper.classList.add('d-none');
                            dokumentasiInputWrapper.classList.remove('d-block');
                            toggleDokumentasiBtn.innerHTML =
                                '<i class="bi bi-eye me-1"></i> View Documentation';
                        }
                    } else {
                        // In view mode, show the modal with current documentation
                        dokumentasiModal.show();
                    }
                });
            }

            // Handle toggle edit mode for downtime section
            if (toggleDowntimeEditBtn) {
                toggleDowntimeEditBtn.addEventListener('click', function() {
                    const isEditing = toggleDowntimeEditBtn.classList.contains('editing');
                    if (!isEditing) {
                        // Switch to edit mode
                        toggleDowntimeEditBtn.classList.add('editing');
                        downtimeEditBtnText.textContent = 'Cancel';
                        downtimeEditButtons.classList.remove('d-none');
                        downtimeEditButtons.classList.add('d-block');

                        // Show input fields, hide text displays
                        downtimeFields.forEach(field => {
                            const textElement = document.getElementById(`${field}_text`);
                            const inputElement = document.getElementById(`${field}_input`);
                            if (textElement && inputElement) {
                                textElement.classList.add('d-none');
                                inputElement.classList.remove('d-none');
                                inputElement.classList.add('d-block');
                            }
                        });

                        // Update dokumentasi button to show it's editable
                        if (toggleDokumentasiBtn) {
                            toggleDokumentasiBtn.innerHTML =
                                '<i class="bi bi-upload me-1"></i> Upload Documentation';
                        }
                    } else {
                        // Switch back to view mode
                        cancelDowntimeEditMode();
                    }
                });
            }

            // Function to cancel edit mode for downtime section
            function cancelDowntimeEditMode() {
                toggleDowntimeEditBtn.classList.remove('editing');
                downtimeEditBtnText.textContent = 'Edit';
                downtimeEditButtons.classList.add('d-none');
                downtimeEditButtons.classList.remove('d-block');

                // Hide input fields, show text displays
                downtimeFields.forEach(field => {
                    const textElement = document.getElementById(`${field}_text`);
                    const inputElement = document.getElementById(`${field}_input`);
                    if (textElement && inputElement) {
                        textElement.classList.remove('d-none');
                        inputElement.classList.add('d-none');
                        inputElement.classList.remove('d-block');
                    }
                });

                // Reset dokumentasi button and hide upload input
                if (toggleDokumentasiBtn) {
                    toggleDokumentasiBtn.innerHTML = '<i class="bi bi-eye me-1"></i> View Documentation';
                }
                if (dokumentasiInputWrapper) {
                    dokumentasiInputWrapper.classList.add('d-none');
                    dokumentasiInputWrapper.classList.remove('d-block');
                }
            }
        });
    </script>

@endsection
