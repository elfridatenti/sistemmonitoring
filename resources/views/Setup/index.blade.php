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

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card form-card">
                    <div class="card-header bg-gradient-primary">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="mb-0 text-white">REQUEST SETUP PRODUCTION</h4>
                        </div>
                        <p class="mb-0 text-white-50">Daftar Request Setup Mesin Molding</p>
                    </div>


                    <div class="card-body">
                         <!-- Alert dengan animasi fade -->
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
                                                            Sedang Diproses</option>
                                                        <option value="Menunggu QC Approve"
                                                            {{ request('status') === 'Menunggu QC Approve' ? 'selected' : '' }}>
                                                            Menunggu QC Approve</option>
                                                        <option value="Completed"
                                                            {{ request('status') === 'Completed' ? 'selected' : '' }}>
                                                            Completed</option>
                                                    @elseif (auth()->user()->role === 'admin' || 'teknisi')
                                                        <option value="Menunggu"
                                                            {{ request('status') === 'Menunggu' ? 'selected' : '' }}>
                                                            Menunggu</option>
                                                        <option value="Sedang Diproses"
                                                            {{ request('status') === 'Sedang Diproses' ? 'selected' : '' }}>
                                                            Sedang Diproses</option>
                                                        <option value="Menunggu QC Approve"
                                                            {{ request('status') === 'Menunggu QC Approve' ? 'selected' : '' }}>
                                                            Menunggu QC Approve</option>
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

                                <!-- Filter Type -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-1">Filter By</label>
                                        <select name="filter_type" class="form-select form-select-sm shadow-sm" style="cursor: pointer;">
                                            <option value="all"
                                                {{ request('filter_type') === 'all' ? 'selected' : '' }}>Semua Data
                                            </option>
                                            <option value="leader"
                                                {{ request('filter_type') === 'leader' ? 'selected' : '' }}>Leader</option>
                                            <option value="line"
                                                {{ request('filter_type') === 'line' ? 'selected' : '' }}>Line</option>
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

                                <!-- Search Bar -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-1">Search</label>
                                        <div class="input-group input-group-sm shadow-sm">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari data..." value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-primary px-3">
                                                <i class="fas fa-search me-1"></i>
                                            </button>
                                            @if (request('search'))
                                                <a href="{{ route('setup.index', ['show' => request('show')]) }}"
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
                                            <th rowspan="2" class="schedule-column">Schedule </br> Date/Time</th>
                                            <th rowspan="2">Part Number</th>
                                            <th rowspan="2">Customer</th>
                                            <th rowspan="2">Mould Type</th>
                                            <th rowspan="2">Mould Category</th>
                                            <th rowspan="2">Molding </br> M/C</th>

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
                                                <td>{{ $setup->part_number }}</td>
                                                <td>{{ $setup->customer }}</td>
                                                <td>{{ $setup->mould_type }}</td>
                                                <td>{{ $setup->mould_category }}</td>
                                                <td class="text-center">{{ $setup->mesin->molding_mc }}</td>

                                                <td class="submit-date text-center">{{ $setup->tanggal_submit_formatted ?? 'N/A' }}
                                                </td>
                                                <td class="submit-time time-column text-center">
                                                    {{ $setup->jam_submit_formatted ?? 'N/A' }}
                                                </td>
                                                <!-- Start columns -->
                                                <td class="start-date  text-center">{{ $setup->tanggal_start_formatted ?? 'N/A' }}</td>
                                                <td class="start-time time-column text-center">
                                                    {{ $setup->jam_start_formatted ?? 'N/A' }}</td>
                                                <!-- Finish columns -->
                                                @if (auth()->user()->role === 'leader')
                                                    <td class="finish-date text-center">
                                                        {{ $setup->tanggal_finish_formatted ?? 'N/A' }}</td>
                                                    <td class="finish-time time-column text-center">
                                                        {{ $setup->jam_finish_formatted ?? 'N/A' }}</td>
                                                @endif


                                                <td class="status-cell">
                                                    <div class="text-center">
                                                        @if (auth()->user()->role === 'teknisi')
                                                            @if ($setup->status === 'Menunggu')
                                                                <button id="startBtn{{ $setup->id }}"
                                                                    class="btn btn-success btn-start"
                                                                    data-id="{{ $setup->id }}">
                                                                    Start
                                                                </button>
                                                            @else
                                                                <span
                                                                    class="badge
                                                            @if ($setup->status === 'Completed') bg-success
                                                            @elseif($setup->status === 'Sedang Diproses') bg-warning
                                                            @elseif($setup->status === 'Menunggu QC Approve') bg-secondary  
                                                            @else bg-danger @endif">
                                                                    {{ $setup->status }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span
                                                                class="badge
                                                        @if ($setup->status === 'Completed') bg-success
                                                        @elseif($setup->status === 'Sedang Diproses') bg-warning
                                                        @elseif($setup->status === 'Menunggu QC Approve') bg-secondary
                                                        @else bg-danger @endif">
                                                                {{ $setup->status ?? 'Menunggu' }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="gap: 2px;">
                                                        {{-- View button - accessible to all users --}}
                                                        <a href="{{ route('setup.show', ['setup' => $setup]) }}"
                                                            class="btn btn-sm btn-outline-primary"
                                                            onclick="console.log('Setup ID:', {{ $setup->id }})">
                                                            <i class="far fa-eye "></i>
                                                        </a>

                                                        {{-- Edit button - only for leader when status is 'menunggu' --}}
                                                        @if (auth()->user()->role == 'leader' && $setup->status == 'Menunggu')
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal{{ $setup->id }}">
                                                                <i class="far fa-edit "></i>
                                                            </button>
                                                        @endif

                                                        {{-- Delete button - for leader when status is 'menunggu' OR admin when status is 'completed' --}}
                                                        @if (
                                                            (auth()->user()->role == 'leader' && $setup->status == 'Menunggu') ||
                                                                (auth()->user()->role == 'admin' && $setup->status == 'completed'))
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $setup->id }}">
                                                                <i class="far fa-trash-alt "></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteModal{{ $setup->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $setup->id }}">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Penghapusan
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah yakin untuk menghapus permintaan setup ini?</p>
                                                            <p class="text-muted">
                                                                Line: {{ $setup->line }}<br>
                                                                Part Number: {{ $setup->part_number }}<br>
                                                                Schedule:
                                                                {{ \Carbon\Carbon::parse($setup->schedule_datetime)->format('Y-m-d H:i') }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i>Batal
                                                            </button>
                                                            <form action="{{ route('setup.destroy', $setup) }}" method="POST">
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
                                            <!--edit mddal-->
                                            <div class="modal fade" id="editModal{{ $setup->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                                        <form method="POST" action="{{ route('setup.update', $setup) }}" id="editForm{{ $setup->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="setup_id" value="{{ $setup->id }}">
                                            
                                                            <!-- Modal Header -->
                                                            <div class="modal-header bg-gradient-primary border-bottom-0 rounded-top-4">
                                                                <div class="d-flex align-items-center">
                                                                    <span class="modal-icon bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                                                        <i class="fas fa-cog text-light fs-4"></i>
                                                                    </span>
                                                                    <h5 class="modal-title  mb-0">EDIT PERMINTAAN SETUP </h5>
                                                                </div>
                                                                <a href="{{ route('setup.index') }}" class="btn btn-outline-light hover-scale">
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
                                                                            <label for="leader{{ $setup->id }}" class="form-label">Leader</label>
                                                                            <input type="text" class="form-control bg-light @error('leader') is-invalid @enderror" 
                                                                                id="leader{{ $setup->id }}" name="leader"
                                                                                value="{{ old('leader', $setup->user->nama) }}" readonly 
                                                                                style="cursor: not-allowed;" required>
                                                                            @error('leader')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="line{{ $setup->id }}" class="form-label">Line</label>
                                                                            <input type="text" class="form-control bg-light @error('line') is-invalid @enderror" 
                                                                                id="line{{ $setup->id }}" name="line"
                                                                                value="{{ old('line', $setup->line) }}" required>
                                                                            @error('line')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="schedule_datetime{{ $setup->id }}" class="form-label">Schedule Date & Time</label>
                                                                            <input type="datetime-local" class="form-control bg-light @error('schedule_datetime') is-invalid @enderror" 
                                                                                id="schedule_datetime{{ $setup->id }}" name="schedule_datetime"
                                                                                value="{{ old('schedule_datetime', $setup->schedule_datetime) }}" required>
                                                                            @error('schedule_datetime')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                            <!-- Hidden input untuk issued_date -->
                                                                            <input type="hidden" id="issued_date{{ $setup->id }}" name="issued_date"
                                                                                value="{{ old('issued_date', $setup->issued_date) }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                            
                                                                <!-- Product Details Section -->
                                                                <div class="mb-4">
                                                                    <div class="row g-3">
                                                                        <div class="col-md-4">
                                                                            <label for="part_number{{ $setup->id }}" class="form-label">Part Number</label>
                                                                            <input type="text" class="form-control bg-light @error('part_number') is-invalid @enderror" 
                                                                                id="part_number{{ $setup->id }}" name="part_number"
                                                                                value="{{ old('part_number', $setup->part_number) }}" required>
                                                                            @error('part_number')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        
                                                                        <div class="col-md-4">
                                                                            <label for="customer{{ $setup->id }}" class="form-label">Customer</label>
                                                                            <input type="text" class="form-control bg-light @error('customer') is-invalid @enderror" 
                                                                                id="customer{{ $setup->id }}" name="customer"
                                                                                value="{{ old('customer', $setup->customer) }}" required>
                                                                            @error('customer')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label for="qty_product{{ $setup->id }}" class="form-label">Quantity</label>
                                                                            <input type="number" class="form-control bg-light @error('qty_product') is-invalid @enderror" 
                                                                                id="qty_product{{ $setup->id }}" name="qty_product"
                                                                                value="{{ old('qty_product', $setup->qty_product) }}" required>
                                                                            @error('qty_product')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                            
                                                                <!-- Mould Information Section -->
                                                                <div class="mb-4">
                                                                    <div class="row g-3">
                                                                        <div class="col-md-4">
                                                                            <label for="mould_type{{ $setup->id }}" class="form-label">Mould Type</label>
                                                                            <input type="text" class="form-control bg-light @error('mould_type') is-invalid @enderror" 
                                                                                id="mould_type{{ $setup->id }}" name="mould_type"
                                                                                value="{{ old('mould_type', $setup->mould_type) }}" required>
                                                                            @error('mould_type')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="mould_cavity{{ $setup->id }}" class="form-label">Mould Cavity</label>
                                                                            <input type="text" class="form-control bg-light @error('mould_cavity') is-invalid @enderror" 
                                                                                id="mould_cavity{{ $setup->id }}" name="mould_cavity"
                                                                                value="{{ old('mould_cavity', $setup->mould_cavity) }}" required>
                                                                            @error('mould_cavity')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="mould_category{{ $setup->id }}" class="form-label">Mould Category</label>
                                                                            <select class="form-select bg-light @error('mould_category') is-invalid @enderror" 
                                                                                id="mould_category{{ $setup->id }}" name="mould_category" required>
                                                                                <option value="">Select Category</option>
                                                                                <option value="Mold Connector" {{ old('mould_category', $setup->mould_category) == 'Mold Connector' ? 'selected' : '' }}>
                                                                                    Mold Connector</option>
                                                                                <option value="Mold Inner" {{ old('mould_category', $setup->mould_category) == 'Mold Inner' ? 'selected' : '' }}>
                                                                                    Mold Inner</option>
                                                                                <option value="Mold Plug" {{ old('mould_category', $setup->mould_category) == 'Mold Plug' ? 'selected' : '' }}>
                                                                                    Mold Plug</option>
                                                                                <option value="Mold Grommet" {{ old('mould_category', $setup->mould_category) == 'Mold Grommet' ? 'selected' : '' }}>
                                                                                    Mold Grommet</option>
                                                                            </select>
                                                                            @error('mould_category')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                       
                                                                        <div class="col-md-4">
                                                                            <label for="marking_type{{ $setup->id }}" class="form-label">Marking Type</label>
                                                                            <input type="text" class="form-control bg-light @error('marking_type') is-invalid @enderror" 
                                                                                id="marking_type{{ $setup->id }}" name="marking_type"
                                                                                value="{{ old('marking_type', $setup->marking_type) }}" required>
                                                                            @error('marking_type')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="cable_grip_size{{ $setup->id }}" class="form-label">Cable Grip Size</label>
                                                                            <input type="text" class="form-control bg-light @error('cable_grip_size') is-invalid @enderror" 
                                                                                id="cable_grip_size{{ $setup->id }}" name="cable_grip_size"
                                                                                value="{{ old('cable_grip_size', $setup->cable_grip_size) }}" required>
                                                                            @error('cable_grip_size')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label for="molding_machine{{ $setup->id }}" class="form-label">Molding Machine</label>
                                                                            <select class="form-select bg-light @error('molding_machine') is-invalid @enderror" 
                                                                                id="molding_machine{{ $setup->id }}" name="molding_machine" required>
                                                                                <option value="">Select Machine</option>
                                                                                @foreach ($mesins as $mesin)
                                                                                    <option value="{{ $mesin->id }}" 
                                                                                        {{ old('molding_machine', $setup->molding_machine) == $mesin->id ? 'selected' : '' }}>
                                                                                        {{ $mesin->molding_mc }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('molding_machine')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                            
                                                                <!-- Job Request Section -->
                                                                <div class="mb-4">
                                                                    <h6 class="text-primary mb-3">Job Request Details</h6>
                                                                    <label for="job_request{{ $setup->id }}" class="form-label">Job Request Details</label>
                                                                    <textarea class="form-control bg-light @error('job_request') is-invalid @enderror" 
                                                                        id="job_request{{ $setup->id }}" name="job_request" 
                                                                        style="height: 100px" required>{{ old('job_request', $setup->job_request) }}</textarea>
                                                                    @error('job_request')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                            
                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer bg-light">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
                                                            <a href="{{ route('setup.index', ['show' => request('show')]) }}"
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
                        Sedang Diproses
                    </span>
                </div>
            `);

                            startDateCell.text(formattedDate);
                            startTimeCell.text(formattedTime);

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
            @endsection
