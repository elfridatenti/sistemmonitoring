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
            width: 80px;
        }

        .table th.line-column {
            width: 50px;
        }

        .table th.schedule-column {
            width: 100px;
        }

        .table td .schedule-date-time {
            white-space: normal;
            line-height: 1.3;
        }

        .table th.leader-column {
            width: 100px;
        }

        .table th.maintenance-column {
            width: 100px;
        }

        .table th.date-column {
            width: 100px;
        }

        .table th.time-column {
            width: 80px;
        }

        .table th.status-column {
            width: 150px;
        }

        .table th.actions-column {
            width: flex;
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

        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            vertical-align: middle;
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

    


    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card form-card">
                    <div class="card-header bg-gradient-primary">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="mb-0 text-white">REKAPITULASI SETUP MESIN MOLDING</h4>
                        </div>
                        <p class="mb-0 text-white-50">Rekapitulasi Request Setup Mesin Molding</p>
                    </div>



                    <!-- Card Body with Table -->
                    <div class="card-body">
                        <!-- Alert Messages -->
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
                        <form action="{{ route('rekapsetup.search') }}" method="GET">
                            <div class="row align-items-end">

                                <div class="col-auto">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-2">
                                            Show Entries
                                        </label>
                                        <select class="form-select form-select-sm shadow-sm" name="show"
                                            id="perPageSelect" style="width: 70px; cursor: pointer;">
                                            <option value="10" {{ request('show') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="20" {{ request('show') == 20 ? 'selected' : '' }}>20</option>
                                            <option value="50" {{ request('show') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request('show') == 100 ? 'selected' : '' }}>100
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Spacer -->
                                <div class="col"></div>

                                <!-- Filter - Right Side -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-2">
                                            Filter By
                                        </label>
                                        <select name="filter_type" class="form-select form-select-sm shadow-sm"
                                            style="cursor: pointer;">
                                            <option value="all" {{ request('filter_type') === 'all' ? 'selected' : '' }}>
                                                Semua Data</option>
                                            <option value="leader"
                                                {{ request('filter_type') === 'leader' ? 'selected' : '' }}>Leader</option>
                                            <option value="line"
                                                {{ request('filter_type') === 'line' ? 'selected' : '' }}>Line</option>
                                            <option value="maintenance_name"
                                                {{ request('filter_type') === 'maintenance_name' ? 'selected' : '' }}>
                                                Maintenance Repair</option>
                                            <option value="qc_approve"
                                                {{ request('filter_type') === 'qc_approve' ? 'selected' : '' }}>QC Verify
                                            </option>
                                            <option value="mould_type"
                                                {{ request('filter_type') === 'mould_type' ? 'selected' : '' }}>Mould Type
                                            </option>
                                            <option value="part_number"
                                                {{ request('filter_type') === 'part_number' ? 'selected' : '' }}>Part
                                                Number</option>
                                            <option value="customer"
                                                {{ request('filter_type') === 'customer' ? 'selected' : '' }}>Customer
                                            </option>
                                            <option value="schedule_datetime"
                                                {{ request('filter_type') === 'schedule_datetime' ? 'selected' : '' }}>
                                                Schedule Date</option>
                                            <option value="mould_category"
                                                {{ request('filter_type') === 'mould_category' ? 'selected' : '' }}>Mould
                                                Category</option>
                                            <option value="molding_mc"
                                                {{ request('filter_type') === 'molding_mc' ? 'selected' : '' }}>Molding
                                                Machine</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Search - Right Side -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-2">
                                            Search
                                        </label>
                                        <div class="input-group input-group-sm shadow-sm">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari data..." value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-primary px-3">
                                                <i class="fas fa-search me-1"></i>
                                            </button>
                                            @if (request('search'))
                                                <a href="{{ route('rekapsetup.search', ['show' => request('show')]) }}"
                                                    class="btn btn-outline-secondary">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Table -->
                        <div class="mt-4">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">No</th>

                                            <th rowspan="2" class="text-center">Leader</th>
                                            <th rowspan="2" class="text-center">Line</th>
                                            <th rowspan="2" class="schedule-column">Schedule </br> Date/Time</th>
                                            <th rowspan="2" class="text-center">Maintenance </br> Repair</th>
                                            <th rowspan="2" class="text-center">QC Verify</th>
                                            <th rowspan="2" class="text-center">Molding </br> M/C</th>
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
                                            <th rowspan="2" class="text-center">Status</th>
                                            <th rowspan="2" class="text-center">Aksi</th>
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
                                        @forelse ($setups as $setup)
                                            <tr>
                                                <td class="number-cell">{{ $loop->iteration }}</td>
                                                <td>{{ $setup->user->nama ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $setup->line }}</td>
                                                <td>
                                                    <div class="d-flex flex-column text-center">
                                                        <span>{{ \Carbon\Carbon::parse($setup->schedule_datetime)->format('Y-m-d') }}</span>
                                                        <span
                                                            class="small text-muted">{{ \Carbon\Carbon::parse($setup->schedule_datetime)->format('H:i') }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $setup->maintenance_name }}</td>
                                                <td class="{{ ($setup->qc_approve ?? 'N/A') == 'N/A' ? 'text-center' : '' }}">{{ $setup->qc_approve ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $setup->mesin->molding_mc }}</td>
                                                <td class="submit-date text-center">
                                                    {{ $setup->tanggal_submit_formatted ?? 'N/A' }}</td>
                                                <td class="submit-time time-column text-center">
                                                    {{ $setup->jam_submit_formatted ?? 'N/A' }}
                                                </td>
                                                <!-- Start columns -->
                                                <td class="start-date text-center">
                                                    {{ $setup->tanggal_start_formatted ?? 'N/A' }}</td>
                                                <td class="start-time time-column text-center">
                                                    {{ $setup->jam_start_formatted ?? 'N/A' }}</td>
                                                <!-- Finish columns -->
                                                <td class="finish-date text-center">
                                                    {{ $setup->tanggal_finish_formatted ?? 'N/A' }}</td>
                                                <td class="finish-time time-column text-center">
                                                    {{ $setup->jam_finish_formatted ?? 'N/A' }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($setup->status == 'Completed')
                                                        <span class="badge bg-success">Completed</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ $setup->status ?? 'N/A' }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div style="gap: 2px;">
                                                        <!-- View button - available for all users -->
                                                        <a href="{{ route('rekapsetup.show', $setup) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="far fa-eye "></i>
                                                        </a>
                                                        <!-- Edit and Delete buttons - only for admin -->
                                                        @if (auth()->user()->role === 'admin')
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal{{ $setup->id }}">
                                                                <i class="far fa-edit "></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $setup->id }}">
                                                                <i class="far fa-trash-alt "></i>
                                                            </button>
                                                        @endif
                                                        <!-- IPQC Approve button - only for IPQC role -->
                                                        @if (auth()->user()->role === 'ipqc' && $setup->status === 'Menunggu QC Approve')
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approvalModal{{ $setup->id }}">
                                                                <i class="far fa-check-circle "></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Approval Modal -->
                                            <div class="modal fade" id="approvalModal{{ $setup->id }}" tabindex="-1"
                                                aria-labelledby="approvalModalLabel{{ $setup->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success text-white">
                                                            <h5 class="modal-title"
                                                                id="approvalModalLabel{{ $setup->id }}">
                                                                Quality Check
                                                                Approval</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('rekapsetup.approve', $setup->id) }}"
                                                            method="POST">
                                                            @csrf
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
                                                                            <input type="radio" class="btn-check"
                                                                                name="marking"
                                                                                id="marking_ok_{{ $setup->id }}"
                                                                                value="Pass" required>
                                                                            <label class="btn btn-outline-success btn-sm"
                                                                                for="marking_ok_{{ $setup->id }}">OK</label>

                                                                            <input type="radio" class="btn-check"
                                                                                name="marking"
                                                                                id="marking_ng_{{ $setup->id }}"
                                                                                value="Failed">
                                                                            <label class="btn btn-outline-danger btn-sm"
                                                                                for="marking_ng_{{ $setup->id }}">NG</label>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Relief Check -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label d-block">Relief
                                                                            Check</label>
                                                                        <div class="btn-group" role="group">
                                                                            <input type="radio" class="btn-check"
                                                                                name="relief"
                                                                                id="relief_ok_{{ $setup->id }}"
                                                                                value="Pass" required>
                                                                            <label class="btn btn-outline-success btn-sm"
                                                                                for="relief_ok_{{ $setup->id }}">OK</label>

                                                                            <input type="radio" class="btn-check"
                                                                                name="relief"
                                                                                id="relief_ng_{{ $setup->id }}"
                                                                                value="Failed">
                                                                            <label class="btn btn-outline-danger btn-sm"
                                                                                for="relief_ng_{{ $setup->id }}">NG</label>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Mismatch Check -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label d-block">Mismatch
                                                                            Check</label>
                                                                        <div class="btn-group" role="group">
                                                                            <input type="radio" class="btn-check"
                                                                                name="mismatch"
                                                                                id="mismatch_ok_{{ $setup->id }}"
                                                                                value="Pass" required>
                                                                            <label class="btn btn-outline-success btn-sm"
                                                                                for="mismatch_ok_{{ $setup->id }}">OK</label>

                                                                            <input type="radio" class="btn-check"
                                                                                name="mismatch"
                                                                                id="mismatch_ng_{{ $setup->id }}"
                                                                                value="Failed">
                                                                            <label class="btn btn-outline-danger btn-sm"
                                                                                for="mismatch_ng_{{ $setup->id }}">NG</label>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Pin Bar Connector Check -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label d-block">Pin Bar Connector
                                                                            Check</label>
                                                                        <div class="btn-group" role="group">
                                                                            <input type="radio" class="btn-check"
                                                                                name="pin_bar_connector"
                                                                                id="pin_bar_connector_ok_{{ $setup->id }}"
                                                                                value="Pass" required>
                                                                            <label class="btn btn-outline-success btn-sm"
                                                                                for="pin_bar_connector_ok_{{ $setup->id }}">OK</label>

                                                                            <input type="radio" class="btn-check"
                                                                                name="pin_bar_connector"
                                                                                id="pin_bar_connector_ng_{{ $setup->id }}"
                                                                                value="Failed">
                                                                            <label class="btn btn-outline-danger btn-sm"
                                                                                for="pin_bar_connector_ng_{{ $setup->id }}">NG</label>
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
                                                                            placeholder="Contoh: tengku/1233">
                                                                        <small class="text-muted">Format:
                                                                            nama/badge</small>
                                                                        @error('qc_approve')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-success">Simpan
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteModal{{ $setup->id }}" tabindex="-1"
                                                aria-labelledby="deleteModalLabel{{ $setup->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title"
                                                                id="deleteModalLabel{{ $setup->id }}">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi
                                                                Penghapusan
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah yakin ingin menghapus rekap setup ini?</p>
                                                            <p class="text-muted">
                                                                Line: {{ $setup->line }}<br>
                                                                Molding Mesin: {{ $setup->mesin->molding_mc }}<br>
                                                                Maintenance Repair: {{ $setup->maintenance_name }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i>Batal
                                                            </button>
                                                            <form action="{{ route('rekapsetup.destroy', $setup) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fas fa-trash-alt me-1"></i>Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Edit Modal -->
                                            <!-- Here's the updated form design with external labels and light styling -->
                                            <div class="modal fade" id="editModal{{ $setup->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                                        <form action="{{ route('rekapsetup.update', $setup->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <!-- Modal Header -->
                                                            <div
                                                                class="modal-header bg-gradient-primary border-bottom-0 rounded-top-4">
                                                                <div class="d-flex align-items-center">
                                                                    <span
                                                                        class="modal-icon bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                                                        <i class="fas fa-cog text-light fs-4"></i>
                                                                    </span>
                                                                    <h5 class="modal-title mb-0">EDIT REKAPITULASI SETUP
                                                                    </h5>
                                                                </div>
                                                                <a href="{{ route('rekapsetup.index') }}"
                                                                    class="btn btn-outline-light hover-scale">
                                                                    <i class="bi bi-arrow-left me-1"></i> Back
                                                                </a>
                                                            </div>

                                                            <!-- Modal Body -->
                                                            <div class="modal-body p-4">
                                                                @if ($errors->any())
                                                                    <div class="alert alert-danger rounded-3">
                                                                        <ul class="mb-0">
                                                                            @foreach ($errors->all() as $error)
                                                                                <li>{{ $error }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                @endif

                                                                <!-- Request Item by Production -->
                                                                <div class="mb-4">
                                                                    <h6 class="text-primary mb-3">Request Item by
                                                                        Production</h6>
                                                                    <div class="row g-3">
                                                                        <div class="col-md-4">
                                                                            <label for="leader{{ $setup->id }}"
                                                                                class="form-label">Leader</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="leader{{ $setup->id }}"
                                                                                name="leader"
                                                                                value="{{ old('leader', $setup->user->nama) }}"
                                                                                readonly
                                                                                style="cursor: not-allowed; background-color: #f8f9fa;">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="line{{ $setup->id }}"
                                                                                class="form-label">Line</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="line{{ $setup->id }}"
                                                                                name="line"
                                                                                value="{{ old('line', $setup->line) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label
                                                                                for="schedule_datetime{{ $setup->id }}"
                                                                                class="form-label">Schedule Date &
                                                                                Time</label>
                                                                            <input type="datetime-local"
                                                                                class="form-control border-1 bg-light"
                                                                                id="schedule_datetime{{ $setup->id }}"
                                                                                name="schedule_datetime"
                                                                                value="{{ old('schedule_datetime', $setup->schedule_datetime) }}"
                                                                                readonly
                                                                                style="cursor: not-allowed; background-color: #f8f9fa;">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="part{{ $setup->id }}"
                                                                                class="form-label">Part Number</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="part{{ $setup->id }}"
                                                                                name="part_number"
                                                                                value="{{ old('part_number', $setup->part_number) }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="qty{{ $setup->id }}"
                                                                                class="form-label">Quantity Product</label>
                                                                            <input type="number"
                                                                                class="form-control border-1 bg-light"
                                                                                id="qty{{ $setup->id }}"
                                                                                name="qty_product"
                                                                                value="{{ old('qty_product', $setup->qty_product) }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="customer{{ $setup->id }}"
                                                                                class="form-label">Customer</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="customer{{ $setup->id }}"
                                                                                name="customer"
                                                                                value="{{ old('customer', $setup->customer) }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="mtype{{ $setup->id }}"
                                                                                class="form-label">Mould Type</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="mtype{{ $setup->id }}"
                                                                                name="mould_type"
                                                                                value="{{ old('mould_type', $setup->mould_type) }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="mould_category{{ $setup->id }}"
                                                                                class="form-label">Mould Category</label>
                                                                            <select
                                                                                class="form-select form-control-light @error('mould_category') is-invalid @enderror"
                                                                                id="mould_category{{ $setup->id }}"
                                                                                name="mould_category" required>
                                                                                <option value="">Select Category
                                                                                </option>
                                                                                <option value="Mold Connector"
                                                                                    {{ old('mould_category', $setup->mould_category) == 'Mold Connector' ? 'selected' : '' }}>
                                                                                    Mold Connector</option>
                                                                                <option value="Mold Inner"
                                                                                    {{ old('mould_category', $setup->mould_category) == 'Mold Inner' ? 'selected' : '' }}>
                                                                                    Mold Inner</option>
                                                                                <option value="Mold Plug"
                                                                                    {{ old('mould_category', $setup->mould_category) == 'Mold Plug' ? 'selected' : '' }}>
                                                                                    Mold Plug</option>
                                                                                <option value="Mold Grommet"
                                                                                    {{ old('mould_category', $setup->mould_category) == 'Mold Grommet' ? 'selected' : '' }}>
                                                                                    Mold Grommet</option>
                                                                            </select>
                                                                            @error('mould_category')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label
                                                                                for="molding_machine{{ $setup->id }}"
                                                                                class="form-label">Molding Machine</label>
                                                                            <select
                                                                                class="form-select form-control-light @error('molding_machine') is-invalid @enderror"
                                                                                id="molding_machine{{ $setup->id }}"
                                                                                name="molding_machine" required>
                                                                                <option value="">Select Machine
                                                                                </option>
                                                                                @foreach ($mesins as $mesin)
                                                                                    <option value="{{ $mesin->id }}"
                                                                                        {{ old('molding_machine', $setup->molding_machine) == $mesin->id ? 'selected' : '' }}>
                                                                                        {{ $mesin->molding_mc }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('molding_machine')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="markingType{{ $setup->id }}"
                                                                                class="form-label">Marking Type</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="markingType{{ $setup->id }}"
                                                                                name="marking_type"
                                                                                value="{{ old('marking_type', $setup->marking_type) }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="mcavity{{ $setup->id }}"
                                                                                class="form-label">Mould Cavity</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="mcavity{{ $setup->id }}"
                                                                                name="mould_cavity"
                                                                                value="{{ old('mould_cavity', $setup->mould_cavity) }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="cableGripSize{{ $setup->id }}"
                                                                                class="form-label">Cable Grip Size</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="cableGripSize{{ $setup->id }}"
                                                                                name="cable_grip_size"
                                                                                value="{{ old('cable_grip_size', $setup->cable_grip_size) }}">
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label for="jobRequest{{ $setup->id }}"
                                                                                class="form-label">Job Request</label>
                                                                            <textarea class="form-control border-1 bg-light" id="jobRequest{{ $setup->id }}" name="job_request"
                                                                                style="height: 80px">{{ old('job_request', $setup->job_request) }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- After Setup by tooling/teknisi -->
                                                                <div class="mb-4">
                                                                    <h6 class="text-primary mb-3">After Setup by
                                                                        tooling/teknisi</h6>
                                                                    <div class="row g-3">
                                                                        <div class="col-md-4">
                                                                            <label for="issuedDate{{ $setup->id }}"
                                                                                class="form-label">Issued Date</label>
                                                                            <input type="date"
                                                                                class="form-control border-1 bg-light"
                                                                                id="issuedDate{{ $setup->id }}"
                                                                                name="issued_date"
                                                                                value="{{ old('issued_date', $setup->issued_date ? \Carbon\Carbon::parse($setup->issued_date)->format('Y-m-d') : '') }}"
                                                                                readonly
                                                                                style="cursor: not-allowed; background-color: #f8f9fa;">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="assetBT{{ $setup->id }}"
                                                                                class="form-label">Asset No BT</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="assetBT{{ $setup->id }}"
                                                                                name="asset_no_bt"
                                                                                value="{{ old('asset_no_bt', $setup->asset_no_bt) }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="maintenanceName{{ $setup->id }}"
                                                                                class="form-label">Maintenance Name</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="maintenanceName{{ $setup->id }}"
                                                                                name="maintenance_name"
                                                                                value="{{ old('maintenance_name', $setup->maintenance_name) }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label
                                                                                for="mould_type_mtc{{ $setup->id }}"
                                                                                class="form-label">Mould Type MTC</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="mould_type_mtc{{ $setup->id }}"
                                                                                name="mould_type_mtc"
                                                                                value="{{ old('mould_type_mtc', $setup->mould_type_mtc) }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label
                                                                                for="marking_type_mtc{{ $setup->id }}"
                                                                                class="form-label">Marking Type MTC</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="marking_type_mtc{{ $setup->id }}"
                                                                                name="marking_type_mtc"
                                                                                value="{{ old('marking_type_mtc', $setup->marking_type_mtc) }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label
                                                                                for="cable_grip_size_mtc{{ $setup->id }}"
                                                                                class="form-label">Cable Grip Size
                                                                                MTC</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="cable_grip_size_mtc{{ $setup->id }}"
                                                                                name="cable_grip_size_mtc"
                                                                                value="{{ old('cable_grip_size_mtc', $setup->cable_grip_size_mtc) }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="ampereRating{{ $setup->id }}"
                                                                                class="form-label">Ampere Rating</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="ampereRating{{ $setup->id }}"
                                                                                name="ampere_rating"
                                                                                value="{{ old('ampere_rating', $setup->ampere_rating) }}">
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label for="setupProblem{{ $setup->id }}"
                                                                                class="form-label">Setup Problem</label>
                                                                            <textarea class="form-control border-1 bg-light" id="setupProblem{{ $setup->id }}" name="setup_problem"
                                                                                style="height: 100px">{{ old('setup_problem', $setup->setup_problem) }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- IPQC Checking Item by IPQC -->
                                                                <div class="mb-4">
                                                                    <h6 class="text-primary mb-3">IPQC Checking Item by
                                                                        IPQC</h6>
                                                                    <div class="row g-3">
                                                                        <div class="col-md-4">
                                                                            <label for="marking{{ $setup->id }}"
                                                                                class="form-label">Marking</label>
                                                                            <select class="form-select form-control-light"
                                                                                id="marking{{ $setup->id }}"
                                                                                name="marking">
                                                                                <option value="Pass"
                                                                                    {{ $setup->marking == 'Pass' ? 'selected' : '' }}>
                                                                                    Pass</option>
                                                                                <option value="Failed"
                                                                                    {{ $setup->marking == 'Failed' ? 'selected' : '' }}>
                                                                                    Failed</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="relief{{ $setup->id }}"
                                                                                class="form-label">Relief</label>
                                                                            <select class="form-select form-control-light"
                                                                                id="relief{{ $setup->id }}"
                                                                                name="relief">
                                                                                <option value="Pass"
                                                                                    {{ $setup->relief == 'Pass' ? 'selected' : '' }}>
                                                                                    Pass</option>
                                                                                <option value="Failed"
                                                                                    {{ $setup->relief == 'Failed' ? 'selected' : '' }}>
                                                                                    Failed</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="mismatch{{ $setup->id }}"
                                                                                class="form-label">Mismatch</label>
                                                                            <select class="form-select form-control-light"
                                                                                id="mismatch{{ $setup->id }}"
                                                                                name="mismatch">
                                                                                <option value="Pass"
                                                                                    {{ $setup->mismatch == 'Pass' ? 'selected' : '' }}>
                                                                                    Pass</option>
                                                                                <option value="Failed"
                                                                                    {{ $setup->mismatch == 'Failed' ? 'selected' : '' }}>
                                                                                    Failed</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="pinbar{{ $setup->id }}"
                                                                                class="form-label">Pin Bar
                                                                                Connector</label>
                                                                            <select class="form-select form-control-light"
                                                                                id="pinbar{{ $setup->id }}"
                                                                                name="pin_bar_connector">
                                                                                <option value="Pass"
                                                                                    {{ $setup->pin_bar_connector == 'Pass' ? 'selected' : '' }}>
                                                                                    Pass</option>
                                                                                <option value="Failed"
                                                                                    {{ $setup->pin_bar_connector == 'Failed' ? 'selected' : '' }}>
                                                                                    Failed</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="qcApprove{{ $setup->id }}"
                                                                                class="form-label">QC Approve</label>
                                                                            <input type="text"
                                                                                class="form-control border-1 bg-light"
                                                                                id="qcApprove{{ $setup->id }}"
                                                                                name="qc_approve"
                                                                                value="{{ old('qc_approve', $setup->qc_approve) }}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Timestamps Section -->
                                                                <div class="section">
                                                                    <h6 class="section-title text-primary mb-3">Timestamps
                                                                    </h6>
                                                                    <div class="row g-3">
                                                                        <!-- Submit Time -->
                                                                        <div class="col-md-4">
                                                                            <label
                                                                                class="form-label text-muted small">Submit</label>
                                                                            <div class="d-flex gap-2">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm bg-light"
                                                                                    value="{{ $setup->tanggal_submit_formatted }}"
                                                                                    readonly>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm bg-light"
                                                                                    value="{{ $setup->jam_submit_formatted }}"
                                                                                    readonly>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Start Time -->
                                                                        <div class="col-md-4">
                                                                            <label
                                                                                class="form-label text-muted small">Start</label>
                                                                            <div class="d-flex gap-2">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm bg-light"
                                                                                    value="{{ $setup->tanggal_start_formatted }}"
                                                                                    readonly>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm bg-light"
                                                                                    value="{{ $setup->jam_start_formatted }}"
                                                                                    readonly>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Finish Time -->
                                                                        <div class="col-md-4">
                                                                            <label
                                                                                class="form-label text-muted small">Finish</label>
                                                                            <div class="d-flex gap-2">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm bg-light"
                                                                                    value="{{ $setup->tanggal_finish_formatted }}"
                                                                                    readonly>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm bg-light"
                                                                                    value="{{ $setup->jam_finish_formatted }}"
                                                                                    readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer bg-light">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    Cancel
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    Update
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="20" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="fas fa-search-minus fs-2 mb-3 d-block"></i>
                                                        @if (request('search'))
                                                            <p class="mb-0">Tidak ditemukan data yang sesuai dengan
                                                                pencarian
                                                                "{{ request('search') }}"</p>
                                                            <small class="d-block mt-2">
                                                                @if (request('filter_type') && request('filter_type') != 'all')
                                                                    Filter: {{ ucfirst(request('filter_type')) }}
                                                                @endif
                                                            </small>
                                                            <a href="{{ route('rekapsetup.index', ['show' => request('show')]) }}"
                                                                class="btn btn-sm btn-outline-secondary mt-3">
                                                                <i class="fas fa-redo-alt me-1"></i>Reset Pencarian
                                                            </a>
                                                        @else
                                                            <p class="mb-0">Belum ada data yang tersedia</p>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $setups->links() }}
                        </div>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        var colCount = $('table th').length;
                        $('.no-data-row td').attr('colspan', colCount);
                        $('.modal .btn-secondary').on('click', function() {
                            const modalId = $(this).closest('.modal').attr('id');
                            const form = $(`#${modalId} form`);
                            form.trigger('reset');

                            // Reset select elements ke nilai aslinya
                            form.find('select').each(function() {
                                const defaultValue = $(this).data('original-value');
                                if (defaultValue) {
                                    $(this).val(defaultValue);
                                }
                            });

                            // Pastikan juga custom defect checkbox terupdate
                            form.find('.is_custom_defect').trigger('change');
                        });

                        // Saat modal pertama kali dibuka, simpan nilai aslinya
                        $('.modal').on('show.bs.modal', function() {
                            const form = $(this).find('form');
                            form.find('select').each(function() {
                                $(this).data('original-value', $(this).val());
                            });
                        });
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Event listener untuk perPageSelect
                        const perPageSelect = document.getElementById('perPageSelect');
                        if (perPageSelect) {
                            perPageSelect.addEventListener('change', function() {
                                let currentUrl = new URL(window.location.href);
                                currentUrl.searchParams.set('show', this.value);
                                window.location.href = currentUrl.toString();
                            });
                        }



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
