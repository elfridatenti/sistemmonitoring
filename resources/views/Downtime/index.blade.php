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
                            <h4 class="mb-0 text-white">DOWNTIME MOLDING</h4>
                        </div>
                        <p class="mb-0 text-white-50">Daftar Laporan Downtime Mesin Molding</p>
                    </div>


                   


                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
        
                    @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>{{ session('info') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                    @if (auth()->user()->role === 'leader' || auth()->user()->role === 'admin' || auth()->user()->role === 'teknisi')
                                        <div class="form-group">
                                            <label class="form-label text-muted small fw-medium mb-1">Filter Status</label>
                                            <div class="d-flex gap-2">
                                                <select name="status" class="form-select form-select-sm shadow-sm" style="cursor: pointer;">
                                                    <option value="">Semua</option>

                                                    @if (auth()->user()->role === 'leader')
                                                        <option value="Menunggu"
                                                            {{ request('status') === 'Menunggu' ? 'selected' : '' }}>
                                                            Menunggu</option>
                                                        <option value="Sedang Diproses"
                                                            {{ request('status') === 'Sedang Diproses' ? 'selected' : '' }}>
                                                            Sedang Diproses
                                                        </option>
                                                        <option value="Menunggu QC Approve"
                                                            {{ request('status') === 'Menunggu QC Approve' ? 'selected' : '' }}>
                                                            Menunggu QC
                                                            Approve
                                                        </option>
                                                        <option value="Completed"
                                                            {{ request('status') === 'Completed' ? 'selected' : '' }}>
                                                            Completed</option>
                                                    @elseif (auth()->user()->role === 'admin' || 'teknisi')
                                                        <option value="Menunggu"
                                                            {{ request('status') === 'Menunggu' ? 'selected' : '' }}>
                                                            Menunggu</option>
                                                        <option value="Sedang Diproses"
                                                            {{ request('status') === 'Sedang Diproses' ? 'selected' : '' }}>
                                                            Sedang Diproses
                                                        </option>
                                                        <option value="Menunggu QC Approve"
                                                            {{ request('status') === 'Menunggu QC Approve' ? 'selected' : '' }}>
                                                            Menunggu QC
                                                            Approve
                                                        </option>
                                                    @endif
                                                </select>
                                                <button type="submit" name="filter_status"
                                                    class="btn btn-xs btn-info text-white d-flex align-items-center"
                                                    style="font-size: 0.8rem; height: 30px;" style="cursor: pointer;">
                                                    Filter
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col"></div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium  mb-1">Filter By</label>
                                        <select name="filter_type" class="form-select form-select-sm shadow-sm"
                                            style="cursor: pointer;">
                                            <option value="all" {{ request('filter_type') == 'all' ? 'selected' : '' }}>
                                                Semua
                                            </option>
                                            <option value="badge"
                                                {{ request('filter_type') == 'badge' ? 'selected' : '' }}>Badge
                                            </option>
                                            <option value="line"
                                                {{ request('filter_type') == 'line' ? 'selected' : '' }}>Line
                                            </option>
                                            <option value="leader"
                                                {{ request('filter_type') == 'leader' ? 'selected' : '' }}>Leader
                                            </option>
                                            <option value="defect_category"
                                                {{ request('filter_type') == 'defect_category' ? 'selected' : '' }}>
                                                Kategori Defect
                                            </option>
                                            <option value="molding_mc"
                                                {{ request('filter_type') == 'molding_mc' ? 'selected' : '' }}>Mesin
                                                Molding
                                            </option>
                                        </select>
                                    </div>
                                </div>



                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-2">Search</label>
                                        <div class="input-group input-group-sm shadow-sm">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari data..." value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-primary px-3">
                                                <i class="fas fa-search me-1"></i>
                                            </button>
                                            @if (request('search'))
                                                <a href="{{ route('downtime.index', ['show' => request('show')]) }}"
                                                    class="btn btn-outline-secondary">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
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

                                            @if (auth()->user()->role === 'leader')
                                                <th colspan="2" class="text-center collapsible-header"
                                                    data-group="finish">
                                                    Finish <i class="fas fa-chevron-up collapse-indicator"></i>
                                                </th>
                                            @endif

                                            <th rowspan="2">Status</th>
                                            <th rowspan="2">Aksi</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center submit-date">Date</th>
                                            <th class="text-center submit-time time-column">Time</th>
                                            <th class="text-center start-date">Date</th>
                                            <th class="text-center start-time time-column">Time</th>
                                            @if (auth()->user()->role === 'leader')
                                                <th class="text-center finish-date">Date</th>
                                                <th class="text-center finish-time time-column">Time</th>
                                            @endif
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
                                                <td class="submit-date text-center">{{ $downtime->tanggal_submit_formatted ?? 'N/A' }}
                                                </td>
                                                <td class="submit-time time-column text-center">
                                                    {{ $downtime->jam_submit_formatted ?? 'N/A' }}
                                                </td>
                                                <!-- Start columns -->
                                                <td class="start-date text-center">{{ $downtime->tanggal_start_formatted ?? 'N/A' }}
                                                </td>
                                                <td class="start-time time-column text-center">
                                                    {{ $downtime->jam_start_formatted ?? 'N/A' }}
                                                </td>
                                                <!-- Finish columns -->
                                                @if (auth()->user()->role === 'leader')
                                                    <td class="finish-date text-center">
                                                        {{ $downtime->tanggal_finish_formatted ?? 'N/A' }}
                                                    </td>
                                                    <td class="finish-time time-column text-center">
                                                        {{ $downtime->jam_finish_formatted ?? 'N/A' }}</td>
                                                @endif


                                                <td class="status-cell">
                                                    <div class="text-center">
                                                        @if (auth()->user()->role === 'teknisi')
                                                            @if ($downtime->status === 'Menunggu')
                                                                <button id="startBtn{{ $downtime->id }}"
                                                                    class="btn btn-success btn-start"
                                                                    data-id="{{ $downtime->id }}">
                                                                    Start
                                                                </button>
                                                            @else
                                                                <span
                                                                    class="badge
                                                            @if ($downtime->status === 'Completed') bg-success
                                                            @elseif($downtime->status === 'Sedang Diproses') bg-warning 
                                                            @elseif($downtime->status === 'Menunggu QC Approve') bg-secondary
                                                            @else bg-danger @endif">
                                                                    {{ $downtime->status }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span
                                                                class="badge
                                                        @if ($downtime->status === 'Completed') bg-success
                                                        @elseif($downtime->status === 'Sedang Diproses') bg-warning
                                                        @elseif($downtime->status === 'Menunggu QC Approve') bg-secondary
                                                        @else bg-danger @endif">
                                                                {{ $downtime->status ?? 'Menunggu' }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="gap: 2px;">
                                                        {{-- View button - accessible to all users --}}
                                                        <a href="{{ route('downtime.show', $downtime) }}"
                                                           class="btn btn-sm btn-outline-primary">
                                                           <i class="far fa-eye "></i>
                                                        </a>

                                                        {{-- Edit button - only for leader when status is 'Menunggu' --}}
                                                        @if (auth()->user()->role === 'leader' && $downtime->status === 'Menunggu')
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal{{ $downtime->id }}">
                                                                <i class="far fa-edit "></i>
                                                            </button>
                                                        @endif

                                                        {{-- Delete button - for leader when status is 'Menunggu' OR admin when status is 'Completed' --}}
                                                        @if (auth()->user()->role === 'leader' && $downtime->status === 'Menunggu')
                                                            {{-- // (auth()->user()->role === 'admin' && $downtime->status === 'Completed')) --}}
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $downtime->id }}">
                                                                <i class="far fa-trash-alt "></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal{{ $downtime->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                                        <form method="POST" action="{{ route('downtime.update', $downtime) }}" id="editForm{{ $downtime->id }}">
                                                            @csrf
                                                            @method('PUT')
                                            
                                                            <!-- Modal Header -->
                                                            <div class="modal-header bg-gradient-primary border-bottom-0 rounded-top-4">
                                                                <div class="d-flex align-items-center">
                                                                    <span class="modal-icon bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                                                        <i class="fas fa-clock text-light fs-4"></i>
                                                                    </span>
                                                                    <h5 class="modal-title  mb-0">EDIT DOWNTIME</h5>
                                                                </div>
                                                                <a href="{{ route('downtime.index') }}" class="btn btn-outline-light hover-scale">
                                                                    <i class="bi bi-arrow-left me-1"></i> Back
                                                                </a>
                                                            </div>
                                            
                                                            <!-- Modal Body -->
                                                            <div class="modal-body p-4">
                                                                <!-- Basic Information Section -->
                                                                <div class="mb-4">
                                                                    <h6 class="text-primary mb-3">Request Item by Production</h6>
                                                                    <div class="row g-3">
                                                                        <div class="col-md-4">
                                                                            <label for="leader{{ $downtime->id }}" class="form-label">Leader</label>
                                                                            <input type="text" class="form-control bg-light @error('leader') is-invalid @enderror"
                                                                                id="leader{{ $downtime->id }}" name="leader"
                                                                                value="{{ old('leader', $downtime->user->nama) }}" readonly style="cursor: not-allowed;"
                                                                                required>
                                                                            @error('leader')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="line{{ $downtime->id }}" class="form-label">Line</label>
                                                                            <input type="text" class="form-control bg-light @error('line') is-invalid @enderror"
                                                                                id="line{{ $downtime->id }}" name="line"
                                                                                value="{{ old('line', $downtime->line) }}" required>
                                                                            @error('line')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="badge{{ $downtime->id }}" class="form-label">Badge</label>
                                                                            <input type="text" class="form-control bg-light @error('badge') is-invalid @enderror"
                                                                                id="badge{{ $downtime->id }}" name="badge"
                                                                                value="{{ old('badge', $downtime->badge) }}" required>
                                                                            @error('badge')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                            
                                                                        <div class="col-md-4">
                                                                            <label for="raised_operator{{ $downtime->id }}" class="form-label">Raised Operator</label>
                                                                            <input type="text" class="form-control bg-light @error('raised_operator') is-invalid @enderror"
                                                                                id="raised_operator{{ $downtime->id }}" name="raised_operator"
                                                                                value="{{ old('raised_operator', $downtime->raised_operator) }}">
                                                                            @error('raised_operator')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="raised_ipqc{{ $downtime->id }}" class="form-label">Raised IPQC</label>
                                                                            <input type="text" class="form-control bg-light @error('raised_ipqc') is-invalid @enderror"
                                                                                id="raised_ipqc{{ $downtime->id }}" name="raised_ipqc"
                                                                                value="{{ old('raised_ipqc', $downtime->raised_ipqc) }}">
                                                                            @error('raised_ipqc')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                            
                                                                        <div class="col-md-4">
                                                                            <label for="molding_machine{{ $downtime->id }}" class="form-label">Molding Machine</label>
                                                                            <select class="form-select bg-light @error('molding_machine') is-invalid @enderror"
                                                                                id="molding_machine{{ $downtime->id }}" name="molding_machine" required>
                                                                                <option value="">Select Machine</option>
                                                                                @foreach ($mesins as $mesin)
                                                                                    <option value="{{ $mesin->id }}"
                                                                                        {{ old('molding_machine', $downtime->molding_machine) == $mesin->id ? 'selected' : '' }}>
                                                                                        {{ $mesin->molding_mc }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('molding_machine')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                            
                                                                        <!-- Machine & Defect Section -->
                                                                        <div class="col-12 mt-4">
                                                                            <div class="form-check mb-2">
                                                                                <input type="checkbox" class="form-check-input is_custom_defect"
                                                                                    id="is_custom_defect_{{ $downtime->id }}" name="is_custom_defect" value="1"
                                                                                    {{ !is_numeric($downtime->defect_category) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="is_custom_defect_{{ $downtime->id }}">
                                                                                    Use Custom Defect Category
                                                                                </label>
                                                                            </div>
                                            
                                                                            <div class="row g-2">
                                                                                <div class="col-md-4">
                                                                                    <!-- Standard Defect Select -->
                                                                                    <div id="standard_defect_div">
                                                                                        <label for="defect_category{{ $downtime->id }}" class="form-label">Defect Category</label>
                                                                                        <select class="form-select bg-light" id="defect_category{{ $downtime->id }}" name="defect_category">
                                                                                            @foreach ($defects as $defect)
                                                                                                <option value="{{ $defect->id }}"
                                                                                                    {{ is_numeric($downtime->defect_category) && $downtime->defect_category == $defect->id ? 'selected' : '' }}>
                                                                                                    {{ $defect->defect_category }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                            
                                                                                    <!-- Custom Defect Input -->
                                                                                    <div id="custom_defect_div" style="display: none;">
                                                                                        <label for="custom_defect_category{{ $downtime->id }}" class="form-label">Custom Defect Category</label>
                                                                                        <input type="text" class="form-control bg-light" id="custom_defect_category{{ $downtime->id }}" 
                                                                                            name="custom_defect_category"
                                                                                            value="{{ !is_numeric($downtime->defect_category) ? $downtime->defect_category : '' }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                            
                                                                        <!-- Problem Description -->
                                                                        <div class="col-12 mt-4">
                                                                            <h6 class="text-primary mb-3">Problem Details</h6>
                                                                            <label for="problem_defect{{ $downtime->id }}" class="form-label">Problem Description</label>
                                                                            <textarea class="form-control bg-light @error('problem_defect') is-invalid @enderror" 
                                                                                id="problem_defect{{ $downtime->id }}" name="problem_defect" 
                                                                                style="height: 100px">{{ old('problem_defect', $downtime->problem_defect) }}</textarea>
                                                                            @error('problem_defect')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer bg-light">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
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
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $downtime->id }}">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Penghapusan
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah yakin untuk menghapus downtime ini?</p>
                                                            <p class="text-muted">
                                                                Badge: {{ $downtime->badge }}<br>
                                                                Line: {{ $downtime->line }}<br>
                                                                Molding M/C: {{ $downtime->mesin->molding_mc }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i>Batal
                                                            </button>
                                                            <form action="{{ route('downtime.destroy', $downtime) }}" method="POST">
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
                                                            <a href="{{ route('downtime.index', ['show' => request('show')]) }}"
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

            // Ubah format tanggal menjadi DD-MM-YYYY
            const day = String(currentDate.getDate()).padStart(2, '0');
            const month = String(currentDate.getMonth() + 1).padStart(2, '0');
            const year = currentDate.getFullYear();
            const formattedDate = `${day}-${month}-${year}`;

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
                                Sedang Diproses
                            </span>
                        </div>
                    `);
            dateCell.text(formattedDate);
            timeCell.text(formattedTime);

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
                        // Optional: Update UI with server response if needed
                        if (response.status !== 'Sedang Diproses') {
                            statusCell.html(`
                                        <div class="text-center">
                                            <span class="badge bg-warning">
                                                ${response.status}
                                            </span>
                                        </div>
                                    `);
                        }
                        if (response.date !== formattedDate) {
                            dateCell.text(response.date);
                        }
                        if (response.time !== formattedTime) {
                            timeCell.text(response.time);
                        }
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
