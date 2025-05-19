@extends('layout.header-sidebar')

@section('content')
    <style>
        /* Button hover effects */
        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
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

        /* Search input hover and focus effects */
        .input-group:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .input-group .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }


        /* Specific styling for the Number column */
        .table thead th:first-child,
        .table tbody td:first-child {
            text-align: right;
            padding-right: 1.5rem;
        }

        /* Add dots after numbers */
        .table tbody td:first-child::after {
            content: ".";
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
                            <h4 class="mb-0 text-white">ACTIVE MOLDING MACHINES</h4>
                            <a href="{{ route('mesin.create') }}" class="btn btn-sm btn-outline-light">
                                <i class="far fa-plus-square me-1"></i> Add New Machine
                            </a>
                        </div>
                        <p class="mb-0 text-white-50">"List of Active Molding Machines"</p>
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

                        <form action="{{ route('mesin.index') }}" method="GET">
                            <div class="row mb-3">
                                <!-- Show Entries isolated on the left -->
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-2">
                                            Show Entries
                                        </label>
                                        <select class="form-select form-select-sm shadow-sm w-auto me-2" name="show"
                                            id="perPageSelect" style="cursor: pointer;">
                                            <option value="10" {{ request('show') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="20" {{ request('show') == 20 ? 'selected' : '' }}>20</option>
                                            <option value="50" {{ request('show') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request('show') == 100 ? 'selected' : '' }}>100
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Filter and Search stacked vertically on the right -->
                                <div class="col-3 ms-auto">
                                    <!-- Search below filter -->
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-2">
                                            Search
                                        </label>
                                        <div class="input-group input-group-sm shadow-sm">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search..." value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-primary px-3">
                                                <i class="fas fa-search me-1"></i>
                                            </button>
                                            @if (request('search'))
                                                <a href="{{ route('mesin.index', ['show' => request('show')]) }}"
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
                                <table class="table table-striped table-hover ">

                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 75%">Molding Machine </th>
                                            <th style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($mesins as $mesin)
                                            <tr>
                                                <td class="number-cell">{{ $loop->iteration }}</td>
                                                <td>{{ $mesin->molding_mc }}</td>
                                                <td>
                                                    <div style="gap: 5px;">
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $mesin->id }}">
                                                            <i class="far fa-edit "></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $mesin->id }}">
                                                            <i class="far fa-trash-alt "></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteModal{{ $mesin->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $mesin->id }}">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>Delete Confirmation
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this molding machine?</p>
                                                            <p class="text-muted">
                                                                Molding Machine: {{ $mesin->molding_mc }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i>Cancel
                                                            </button>
                                                            <form action="{{ route('mesin.destroy', $mesin) }}" method="POST">
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

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal{{ $mesin->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('mesin.update', $mesin) }}"
                                                            id="editForm{{ $mesin->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="mesin_id"
                                                                value="{{ $mesin->id }}">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Machine Record</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="molding_mc{{ $mesin->id }}"
                                                                        class="form-label">Molding Machine Number</label>
                                                                    <input type="text"
                                                                        class="form-control @error('molding_mc') is-invalid @enderror"
                                                                        id="molding_mc{{ $mesin->id }}"
                                                                        name="molding_mc"
                                                                        value="{{ old('molding_mc', $mesin->molding_mc) }}"
                                                                        required>
                                                                    @error('molding_mc')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-5">
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
                                                            <a href="{{ route('mesin.index', ['show' => request('show')]) }}"
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
                            {{ $mesins->links() }}
                        </div>
                    </div>
                </div>


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Handle form validation
                        const forms = document.querySelectorAll('form[id^="editForm"]');
                        forms.forEach(form => {
                            form.addEventListener('submit', function(e) {
                                if (!this.checkValidity()) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                }
                                this.classList.add('was-validated');
                            });
                        });

                        // Show edit modal if there are validation errors
                        @if ($errors->any())
                            const modalId = '#editModal{{ old('mesin_id') }}';
                            const modal = document.querySelector(modalId);
                            if (modal) {
                                new bootstrap.Modal(modal).show();
                            }
                        @endif

                        // Auto-hide alerts after 5 seconds
                        const alerts = document.querySelectorAll('.alert');
                        alerts.forEach(alert => {
                            setTimeout(() => {
                                const bsAlert = new bootstrap.Alert(alert);
                                bsAlert.close();
                            }, 5000);
                        });

                        // Improved perPageSelect handler
                        const perPageSelect = document.getElementById('perPageSelect');
                        if (perPageSelect) {
                            perPageSelect.addEventListener('change', function() {
                                try {
                                    let currentUrl = new URL(window.location.href);

                                    // Set the new 'show' parameter
                                    currentUrl.searchParams.set('show', this.value);

                                    // Preserve the search parameter if it exists
                                    const searchParam = currentUrl.searchParams.get('search');
                                    if (searchParam) {
                                        currentUrl.searchParams.set('search', searchParam);
                                    }

                                    // Redirect to the new URL
                                    window.location.href = currentUrl.toString();
                                } catch (error) {
                                    console.error('Error updating URL:', error);
                                    // Fallback for any URL parsing errors
                                    window.location.href = `?show=${this.value}`;
                                }
                            });
                        }
                    });
                </script>

            @endsection
