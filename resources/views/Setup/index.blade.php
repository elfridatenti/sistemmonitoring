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
            min-width: 1500px;
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




        /* Column Widths */
        .table th.no-column {
            width: 50px;
        }

        .table th.badge-column {
            width: 100px;
        }

        .table th.line-column {
            width: 80px;
        }

        .table th.schedule-column {
            width: 100px;
        }

        .table td .schedule-date-time {
            white-space: normal;
            line-height: 1.3;
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
            color: #156e45;
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
    <style>
        .bg-warning-light {
            background-color: #ffeb3b !important;
            /* Bright yellow */
            color: #000;
            /* Black text for better contrast */
        }

        .bg-warning {
            background-color: #ffc107 !important;
            /* Standard warning color (darker yellow/orange) */
        }
    </style>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card form-card">
                    <div class="card-header bg-gradient-primary">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="mb-0 text-white">LIST OF PRODUCTION MACHINE SETUP REQUESTS</h4>
                        </div>
                        <p class="mb-0 text-white-50">"Molding Machine Setup Request List"</p>
                    </div>


                    <div class="card-body">
                        <!-- Alert dengan animasi fade -->
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
                        <form action="{{ route('setup.index') }}" method="GET">
                            <div class="row align-items-end">
                                <!-- Show Entries - Tetap di posisi kiri -->
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



                                <!-- Filter Status -->
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
                                                <option value="Pending QC"
                                                    {{ request('status') === 'Pending QC' ? 'selected' : '' }}>
                                                    Pending QC</option>
                                                <option value="Completed"
                                                    {{ request('status') === 'Completed' ? 'selected' : '' }}>
                                                    Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col"></div>

                                <!-- Filter Type -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-1">Filter By</label>
                                        <select name="filter_type" class="form-select form-select-sm shadow-sm"
                                            style="cursor: pointer;">
                                            <option value="all"
                                                {{ request('filter_type') === 'all' ? 'selected' : '' }}>All</option>
                                            <option value="leader"
                                                {{ request('filter_type') === 'leader' ? 'selected' : '' }}>Leader</option>
                                            <option value="line"
                                                {{ request('filter_type') === 'line' ? 'selected' : '' }}>Line</option>
                                            <option value="schedule_datetime"
                                                {{ request('filter_type') === 'schedule_datetime' ? 'selected' : '' }}>
                                                Schedule Datetime</option>
                                            <option value="maintenance_name"
                                                {{ request('filter_type') === 'maintenance_name' ? 'selected' : '' }}>
                                                Technician Name</option>
                                            <option value="part_number"
                                                {{ request('filter_type') === 'part_number' ? 'selected' : '' }}>Part
                                                Number</option>

                                            <option value="customer"
                                                {{ request('filter_type') === 'customer' ? 'selected' : '' }}>Customer
                                            </option>
                                            <option value="mould_type"
                                                {{ request('filter_type') === 'mould_type' ? 'selected' : '' }}>Mould Type
                                            </option>
                                            <option value="mould_category"
                                                {{ request('filter_type') === 'mould_category' ? 'selected' : '' }}>Mould
                                                Category</option>


                                            <option value="molding_machine"
                                                {{ request('filter_type') === 'molding_machine' ? 'selected' : '' }}>
                                                Molding M/C</option>




                                        </select>
                                    </div>
                                </div>

                                <!-- Search Bar -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-1">Search</label>
                                        <div class="d-flex align-items-center">
                                            <div class="input-group input-group-sm shadow-sm">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Search..." value="{{ request('search') }}">

                                                @if (request('search'))
                                                    <a href="{{ route('setup.index', ['show' => request('show')]) }}"
                                                        class="btn btn-outline-secondary">
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
                        </form>

                        <div class="mt-4">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Leader</th>
                                            <th rowspan="2">Line</th>
                                            <th rowspan="2" class="schedule-column">Schedule </br> Date/Time</th>
                                            <th rowspan="2">Technician</br> Name</th>
                                            <th rowspan="2">Part Number</th>
                                            <th rowspan="2">Customer</th>
                                            <th rowspan="2">Mould Type</th>
                                            <th rowspan="2">Mould Category</th>
                                            <th rowspan="2">Molding </br> M/C</th>


                                            <th colspan="2" class="text-center collapsible-header" data-group="submit"
                                                style="cursor: pointer;">
                                                Submit <i class="fas fa-chevron-up collapse-indicator"></i>
                                            </th>
                                            <th colspan="2" class="text-center collapsible-header" data-group="start"
                                                style="cursor: pointer;">
                                                Start <i class="fas fa-chevron-up collapse-indicator"></i>
                                            </th>
                                            <th colspan="2" class="text-center collapsible-header" data-group="finish"
                                                style="cursor: pointer;">
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
                                            {{-- @if (auth()->user()->role === 'leader') --}}
                                            <th class="text-center finish-date">Date</th>
                                            <th class="text-center finish-time time-column">Time</th>
                                            {{-- @endif --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($setups as $setup)
                                            <tr>
                                                <td class="number-cell">{{ $loop->iteration }}</td>
                                                <td>{{ $setup->user->nama }}</td>
                                                <td class="text-center">{{ $setup->line }}</td>
                                                <td>
                                                    <div class="d-flex flex-column text-center">
                                                        <span>{{ \Carbon\Carbon::parse($setup->schedule_datetime)->format('Y-m-d') }}</span>
                                                        <span
                                                            class="small text-muted">{{ \Carbon\Carbon::parse($setup->schedule_datetime)->format('H:i') }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ App\Models\User::find($setup->maintenance_name)->nama ?? 'N/A' }}
                                                </td>
                                                <td>{{ $setup->part_number }}</td>
                                                <td>{{ $setup->customer }}</td>
                                                <td>{{ $setup->mould_type }}</td>
                                                <td>{{ $setup->mould_category }}</td>
                                                <td class="text-center">{{ $setup->mesin->molding_mc }}</td>

                                                <td class="submit-date text-center">
                                                    {{ $setup->tanggal_submit_formatted ?? 'N/A' }}
                                                </td>
                                                <td class="submit-time time-column text-center">
                                                    {{ $setup->jam_submit_formatted ?? 'N/A' }}
                                                </td>
                                                <!-- Start columns -->
                                                <td class="start-date  text-center">
                                                    {{ $setup->tanggal_start_formatted ?? 'N/A' }}</td>
                                                <td class="start-time time-column text-center">
                                                    {{ $setup->jam_start_formatted ?? 'N/A' }}</td>
                                                <!-- Finish columns -->
                                                {{-- @if (auth()->user()->role === 'leader') --}}
                                                <td class="finish-date text-center">
                                                    {{ $setup->tanggal_finish_formatted ?? 'N/A' }}</td>
                                                <td class="finish-time time-column text-center">
                                                    {{ $setup->jam_finish_formatted ?? 'N/A' }}</td>
                                                {{-- @endif --}}


                                                <td class="status-cell">
                                                    <div class="text-center">
                                                        @if (auth()->user()->role === 'teknisi')
                                                            @if ($setup->status === 'Waiting')
                                                                <button id="startBtn{{ $setup->id }}"
                                                                    class="btn btn-success btn-start"
                                                                    data-id="{{ $setup->id }}">
                                                                    Start
                                                                </button>
                                                            @else
                                                                <span
                                                                    class="badge
                                                            @if ($setup->status === 'Completed') bg-success
                                                            @elseif($setup->status === 'In Progress') bg-warning
                                                            @elseif($setup->status === 'Waiting QC Approve') bg-secondary  
                                                            @elseif($setup->status === 'Pending QC') bg-warning-light
                                                            @else bg-danger @endif">
                                                                    {{ $setup->status }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span
                                                                class="badge
                                                        @if ($setup->status === 'Completed') bg-success
                                                        @elseif($setup->status === 'In Progress') bg-warning
                                                        @elseif($setup->status === 'Waiting QC Approve') bg-secondary
                                                        @elseif($setup->status === 'Pending QC') bg-warning-light
                                                        @else bg-danger @endif">
                                                                {{ $setup->status ?? 'Waiting' }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="display: flex; gap: 2px; justify-content: center; align-items: center;">
                                                        {{-- View button - accessible to all users --}}
                                                        <a href="{{ route('rekapsetup.show', ['setup' => $setup]) }}"
                                                            class="btn btn-sm btn-outline-primary"
                                                            onclick="console.log('Setup ID:', {{ $setup->id }})">
                                                            <i class="far fa-eye "></i>
                                                        </a>
                                                        {{-- Edit button - only for leader when status is 'waiting' --}}
                                                        {{-- @if (auth()->user()->role == 'leader' && $setup->status == 'Waiting')
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal{{ $setup->id }}">
                                                                <i class="far fa-edit "></i>
                                                            </button>
                                                        @endif --}}
                                                        {{-- Delete button - for leader when status is 'waiting' OR admin when status is 'completed' --}}
                                                        @if (
                                                            (auth()->user()->role == 'leader' && $setup->status == 'Waiting') ||
                                                                (auth()->user()->role == 'admin' && $setup->status == 'Completed'))
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $setup->id }}">
                                                                <i class="far fa-trash-alt "></i>
                                                            </button>
                                                        @endif
                                                        {{-- Finish button - only for technicians when status is 'In Progress' --}}
                                                        @if (auth()->user()->role == 'teknisi' && $setup->status == 'In Progress')
                                                            <a href="{{ route('finishsetup.create', ['setup_id' => $setup->id]) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="fas fa-check"></i> Finish
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->role === 'ipqc' && ($setup->status === 'Waiting QC Approve' || $setup->status === 'Pending QC'))
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approvalModal{{ $setup->id }}">
                                                                <i class="far fa-check-circle"></i>
                                                                {{ $setup->status === 'Pending QC' ? 'Update' : 'Approve' }}
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            {{-- approvalModal --}}
                                            <div class="modal fade" id="approvalModal{{ $setup->id }}" tabindex="-1"
                                                aria-labelledby="approvalModalLabel{{ $setup->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success text-white">
                                                            <h5 class="modal-title"
                                                                id="approvalModalLabel{{ $setup->id }}">
                                                                Quality Check
                                                                {{ $setup->status === 'Pending QC' ? 'Update' : 'Approval' }}
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ $setup->status === 'Pending QC' ? route('qc.update', $setup->id) : route('rekapsetup.approve', $setup->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @if ($setup->status === 'Pending QC')
                                                                @method('PUT')
                                                            @endif
                                                            <div class="modal-body">
                                                                @if ($errors->any())
                                                                    <div class="alert alert-danger">
                                                                        <ul class="mb-0">
                                                                            @foreach ($errors->all() as $error)
                                                                                <li>{{ $error }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                @endif

                                                                <div class="mb-4">
                                                                    <h6 class="text-success mb-3">Quality Check Items</h6>
                                                                    <!-- Marking Check -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label d-block">Marking
                                                                            Check</label>
                                                                        <div class="btn-group" role="group">
                                                                            @php
                                                                                // Extract marking status and remarks from the database if status is Pending QC
                                                                                $markingValue = 'Pass'; // Default
                                                                                $markingRemarks = '';

                                                                                if (
                                                                                    $setup->status === 'Pending QC' &&
                                                                                    isset($setup->marking)
                                                                                ) {
                                                                                    // Check if the marking field contains "Failed:"
                                                                                    if (
                                                                                        strpos(
                                                                                            $setup->marking,
                                                                                            'Failed:',
                                                                                        ) === 0
                                                                                    ) {
                                                                                        $markingValue = 'Failed';
                                                                                        $markingRemarks = trim(
                                                                                            substr($setup->marking, 8),
                                                                                        ); // Extract remarks after "Failed: "
                                                                                    } else {
                                                                                        $markingValue = 'Pass';
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <input type="radio"
                                                                                class="btn-check check-toggle"
                                                                                name="marking"
                                                                                id="marking_ok_{{ $setup->id }}"
                                                                                data-target="marking_remarks_{{ $setup->id }}"
                                                                                value="Pass" required
                                                                                {{ $markingValue === 'Pass' ? 'checked' : '' }}>
                                                                            <label class="btn btn-outline-success btn-sm"
                                                                                for="marking_ok_{{ $setup->id }}">OK</label>
                                                                            <input type="radio"
                                                                                class="btn-check check-toggle"
                                                                                name="marking"
                                                                                id="marking_ng_{{ $setup->id }}"
                                                                                data-target="marking_remarks_{{ $setup->id }}"
                                                                                value="Failed"
                                                                                {{ $markingValue === 'Failed' ? 'checked' : '' }}>
                                                                            <label class="btn btn-outline-danger btn-sm"
                                                                                for="marking_ng_{{ $setup->id }}">NG</label>
                                                                        </div>
                                                                        <div id="marking_remarks_{{ $setup->id }}"
                                                                            class="remarks-field mt-2 {{ $markingValue === 'Failed' ? '' : 'd-none' }}">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                name="marking_remarks"
                                                                                placeholder="Enter remarks for Marking NG"
                                                                                value="{{ $markingRemarks }}"
                                                                                {{ $markingValue === 'Failed' ? 'required' : '' }}>
                                                                            <div class="invalid-feedback">
                                                                                Kolom ini wajib diisi jika marking NG
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Relief Check -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label d-block">Relief
                                                                            Check</label>
                                                                        <div class="btn-group" role="group">
                                                                            @php
                                                                                // Extract relief status and remarks from the database if status is Pending QC
                                                                                $reliefValue = 'Pass'; // Default
                                                                                $reliefRemarks = '';

                                                                                if (
                                                                                    $setup->status === 'Pending QC' &&
                                                                                    isset($setup->relief)
                                                                                ) {
                                                                                    // Check if the relief field contains "Failed:"
                                                                                    if (
                                                                                        strpos(
                                                                                            $setup->relief,
                                                                                            'Failed:',
                                                                                        ) === 0
                                                                                    ) {
                                                                                        $reliefValue = 'Failed';
                                                                                        $reliefRemarks = trim(
                                                                                            substr($setup->relief, 8),
                                                                                        ); // Extract remarks after "Failed: "
                                                                                    } else {
                                                                                        $reliefValue = 'Pass';
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <input type="radio"
                                                                                class="btn-check check-toggle"
                                                                                name="relief"
                                                                                id="relief_ok_{{ $setup->id }}"
                                                                                data-target="relief_remarks_{{ $setup->id }}"
                                                                                value="Pass" required
                                                                                {{ $reliefValue === 'Pass' ? 'checked' : '' }}>
                                                                            <label class="btn btn-outline-success btn-sm"
                                                                                for="relief_ok_{{ $setup->id }}">OK</label>
                                                                            <input type="radio"
                                                                                class="btn-check check-toggle"
                                                                                name="relief"
                                                                                id="relief_ng_{{ $setup->id }}"
                                                                                data-target="relief_remarks_{{ $setup->id }}"
                                                                                value="Failed"
                                                                                {{ $reliefValue === 'Failed' ? 'checked' : '' }}>
                                                                            <label class="btn btn-outline-danger btn-sm"
                                                                                for="relief_ng_{{ $setup->id }}">NG</label>
                                                                        </div>
                                                                        <div id="relief_remarks_{{ $setup->id }}"
                                                                            class="remarks-field mt-2 {{ $reliefValue === 'Failed' ? '' : 'd-none' }}">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                name="relief_remarks"
                                                                                placeholder="Enter remarks for Relief NG"
                                                                                value="{{ $reliefRemarks }}"
                                                                                {{ $reliefValue === 'Failed' ? 'required' : '' }}>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Mismatch Check -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label d-block">Mismatch
                                                                            Check</label>
                                                                        <div class="btn-group" role="group">
                                                                            @php
                                                                                // Extract mismatch status and remarks from the database if status is Pending QC
                                                                                $mismatchValue = 'Pass'; // Default
                                                                                $mismatchRemarks = '';

                                                                                if (
                                                                                    $setup->status === 'Pending QC' &&
                                                                                    isset($setup->mismatch)
                                                                                ) {
                                                                                    // Check if the mismatch field contains "Failed:"
                                                                                    if (
                                                                                        strpos(
                                                                                            $setup->mismatch,
                                                                                            'Failed:',
                                                                                        ) === 0
                                                                                    ) {
                                                                                        $mismatchValue = 'Failed';
                                                                                        $mismatchRemarks = trim(
                                                                                            substr($setup->mismatch, 8),
                                                                                        ); // Extract remarks after "Failed: "
                                                                                    } else {
                                                                                        $mismatchValue = 'Pass';
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <input type="radio"
                                                                                class="btn-check check-toggle"
                                                                                name="mismatch"
                                                                                id="mismatch_ok_{{ $setup->id }}"
                                                                                data-target="mismatch_remarks_{{ $setup->id }}"
                                                                                value="Pass" required
                                                                                {{ $mismatchValue === 'Pass' ? 'checked' : '' }}>
                                                                            <label class="btn btn-outline-success btn-sm"
                                                                                for="mismatch_ok_{{ $setup->id }}">OK</label>
                                                                            <input type="radio"
                                                                                class="btn-check check-toggle"
                                                                                name="mismatch"
                                                                                id="mismatch_ng_{{ $setup->id }}"
                                                                                data-target="mismatch_remarks_{{ $setup->id }}"
                                                                                value="Failed"
                                                                                {{ $mismatchValue === 'Failed' ? 'checked' : '' }}>
                                                                            <label class="btn btn-outline-danger btn-sm"
                                                                                for="mismatch_ng_{{ $setup->id }}">NG</label>
                                                                        </div>
                                                                        <div id="mismatch_remarks_{{ $setup->id }}"
                                                                            class="remarks-field mt-2 {{ $mismatchValue === 'Failed' ? '' : 'd-none' }}">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                name="mismatch_remarks"
                                                                                placeholder="Enter remarks for Mismatch NG"
                                                                                value="{{ $mismatchRemarks }}"
                                                                                {{ $mismatchValue === 'Failed' ? 'required' : '' }}>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Pin Bar Connector Check -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label d-block">Pin Bar Connector
                                                                            Check</label>
                                                                        <div class="btn-group" role="group">
                                                                            @php
                                                                                // Extract pin_bar_connector status and remarks from the database if status is Pending QC
                                                                                $pinBarValue = 'Pass'; // Default
                                                                                $pinBarRemarks = '';

                                                                                if (
                                                                                    $setup->status === 'Pending QC' &&
                                                                                    isset($setup->pin_bar_connector)
                                                                                ) {
                                                                                    // Check if the pin_bar_connector field contains "Failed:"
                                                                                    if (
                                                                                        strpos(
                                                                                            $setup->pin_bar_connector,
                                                                                            'Failed:',
                                                                                        ) === 0
                                                                                    ) {
                                                                                        $pinBarValue = 'Failed';
                                                                                        $pinBarRemarks = trim(
                                                                                            substr(
                                                                                                $setup->pin_bar_connector,
                                                                                                8,
                                                                                            ),
                                                                                        ); // Extract remarks after "Failed: "
                                                                                    } else {
                                                                                        $pinBarValue = 'Pass';
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <input type="radio"
                                                                                class="btn-check check-toggle"
                                                                                name="pin_bar_connector"
                                                                                id="pin_bar_connector_ok_{{ $setup->id }}"
                                                                                data-target="pin_bar_connector_remarks_{{ $setup->id }}"
                                                                                value="Pass" required
                                                                                {{ $pinBarValue === 'Pass' ? 'checked' : '' }}>
                                                                            <label class="btn btn-outline-success btn-sm"
                                                                                for="pin_bar_connector_ok_{{ $setup->id }}">OK</label>
                                                                            <input type="radio"
                                                                                class="btn-check check-toggle"
                                                                                name="pin_bar_connector"
                                                                                id="pin_bar_connector_ng_{{ $setup->id }}"
                                                                                data-target="pin_bar_connector_remarks_{{ $setup->id }}"
                                                                                value="Failed"
                                                                                {{ $pinBarValue === 'Failed' ? 'checked' : '' }}>
                                                                            <label class="btn btn-outline-danger btn-sm"
                                                                                for="pin_bar_connector_ng_{{ $setup->id }}">NG</label>
                                                                        </div>
                                                                        <div id="pin_bar_connector_remarks_{{ $setup->id }}"
                                                                            class="remarks-field mt-2 {{ $pinBarValue === 'Failed' ? '' : 'd-none' }}">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                name="pin_bar_connector_remarks"
                                                                                placeholder="Enter remarks for Pin Bar Connector NG"
                                                                                value="{{ $pinBarRemarks }}"
                                                                                {{ $pinBarValue === 'Failed' ? 'required' : '' }}>
                                                                        </div>
                                                                    </div>
                                                                    <!-- QC Approval -->
                                                                    <div class="mb-3">
                                                                        <label for="qc_approve{{ $setup->id }}"
                                                                            class="form-label">
                                                                            QC Approve <span class="text-danger">*</span>
                                                                        </label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm @error('qc_approve') is-invalid @enderror"
                                                                            id="qc_approve{{ $setup->id }}"
                                                                            name="qc_approve" required
                                                                            placeholder="Contoh: tengku/1233"
                                                                            value="{{ $setup->status === 'Pending QC' ? $setup->qc_approve : '' }}">
                                                                        <small class="text-muted">Format:
                                                                            name/badge</small>
                                                                        @error('qc_approve')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-success">
                                                                    {{ $setup->status === 'Pending QC' ? 'Update' : 'Save' }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteModal{{ $setup->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title"
                                                                id="deleteModalLabel{{ $setup->id }}">
                                                                <i class="fas fa-exclamation-triangle me-2"></i> Delete
                                                                Confirmation
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this setup request?</p>
                                                            <p class="text-muted">
                                                                Line: {{ $setup->line }}<br>
                                                                Part Number: {{ $setup->part_number }}<br>
                                                                Schedule:
                                                                {{ \Carbon\Carbon::parse($setup->schedule_datetime)->format('Y-m-d H:i') }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i>Cancel
                                                            </button>
                                                            <form action="{{ route('setup.destroy', $setup) }}"
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
                                                            <a href="{{ route('setup.index', ['show' => request('show')]) }}"
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
                            <div class="mt-3">
                            {{ $setups->links() }}
                            </div>
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
                        $('.btn-start').on('click', function() {
                            const btnStart = $(this);
                            const setupId = btnStart.data('id');
                            const row = btnStart.closest('tr');

                            // Disable button to prevent double clicks
                            btnStart.prop('disabled', true);

                            // Get current date and time
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
                            const startDateCell = row.find('.start-date');
                            const startTimeCell = row.find('.start-time');

                            // Update UI before AJAX call
                            statusCell.html(`
            <div class="text-center">
                <span class="badge bg-warning">
                    In Progress
                </span>
            </div>
        `);
                            startDateCell.text(formattedDate);
                            startTimeCell.text(formattedTime);

                            // Immediately add the finish button if user is teknisi
                            const actionsCell = row.find('td:last-child').find('div');
                            const userRole = '{{ auth()->user()->role }}';

                            if (userRole === 'teknisi') {
                                // Add finish button immediately
                                if (actionsCell.find('.btn-finish').length === 0) {
                                    actionsCell.append(`
                    <a href="{{ route('finishsetup.create', '') }}/${setupId}" 
                       class="btn btn-sm btn-outline-success btn-finish ms-1">
                        <i class="fas fa-check"></i> Finish
                    </a>
                `);
                                }
                            }

                            // Send data to server
                            $.ajax({
                                url: `{{ route('setup.start', '') }}/${setupId}`,
                                type: 'POST',
                                data: {
                                    date: formattedDate,
                                    time: formattedTime,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.success) {
                                        // Optional: Update with server-returned values if they differ
                                        if (response.date !== formattedDate) {
                                            startDateCell.text(response.date);
                                        }
                                        if (response.time !== formattedTime) {
                                            startTimeCell.text(response.time);
                                        }
                                        if (response.status) {
                                            statusCell.html(`
                            <div class="text-center">
                                <span class="badge bg-warning">
                                    ${response.status}
                                </span>
                            </div>
                        `);
                                        }

                                        setTimeout(function() {
                                            location.reload();
                                        }, 500);
                                    }
                                },
                                error: function(xhr) {
                                    // Revert UI changes on error
                                    statusCell.html(`
                    <button id="startBtn${setupId}" class="btn btn-success btn-start" data-id="${setupId}">
                        Start
                    </button>
                `);
                                    startDateCell.text('N/A');
                                    startTimeCell.text('N/A');

                                    // Remove the finish button if it was added
                                    actionsCell.find('.btn-finish').remove();

                                    // Re-enable button
                                    btnStart.prop('disabled', false);

                                    // Show error message
                                    alert('Error starting setup: ' +
                                        (xhr.responseJSON ? xhr.responseJSON.message : 'Unknown error'));
                                }
                            });
                        });
                    });
                </script>
                <script>
                    document.getElementById('perPageSelect').addEventListener('change', function() {
                        let currentUrl = new URL(window.location.href);
                        currentUrl.searchParams.set('show', this.value);
                        window.location.href = currentUrl.toString();
                    });

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
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const alert = document.querySelector('.alert');
                        if (alert) {
                            const bsAlert = new bootstrap.Alert(alert);
                            setTimeout(function() {
                                bsAlert.close();
                            }, 3000);
                        }
                    });
                </script>

                <!-- Add JavaScript to toggle remarks fields -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Add event listeners to all radio buttons with the check-toggle class
                        const checkToggles = document.querySelectorAll('.check-toggle');

                        checkToggles.forEach(toggle => {
                            toggle.addEventListener('change', function() {
                                const targetId = this.getAttribute('data-target');
                                const targetElement = document.getElementById(targetId);
                                const isNG = this.value === 'Failed';

                                if (targetElement) {
                                    if (isNG) {
                                        targetElement.classList.remove('d-none');
                                        targetElement.querySelector('input').setAttribute('required',
                                            'required');
                                    } else {
                                        targetElement.classList.add('d-none');
                                        targetElement.querySelector('input').removeAttribute('required');
                                        targetElement.querySelector('input').value = '';
                                    }
                                }
                            });
                        });
                    });
                </script>
            @endsection
