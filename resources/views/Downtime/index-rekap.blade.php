    @extends('layout.header-sidebar')
    @section('content')
        <style>
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
                            <h4 class="mb-0 text-white">REKAPITULASI DOWNTIME MOLDING</h4>
                        </div>
                        <p class="mb-0 text-white-50">Rekapitulasi Laporan Downtime Mesin Molding</p>
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
                    <form action="{{ route('rekapdowntime.search') }}" method="GET">
                        <div class="row align-items-end">
                          
                            <div class="col-auto">
                                <div class="form-group">
                                    <label class="form-label text-muted small fw-medium mb-2">
                                        Show Entries
                                    </label>
                                    <select class="form-select form-select-sm shadow-sm w-auto me-2" name="show"
                                        id="perPageSelect" style="cursor: pointer;">
                                        <option value="10" {{ request('show') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('show') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ request('show') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('show') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col"></div>

                            <div class="col-md-3">
                                    <div class="form-group">
                                    <label class="form-label text-muted small fw-medium mb-2">
                                        Filter By
                                    </label>
                                    <select name="filter_type" class="form-select form-select-sm shadow-sm" style="cursor: pointer;">
                                        <option value="all" {{ request('filter_type') == 'all' ? 'selected' : '' }}>Semua
                                            Data</option>
                                        <option value="badge" {{ request('filter_type') == 'badge' ? 'selected' : '' }}>
                                            Badge</option>
                                        <option value="line" {{ request('filter_type') == 'line' ? 'selected' : '' }}>
                                            Line</option>
                                        <option value="leader" {{ request('filter_type') == 'leader' ? 'selected' : '' }}>
                                            Leader</option>
                                        <option value="maintenance_repair"
                                            {{ request('filter_type') == 'maintenance_repair' ? 'selected' : '' }}>
                                            Maintenance Repair</option>
                                        <option value="qc_approve"
                                            {{ request('filter_type') == 'qc_approve' ? 'selected' : '' }}>
                                            QC Verify</option>
                                        <option value="molding_mc"
                                            {{ request('filter_type') == 'molding_mc' ? 'selected' : '' }}>Molding M/C
                                        </option>
                                    </select>
                                </div>
                                </div>

                                <!-- Search below filter -->
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label text-muted small fw-medium mb-2">
                                        Search
                                    </label>
                                    <div class="d-flex align-items-center">
                                    <div class="input-group input-group-sm shadow-sm">
                                        <input type="text" name="search" class="form-control" placeholder="Cari data..."
                                            value="{{ request('search') }}">
                                       
                                        @if (request('search'))
                                            <a href="{{ route('rekapdowntime.search', ['show' => request('show')]) }}"
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
                            <table class="table table-striped table-hover ">

                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">No</th>
                                        <th rowspan="2" class="text-center">Leader</th>
                                        <th rowspan="2" class="text-center">Line</th>
                                        <th rowspan="2" class="text-center">Badge</th>
                                        <th rowspan="2" class="text-center">Maintenance </br> Repair</th>
                                        <th rowspan="2" class="text-center">QC Verify</th>
                                        <th rowspan="2" class="text-center">Molding </br> M/C</th>
                                        <th colspan="2" class="text-center collapsible-header" data-group="submit">
                                            Submit <i class="fas fa-chevron-up collapse-indicator"></i>
                                        </th>
                                        <th colspan="2" class="text-center collapsible-header" data-group="start">
                                            Start <i class="fas fa-chevron-up collapse-indicator"></i>
                                        </th>
                                        <th colspan="2" class="text-center collapsible-header" data-group="finish">
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
                                    @forelse ($downtimes as $downtime)
                                        <tr class="align-middle">
                                            <td class="number-cell">{{ $loop->iteration }}</td>
                                            <td>{{ $downtime->user->nama ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $downtime->line }}</td>
                                            <td class="text-center">{{ $downtime->badge }}</td>
                                            <td>{{ $downtime->maintenance_repair }}</td>
                                            <td class="{{ ($downtime->qc_approve ?? 'N/A') == 'N/A' ? 'text-center' : '' }}">{{ $downtime->qc_approve ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $downtime->mesin->molding_mc }}</td>
                                            <!-- Submit columns -->
                                            <td class="submit-date text-center">{{ $downtime->tanggal_submit_formatted ?? 'N/A' }}
                                            </td>
                                            <td class="submit-time time-column text-center">
                                                {{ $downtime->jam_submit_formatted ?? 'N/A' }}</td>
                                            <!-- Start columns -->
                                            <td class="start-date text-center">{{ $downtime->tanggal_start_formatted ?? 'N/A' }}</td>
                                            <td class="start-time time-column text-center">
                                                {{ $downtime->jam_start_formatted ?? 'N/A' }}</td>
                                            <!-- Finish columns -->
                                            <td class="finish-date text-center">{{ $downtime->tanggal_finish_formatted ?? 'N/A' }}
                                            </td>
                                            <td class="finish-time time-column text-center">
                                                {{ $downtime->jam_finish_formatted ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                @if ($downtime->status == 'Completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary">{{ $downtime->status ?? 'N/A' }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                <div style="gap: 2px;">
                                                    {{-- Show button - accessible by all users --}}
                                                    <a href="{{ route('rekapdowntime.show', $downtime) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="far fa-eye "></i>
                                                    </a>

                                                    {{-- Edit & Delete buttons - only for admin --}}
                                                    @if (auth()->user()->role === 'admin')
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $downtime->id }}">
                                                            <i class="far fa-edit "></i>
                                                        </button>

                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $downtime->id }}">
                                                            <i class="far fa-trash-alt "></i>
                                                        </button>
                                                    @endif

                                                    {{-- Approve button - only for IPQC when status is waiting for approval --}}
                                                    @if (auth()->user()->role === 'ipqc' && $downtime->status === '
Waiting QC Approve')
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#approveModal{{ $downtime->id }}">
                                                            <i class="far fa-check-circle "></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="deleteModal{{ $downtime->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $downtime->id }}">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>Delete Confirmation
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this downtime recap?</p>
                                                        <p class="text-muted">
                                                            Line: {{ $downtime->line }}<br>
                                                            Molding M/C: {{ $downtime->mesin->molding_mc }}<br>
                                                            Maintenance Repair: {{ $downtime->maintenance_repair }}
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="fas fa-times me-1"></i>Cancel
                                                        </button>
                                                        <form action="{{ route('rekapdowntime.destroy', $downtime) }}" method="POST">
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
                                                                    id="qc_approve{{ $downtime->id }}" name="qc_approve"
                                                                    required placeholder="Contoh: tengku/1233">
                                                                <small class="text-muted">
                                                                    Format: nama/badge
                                                                </small>
                                                                @error('qc_approve')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                                                    Format: nama/badge
                                                                </small>
                                                                @error('production_verify')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                        <!-- Edit Downtime Modal -->
                                        <div class="modal fade" id="editModal{{ $downtime->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <form method="POST" action="{{ route('rekapdowntime.update', $downtime) }}" id="editForm{{ $downtime->id }}">
                                                        @csrf
                                                        @method('PUT')
                                        
                                                        <!-- Modal Header -->
                                                        <div class="modal-header bg-gradient-primary border-bottom-0 rounded-top-4">
                                                            <div class="d-flex align-items-center">
                                                                <span class="modal-icon bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                                                    <i class="fas fa-clock text-light fs-4"></i>
                                                                </span>
                                                                <h5 class="modal-title  mb-0">EDIT REKAPITULASI DOWNTIME </h5>
                                                            </div>
                                                            <a href="{{ route('rekapdowntime.index') }}" class="btn btn-outline-light hover-scale">
                                                                <i class="bi bi-arrow-left me-1"></i> Back
                                                            </a>
                                                        </div>
                                        
                                                        <!-- Modal Body -->
                                                        <div class="modal-body p-4">
                                                            <!-- Basic Information Section -->
                                                            <div class="section mb-4">
                                                                <h6 class="section-title text-primary mb-3">Request Item by Production</h6>
                                                                <div class="row g-3">
                                                                    <!-- Leader Input -->
                                                                    <div class="col-md-4">
                                                                        <label for="leader{{ $downtime->id }}" class="form-label  mb-2">Leader</label>
                                                                        <input type="text"
                                                                            class="form-control border-1 bg-light @error('leader') is-invalid @enderror"
                                                                            id="leader{{ $downtime->id }}"
                                                                            name="leader"
                                                                            value="{{ old('leader', $downtime->user->nama) }}"
                                                                            readonly style="cursor: not-allowed;"
                                                                            required>
                                                                        @error('leader')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                        
                                                                    <!-- Line Input -->
                                                                    <div class="col-md-4">
                                                                        <label for="line{{ $downtime->id }}" class="form-label  mb-2">Line</label>
                                                                        <input type="text"
                                                                            class="form-control border-1 bg-light @error('line') is-invalid @enderror"
                                                                            id="line{{ $downtime->id }}"
                                                                            name="line"
                                                                            value="{{ old('line', $downtime->line) }}"
                                                                            required>
                                                                        @error('line')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                        
                                                                    <!-- Badge Input -->
                                                                    <div class="col-md-4">
                                                                        <label for="badge{{ $downtime->id }}" class="form-label  mb-2">Badge</label>
                                                                        <input type="text"
                                                                            class="form-control border-1 bg-light @error('badge') is-invalid @enderror"
                                                                            id="badge{{ $downtime->id }}"
                                                                            name="badge"
                                                                            value="{{ old('badge', $downtime->badge) }}"
                                                                            required>
                                                                        @error('badge')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                        
                                                            <!-- Personnel Information Section -->
                                                            <div class="section mb-4">
                                                                <div class="row g-3">
                                                                    <!-- Raised Operator -->
                                                                    <div class="col-md-4">
                                                                        <label for="raised_operator{{ $downtime->id }}" class="form-label  mb-2">Raised Operator</label>
                                                                        <input type="text"
                                                                            class="form-control border-1 bg-light @error('raised_operator') is-invalid @enderror"
                                                                            id="raised_operator{{ $downtime->id }}"
                                                                            name="raised_operator"
                                                                            value="{{ old('raised_operator', $downtime->raised_operator) }}">
                                                                        @error('raised_operator')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                        
                                                                    <!-- Raised IPQC -->
                                                                    <div class="col-md-4">
                                                                        <label for="raised_ipqc{{ $downtime->id }}" class="form-label  mb-2">Raised IPQC</label>
                                                                        <input type="text"
                                                                            class="form-control border-1 bg-light @error('raised_ipqc') is-invalid @enderror"
                                                                            id="raised_ipqc{{ $downtime->id }}"
                                                                            name="raised_ipqc"
                                                                            value="{{ old('raised_ipqc', $downtime->raised_ipqc) }}">
                                                                        @error('raised_ipqc')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                
                                                                    <!-- Molding Machine -->
                                                                    <div class="col-md-4">
                                                                        <label for="molding_machine{{ $downtime->id }}" class="form-label  mb-2">Molding Machine</label>
                                                                        <select
                                                                            class="form-select border-1 bg-light @error('molding_machine') is-invalid @enderror"
                                                                            id="molding_machine{{ $downtime->id }}"
                                                                            name="molding_machine" required>
                                                                            <option value="">Select Machine</option>
                                                                            @foreach ($mesins as $mesin)
                                                                                <option value="{{ $mesin->id }}"
                                                                                    {{ old('molding_machine', $downtime->molding_machine) == $mesin->id ? 'selected' : '' }}>
                                                                                    {{ $mesin->molding_mc }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('molding_machine')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                        
                                                            <!-- Machine & Defect Details Section -->
                                                            <div class="section mb-4">
                                                                <!-- Custom Defect Checkbox -->
                                                                <div class="form-check mb-2">
                                                                    <input type="checkbox"
                                                                        class="form-check-input is_custom_defect"
                                                                        id="is_custom_defect_{{ $downtime->id }}"
                                                                        name="is_custom_defect" value="1"
                                                                        {{ !is_numeric($downtime->defect_category) ? 'checked' : '' }}>
                                                                    <label class="form-check-label "
                                                                        for="is_custom_defect_{{ $downtime->id }}">
                                                                        Use Custom Defect Category
                                                                    </label>
                                                                </div>
                                        
                                                                <div class="row g-3">
                                                                    <div class="col-md-4">
                                                                        <!-- Standard Defect Select -->
                                                                        <label for="defect_category" class="form-label  mb-2">Defect Category</label>
                                                                        <div id="standard_defect_div">
                                                                            <select class="form-select border-1 bg-light"
                                                                                name="defect_category">
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
                                                                            <input type="text" class="form-control border-1 bg-light"
                                                                                name="custom_defect_category"
                                                                                value="{{ !is_numeric($downtime->defect_category) ? $downtime->defect_category : '' }}">
                                                                        </div>
                                                                    </div>
                                        
                                                                    <!-- Problem Description -->
                                                                    <div class="col-12">
                                                                        <label for="problem_defect{{ $downtime->id }}" class="form-label  mb-2">Problem Description</label>
                                                                        <textarea class="form-control border-1 bg-light" id="problem_defect{{ $downtime->id }}" name="problem_defect" style="height: 100px">{{ old('problem_defect', $downtime->problem_defect) }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                        
                                                            <!-- Maintenance & Action Section -->
                                                            <div class="section mb-4">
                                                                <h6 class="section-title text-primary mb-3">After Setup by tooling/teknisi</h6>
                                                                <div class="row g-3">
                                                                    <!-- Maintenance/Repair Details -->
                                                                    <div class="col-12">
                                                                        <label for="maintenance_repair{{ $downtime->id }}" class="form-label mb-2">Maintenance/Repair Details</label>
                                                                        <input type="text" class="form-control border-1 bg-light" id="maintenance_repair{{ $downtime->id }}" name="maintenance_repair" value="{{ old('maintenance_repair', $downtime->maintenance_repair) }}">
                                                                    </div>
                                                                    
                                        
                                                                    <!-- Root Cause -->
                                                                    <div class="col-md-6">
                                                                        <label for="root_cause{{ $downtime->id }}" class="form-label  mb-2">Root Cause</label>
                                                                        <textarea class="form-control border-1 bg-light" id="root_cause{{ $downtime->id }}" name="root_cause" style="height: 100px">{{ old('root_cause', $downtime->root_cause) }}</textarea>
                                                                    </div>
                                        
                                                                    <!-- Action Taken -->
                                                                    <div class="col-md-6">
                                                                        <label for="action_taken{{ $downtime->id }}" class="form-label  mb-2">Action Taken</label>
                                                                        <textarea class="form-control border-1 bg-light" id="action_taken{{ $downtime->id }}" name="action_taken" style="height: 100px">{{ old('action_taken', $downtime->action_taken) }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                        
                                                            <!-- Verification Section -->
                                                            <div class="section mb-4">
                                                                <h6 class="section-title text-primary mb-3">IPQC Checking Item by IPQC</h6>
                                                                <div class="row g-3">
                                                                    <!-- Production Verify -->
                                                                    <div class="col-md-6">
                                                                        <label for="production_verify{{ $downtime->id }}" class="form-label  mb-2">Production Verify</label>
                                                                        <input type="text" class="form-control border-1 bg-light"
                                                                            id="production_verify{{ $downtime->id }}"
                                                                            name="production_verify"
                                                                            value="{{ old('production_verify', $downtime->production_verify) }}">
                                                                    </div>
                                        
                                                                    <!-- QC Approve -->
                                                                    <div class="col-md-6">
                                                                        <label for="qc_approve{{ $downtime->id }}" class="form-label  mb-2">QC Approve</label>
                                                                        <input type="text" class="form-control border-1 bg-light"
                                                                            id="qc_approve{{ $downtime->id }}"
                                                                            name="qc_approve"
                                                                            value="{{ old('qc_approve', $downtime->qc_approve) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                        
                                                            <!-- Timestamps Section -->
                                                            <div class="section">
                                                                <h6 class="section-title text-primary mb-3">Timestamps</h6>
                                                                <div class="row g-3">
                                                                    <!-- Submit Time -->
                                                                    <div class="col-md-4">
                                                                        <label class="form-label  mb-2">Submit</label>
                                                                        <div class="d-flex gap-2">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm border-1 bg-light bg-light"
                                                                                value="{{ $downtime->tanggal_submit_formatted }}"
                                                                                readonly>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm border-1 bg-light bg-light"
                                                                                value="{{ $downtime->jam_submit_formatted }}"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                        
                                                                    <!-- Start Time -->
                                                                    <div class="col-md-4">
                                                                        <label class="form-label  mb-2">Start</label>
                                                                        <div class="d-flex gap-2">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm border-1 bg-light bg-light"
                                                                                value="{{ $downtime->tanggal_start_formatted }}"
                                                                                readonly>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm border-1 bg-light bg-light"
                                                                                value="{{ $downtime->jam_start_formatted }}"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                        
                                                                    <!-- Finish Time -->
                                                                    <div class="col-md-4">
                                                                        <label class="form-label  mb-2">Finish</label>
                                                                        <div class="d-flex gap-2">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm border-1 bg-light bg-light"
                                                                                value="{{ $downtime->tanggal_finish_formatted }}"
                                                                                readonly>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm border-1 bg-light bg-light"
                                                                                value="{{ $downtime->jam_finish_formatted }}"
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
                                                    <a href="{{ route('rekapdowntime.index', ['show' => request('show')]) }}"
                                                        class="btn btn-sm btn-outline-secondary mt-3">
                                                        <i class="fas fa-redo-alt me-1"></i>Reset Pencarian
                                                    </a>
                                                @else
                                                    <p class="mb-0">Belum ada data  yang tersedia</p>
                                                    
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
            <!-- jQuery and its dependencies -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <!-- Vanilla JavaScript for column management -->
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

            <!-- jQuery-dependent code -->
            <script>
                $(document).ready(function() {
                    // Set colspan for no-data-row
                    var colCount = $('table th').length;
                    $('.no-data-row td').attr('colspan', colCount);


                    // Handle custom defect functionality
                    function handleCustomDefect() {
                        $('.is_custom_defect').on('change', function() {
                            const modalId = $(this).closest('.modal').attr('id');
                            const standardDefectDiv = $(`#${modalId} #standard_defect_div`);
                            const customDefectDiv = $(`#${modalId} #custom_defect_div`);
                            const defectCategorySelect = $(`#${modalId} select[name="defect_category"]`);
                            const customDefectInput = $(`#${modalId} input[name="custom_defect_category"]`);

                            if (this.checked) {
                                // Custom defect selected
                                standardDefectDiv.hide();
                                customDefectDiv.show();
                                defectCategorySelect.prop('required', false).val('');
                                customDefectInput.prop('required', true);
                            } else {
                                // Standard defect selected
                                standardDefectDiv.show();
                                customDefectDiv.hide();
                                defectCategorySelect.prop('required', true);
                                customDefectInput.prop('required', false).val('');
                            }
                        });
                    }

                    // Modal handling
                    $('.modal').on('show.bs.modal', function() {
                        const modalId = $(this).attr('id');
                        const checkbox = $(`#${modalId} .is_custom_defect`);
                        checkbox.trigger('change');
                    });

                    $('#perPageSelect').on('change', function() {
                        const currentUrl = new URL(window.location.href);
                        currentUrl.searchParams.set('show', this.value);
                        window.location.href = currentUrl.toString();
                    });

                    // Initialize custom defect handling
                    handleCustomDefect();


                    // Tambahkan kode berikut di dalam blok $(document).ready(function() { ... })
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

                    // Saat modal pertama kali dibuka, Save nilai aslinya
                    $('.modal').on('show.bs.modal', function() {
                        const form = $(this).find('form');
                        form.find('select').each(function() {
                            $(this).data('original-value', $(this).val());
                        });
                    });
                });
            </script>
        @endsection
