@extends('layout.header-sidebar')

@section('content')
    <style>
        /* Card Styling */
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Table Container */
        .table-responsive {
            overflow-x: auto;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        /* Table Styling */
        .table {
            min-width: 1000px;
            /* Ensures horizontal scroll on smaller screens */
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 0;
            --bs-table-striped-bg: #f4f4f4;
        }

        .table th,
        .table td {
            padding: 12px 8px;
            vertical-align: middle;
            white-space: nowrap;
            width: auto;
            font-weight: 500;
            text-align: left;
            color: #3c3f46;
            border: 1.5px solid #e6e7e8;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            border: 1px solid #dee2e6;
            font-weight: 600;
            text-transform: uppercase;
            color: #78818f;
            text-align: center;
            letter-spacing: 0.2px;
            font-size: 0.80rem;
            /* Ukuran font diperkecil */
            padding: 0.75rem 0.6rem;
            vertical-align: middle;

        }


        /* Table Body Styling */
        .table tbody td {
            padding: 12px 15px;
            text-align: left;
            vertical-align: middle;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.80rem;
        }

        /* Secondary Header Styling (date/time row) */
        .table th.submit-date,
        .table th.submit-time,
        .table th.start-date,
        .table th.start-time,
        .table th.finish-date,
        .table th.finish-time {
            font-size: 0.75rem;
            padding: 0.5rem 0.25rem;
            font-weight: 500;
            text-transform: none;
            letter-spacing: normal;
            background-color: #f3f3f3;
            border-bottom: 2px solid #dee2e6;

        }




        .table th.badge-column {
            width: 100px;
        }

        .table th.line-column {
            width: 80px;
        }

        .table th.machine-column {
            width: 120px;
        }

        .table th.leader-column {
            width: 100px;
        }

        .table th.defect-column {
            width: 150px;
        }

        .table th.date-column {
            width: 100px;
        }

        .table th.time-column {
            width: 80px;
        }

        .table th.status-column {
            width: 120px;
        }

        .table th.actions-column {
            width: auto;
        }

        .table td:first-child::after {
            content: ".";
            display: inline;
            margin-left: 2px;
        }

        /* Button Styling */


        /* Style untuk button group */
        .btn-group {
            display: flex;
            flex-wrap: nowrap;

            justify-content: center;
        }

        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .btn-group .btn i {
            font-size: 0.75rem;
            margin-right: 2px;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Search Bar Styling */
        .search-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }



        .input-group {
            max-width: 400px;
        }

        /* Status Badge */
        .badge {
            padding: 6px 12px;
            font-weight: normal;
        }

        .hidden-column {
            display: none !important;
        }

        .form-card {
            background-color: #ffffff;
            border-radius: 5px;
            border: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .bg-gradient-primary {
            background: linear-gradient(120deg, #3a62ac, #2c4b8a);
            color: white;
            border-bottom: none;
        }

        .card-body {
            padding: 1.5rem;
        }

        .text-white-50 {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .table-responsive {
            overflow-x: auto;
        }


        .time-column {
            min-width: 90px;
        }

        .schedule-column {
            min-width: 120px;
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background-color: #e7f4ee;
            color: #156e45;w
        }

        .alert-danger {
            background-color: #fee7e7;
            color: #c8333a;
        }

        /* Invalid Form Field Styling */
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card form-card">
                    <div class="card-header bg-gradient-primary">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="mb-0 text-white">LIST OF MACHINE MOLDING DOWNTIME</h4>
                        </div>
                        <p class="mb-0 text-white-50">"Molding Machine Downtime Report List"</p>
                    </div>

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
                        <!-- Satu form untuk semua filter -->
                        <form action="{{ route('downtime.index') }}" method="GET">
                            <div class="row align-items-end">
                                <div class="col-auto">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-1">
                                            Show Entries
                                        </label>
                                        <select class="form-select form-select-sm shadow-sm w-auto" name="show"
                                            id="perPageSelect" style="cursor: pointer;">
                                            <option value="10" {{ request('show') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="20" {{ request('show') == 20 ? 'selected' : '' }}>20</option>
                                            <option value="50" {{ request('show') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request('show') == 100 ? 'selected' : '' }}>100
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-1">Filter Status</label>
                                        <div class="d-flex gap-2">
                                            <select name="status" class="form-select form-select-sm shadow-sm"
                                                style="cursor: pointer;">
                                                <option value="">All Status</option>
                                                <option value="Waiting"
                                                    {{ request('status') === 'Waiting' ? 'selected' : '' }}>
                                                    Waiting</option>
                                                <option value="In Progress"
                                                    {{ request('status') === 'In Progress' ? 'selected' : '' }}>
                                                    In Progress</option>
                                                <option value="Waiting QC Approve"
                                                    {{ request('status') === 'Waiting QC Approve' ? 'selected' : '' }}>
                                                    Waiting QC Approve</option>
                                                <option value="Completed"
                                                    {{ request('status') === 'Completed' ? 'selected' : '' }}>
                                                    Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col"></div>

                                <div class="col-md-3">
                                    {{-- Filter By --}}
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-1">Filter By</label>
                                        <select name="filter_type" class="form-select form-select-sm shadow-sm"
                                            style="cursor: pointer;">
                                            <option value="all" {{ request('filter_type') == 'all' ? 'selected' : '' }}>
                                                All</option>
                                            <option value="badge"
                                                {{ request('filter_type') == 'badge' ? 'selected' : '' }}>Badge</option>
                                            <option value="line"
                                                {{ request('filter_type') == 'line' ? 'selected' : '' }}>Line</option>
                                            <option value="leader"
                                                {{ request('filter_type') == 'leader' ? 'selected' : '' }}>Leader</option>
                                            <option value="defect_category"
                                                {{ request('filter_type') == 'defect_category' ? 'selected' : '' }}>
                                                Defect Category</option>
                                            <option value="molding_mc"
                                                {{ request('filter_type') == 'molding_mc' ? 'selected' : '' }}>Molding M/C
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    {{-- Search --}}
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-1">Search</label>
                                        <div class="d-flex align-items-center">
                                            <div class="input-group input-group-sm shadow-sm">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Search..." value="{{ request('search') }}">

                                                @if (request('search'))
                                                    <a href="{{ route('downtime.index', ['status' => request('status'), 'filter_type' => request('filter_type')]) }}"
                                                        class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <button type="submit" class="btn btn-info btn-sm text-white px-2 ms-2">
                                                Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="mt-4">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Leader</th>
                                            <th rowspan="2">Line</th>
                                            <th rowspan="2">Badge</th>
                                            <th rowspan="2">Molding </br>M/C</th>
                                            <th rowspan="2">Defect Category</th>

                                            <th colspan="2" class="text-center collapsible-header" data-group="submit">
                                                Submit <i class="fas fa-chevron-up collapse-indicator"></i>
                                            </th>
                                            <th colspan="2" class="text-center collapsible-header" data-group="start">
                                                Start <i class="fas fa-chevron-up collapse-indicator"></i>
                                            </th>


                                            <th colspan="2" class="text-center collapsible-header"
                                                data-group="finish">
                                                Finish <i class="fas fa-chevron-up collapse-indicator"></i>
                                            </th>


                                            <th rowspan="2">Status</th>
                                            <th rowspan="2">Actions</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center submit-date">Date</th>
                                            <th class="text-center submit-time time-column">Time</th>
                                            <th class="text-center start-date">Date</th>
                                            <th class="text-center start-time time-column">Time</th>

                                            <th class="text-center finish-date">Date</th>
                                            <th class="text-center finish-time time-column">Time</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($downtimes as $downtime)
                                            <tr>
                                                <td class="number-cell">{{ $loop->iteration }}</td>
                                                <td>{{ $downtime->leader }}</td>
                                                <td class="text-center">{{ $downtime->line }}</td>
                                                <td class="text-center">{{ $downtime->badge }}</td>
                                                <td class="text-center">{{ $downtime->mesin->molding_mc }}</td>
                                                <td>
                                                    @if (is_numeric($downtime->defect_category))
                                                        {{-- Jika nilainya angka (ID), ambil dari tabel defects --}}
                                                        {{ $downtime->defect ? $downtime->defect->defect_category : 'N/A' }}
                                                    @else
                                                        {{-- Jika nilainya text, tampilkan langsung --}}
                                                        {{ $downtime->defect_category }}
                                                    @endif
                                                </td>
                                                <td class="submit-date text-center">
                                                    {{ $downtime->tanggal_submit_formatted ?? 'N/A' }}
                                                </td>
                                                <td class="submit-time time-column text-center">
                                                    {{ $downtime->jam_submit_formatted ?? 'N/A' }}
                                                </td>
                                                <!-- Start columns -->
                                                <td class="start-date text-center">
                                                    {{ $downtime->tanggal_start_formatted ?? 'N/A' }}
                                                </td>
                                                <td class="start-time time-column text-center">
                                                    {{ $downtime->jam_start_formatted ?? 'N/A' }}
                                                </td>

                                                <td class="finish-date text-center">
                                                    {{ $downtime->tanggal_finish_formatted ?? 'N/A' }}
                                                </td>
                                                <td class="finish-time time-column text-center">
                                                    {{ $downtime->jam_finish_formatted ?? 'N/A' }}</td>


                                                <td class="status-cell">
                                                    <div class="text-center">
                                                        @if (auth()->user()->role === 'teknisi')
                                                            @if ($downtime->status === 'Waiting')
                                                                <button id="startBtn{{ $downtime->id }}"
                                                                    class="btn btn-success btn-start"
                                                                    data-id="{{ $downtime->id }}">
                                                                    Start
                                                                </button>
                                                            @else
                                                                <span
                                                                    class="badge
                                                            @if ($downtime->status === 'Completed') bg-success 
                                                            @elseif($downtime->status === 'In Progress') bg-warning 
                                                            @elseif($downtime->status === 'Waiting QC Approve') bg-secondary
                                                            @else bg-danger @endif">
                                                                    {{ $downtime->status }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span
                                                                class="badge
                                                        @if ($downtime->status === 'Completed') bg-success
                                                        @elseif($downtime->status === 'In Progress') bg-warning
                                                        @elseif($downtime->status === 'Waiting QC Approve') bg-secondary
                                                        @else bg-danger @endif">
                                                                {{ $downtime->status ?? 'Waiting' }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="gap: 2px;">
                                                        {{-- View button - accessible to all users --}}
                                                        <a href="{{ route('rekapdowntime.show', $downtime) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="far fa-eye "></i>
                                                        </a>

                                                        @if (auth()->user()->role === 'ipqc' && $downtime->status === 'Waiting QC Approve')
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approveModal{{ $downtime->id }}">
                                                                <i class="far fa-check-circle "></i> Aprrove
                                                            </button>
                                                        @endif

                                                        {{-- Delete button - for leader when status is 'Waiting' OR admin when status is 'Completed' --}}
                                                        @if (auth()->user()->role === 'leader' && $downtime->status === 'Waiting')
                                                        @if (auth()->user()->role === 'admin' && $downtime->status === 'Completed')
                                                            {{-- // (auth()->user()->role === 'admin' && $downtime->status === 'Completed')) --}}
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $downtime->id }}">
                                                                <i class="far fa-trash-alt "></i>
                                                            </button>
                                                        @endif
                                                        

                                                        @if (auth()->user()->role == 'teknisi' && $downtime->status == 'In Progress')
                                                            <a href="{{ route('finishdowntime.create', ['downtime_id' => $downtime->id]) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="far fa-check-circle "></i> Finish
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Approve Modal -->
                                            <div class="modal fade" id="approveModal{{ $downtime->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                    <div class="modal-content rounded-3 shadow-sm">
                                                        <form method="POST"
                                                            action="{{ route('rekapdowntime.approve', $downtime->id) }}"
                                                            id="approveForm{{ $downtime->id }}">
                                                            @csrf
                                                            @method('POST')
                                                            <div class="modal-header bg-success text-white">
                                                                <h6 class="modal-title">Quality Check
                                                                    Approval</h6>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>

                                                            </div>
                                                            <div class="modal-body py-3">
                                                                <div class="mb-3">
                                                                    <label for="qc_approve{{ $downtime->id }}"
                                                                        class="form-label">QC
                                                                        Approve <span class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm @error('qc_approve') is-invalid @enderror"
                                                                        id="qc_approve{{ $downtime->id }}"
                                                                        name="qc_approve" required
                                                                        placeholder="Contoh: tengku/1233">
                                                                    <small class="text-muted">
                                                                        Format: name/badge
                                                                    </small>
                                                                    @error('qc_approve')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="mb-2">
                                                                    <label for="production_verify{{ $downtime->id }}"
                                                                        class="form-label">Production Verify <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm @error('production_verify') is-invalid @enderror"
                                                                        id="production_verify{{ $downtime->id }}"
                                                                        name="production_verify" required
                                                                        placeholder="Contoh: tengku/1233">
                                                                    <small class="text-muted">
                                                                        Format: name/badge
                                                                    </small>
                                                                    @error('production_verify')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer py-2">
                                                                <button type="button" class="btn btn-sm btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-sm btn-success">
                                                                    Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $downtime->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title"
                                                                id="deleteModalLabel{{ $downtime->id }}">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>Delete
                                                                Confirmation
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this downtime?</p>
                                                            <p class="text-muted">
                                                                Badge: {{ $downtime->badge }}<br>
                                                                Line: {{ $downtime->line }}<br>
                                                                Molding M/C: {{ $downtime->mesin->molding_mc }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i>Cancel
                                                            </button>
                                                            <form action="{{ route('downtime.destroy', $downtime) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="20" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="fas fa-search-minus fs-2 mb-3 d-block"></i>
                                                        @if (request('search'))
                                                            <p class="mb-0">No data found that matches the search
                                                                "{{ request('search') }}"</p>
                                                            <small class="d-block mt-2">
                                                                @if (request('filter_type') && request('filter_type') != 'all')
                                                                    Filter: {{ ucfirst(request('filter_type')) }}
                                                                @endif
                                                            </small>
                                                            <a href="{{ route('downtime.index', ['show' => request('show')]) }}"
                                                                class="btn btn-sm btn-outline-secondary mt-3">
                                                                <i class="fas fa-redo-alt me-1"></i>Reset Search
                                                            </a>
                                                        @else
                                                            <p class="mb-0">No data available yet</p>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $downtimes->links() }}
                        </div>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        var colCount = $('table th').length;
                        $('.no-data-row td').attr('colspan', colCount);
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        // ===== DEFECT CATEGORY HANDLING =====
                        $('.is_custom_defect').on('change', function() {
                            const modalId = $(this).closest('.modal').attr('id');
                            // Perbaiki template literals dengan menambahkan backticks (`)
            const standardDefectDiv = $(`#${modalId} #standard_defect_div`);
            const customDefectDiv = $(`#${modalId} #custom_defect_div`);
            const defectCategorySelect = $(`#${modalId} select[name="defect_category"]`);
            const customDefectInput = $(`#${modalId} input[name="custom_defect_category"]`);

            if (this.checked) {
                standardDefectDiv.hide();
                customDefectDiv.show();
                defectCategorySelect.removeAttr('required');
                customDefectInput.attr('required', 'required');
            } else {
                standardDefectDiv.show();
                customDefectDiv.hide();
                defectCategorySelect.attr('required', 'required');
                customDefectInput.removeAttr('required');
            }
        });

        // Set initial state when modal opens
        $('.modal').on('show.bs.modal', function() {
            const modalId = $(this).attr('id');
            // Perbaiki template literal
            const checkbox = $(`#${modalId} .is_custom_defect`);
            checkbox.trigger('change');
        });

        // ===== START BUTTON HANDLING =====
        $('.btn-start').on('click', function() {
            const btnStart = $(this);
            const downtimeId = btnStart.data('id');
            const row = btnStart.closest('tr');

            btnStart.prop('disabled', true);

            const currentDate = new Date();
            const formattedDate = currentDate.toISOString().split('T')[0];
            const formattedTime = currentDate.toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });



            // Immediately update UI
            const statusCell = btnStart.closest('.status-cell');
            const dateCell = row.find('.start-date');
            const timeCell = row.find('.start-time');

            // Update UI immediately before AJAX call
            statusCell.html(`
                                        <div class="text-center">
                                            <span class="badge bg-warning">
                                                

                                In Progress
                                            </span>
                                        </div>
                                    `);
            dateCell.text(formattedDate);
            timeCell.text(formattedTime);

            // Add finish button immediately if user is teknisi
            const actionsCell = row.find('td:last-child').find('div');
            @if (auth()->user()->role == 'teknisi')
                // Add finish button right away
                if (actionsCell.find('.btn-finish').length === 0) {
                    actionsCell.append(`
                                                <a href="{{ route('finishdowntime.create', '') }}/${downtimeId}" 
                                                   class="btn btn-sm btn-outline-success btn-finish ms-1">
                                                    <i class="fas fa-check"></i> Finish
                                                </a>
                                            `);
                }
            @endif

            // Send data to server
            $.ajax({
                url: `{{ route('downtime.start', '') }}/${downtimeId}`,
                type: 'POST',
                data: {
                    date: formattedDate, // Sekarang mengirim dalam format DD-MM-YYYY
                    time: formattedTime,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // UI is already updated
                        // We don't need to do anything else here since we've already added the Finish button
                    }
                },
                error: function(xhr) {
                    // Revert UI changes if the server request fails
                    btnStart.prop('disabled', false);
                    statusCell.html(`
                                                <button id="startBtn${downtimeId}" class="btn btn-success btn-start" data-id="${downtimeId}">
                                                    Start
                                                </button>
                                            `);
                                    dateCell.text('N/A');
                                    timeCell.text('N/A');

                                    // Remove the finish button if it was added
                                    actionsCell.find('.btn-finish').remove();

                                    alert('Error starting downtime: ' + (xhr.responseJSON ? xhr.responseJSON
                                        .message : 'Unknown error'));
                                }
                            });
                        });
                        // ===== PER PAGE SELECT HANDLING =====
                        $('#perPageSelect').on('change', function() {
                            const currentUrl = new URL(window.location.href);
                            currentUrl.searchParams.set('show', this.value);
                            window.location.href = currentUrl.toString();
                        });
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Store column states - initially set to false (hidden)
                        const columnStates = {
                            submit: false,
                            start: false,
                            finish: false
                        };

                        // Function to update colspan and visibility
                        function toggleColumnGroup(group) {
                            const header = document.querySelector(`[data-group="${group}"]`);
                            const timeColumns = document.querySelectorAll(`.${group}-time`);
                            const indicator = header.querySelector('.collapse-indicator');

                            columnStates[group] = !columnStates[group];

                            // Update colspan
                            header.colSpan = columnStates[group] ? 2 : 1;

                            // Toggle time column visibility
                            timeColumns.forEach(cell => {
                                cell.classList.toggle('hidden-column');
                            });

                            // Update indicator icon
                            indicator.className = columnStates[group] ?
                                'fas fa-chevron-up collapse-indicator' :
                                'fas fa-chevron-down collapse-indicator';
                        }

                        // Function to initialize column states
                        function initializeColumnStates() {
                            Object.keys(columnStates).forEach(group => {
                                const header = document.querySelector(`[data-group="${group}"]`);
                                const timeColumns = document.querySelectorAll(`.${group}-time`);
                                const indicator = header.querySelector('.collapse-indicator');

                                // Set initial state (hidden)
                                header.colSpan = 1;
                                timeColumns.forEach(cell => {
                                    cell.classList.add('hidden-column');
                                });
                                indicator.className = 'fas fa-chevron-down collapse-indicator';
                            });
                        }

                        // Add click handlers
                        document.querySelectorAll('.collapsible-header').forEach(header => {
                            header.addEventListener('click', function() {
                                const group = this.dataset.group;
                                toggleColumnGroup(group);
                            });
                        });

                        // Initialize columns as hidden when page loads
                        initializeColumnStates();
                    });
                </script>
            @endsection
