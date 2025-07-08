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

        /* Table and Column Styling Improvements */
        .table {
            width: 100%;
            table-layout: fixed;
            /* Ensures consistent column widths */
        }

        .table th,
        .table td {
            padding: 10px 8px;
            vertical-align: middle;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Specific Column Width Adjustments */
        .table th.no-column {
            width: 50px;
        }

        .table th.badge-column {
            width: 80px;
        }

        .table th.username-column {
            width: 100px;
        }

        .table th.name-column {
            width: 120px;
        }

        .table th.email-column {
            width: 150px;
        }

        .table th.phone-column {
            width: 100px;
        }

        .table th.role-column {
            width: 90px;
        }

        /* Action Column Styling */
        .table th.actions-column {
            width: 120px;
            /* Fixed width for action column */
            /* text-align: center; */
        }

        .actions-cell {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 4px;
        }

        .actions-cell .btn {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0.25rem 0.5rem;
            margin: 0 2px;
        }

        .actions-cell .btn i {
            font-size: 0.75rem;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card form-card">
                    <div class="card-header bg-gradient-primary">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="mb-0 text-white">DATA USERS</h4>
                            <a href="{{ route('datauser.create') }}" class="btn btn-sm btn-outline-light">
                                <i class="far fa-plus-square me-1"></i> Add New User
                            </a>
                        </div>
                        <p class="mb-0 text-white-50">"Active User in the Molding Information System"</p>
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

                        <form action="{{ route('datauser.index') }}" method="GET">
                            <div class="row align-items-end">
                                <!-- Show Entries isolated on the left -->
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
                                            <option value="all" {{ request('filter_type') == 'all' ? 'selected' : '' }}>
                                                All</option>
                                            <option value="name"
                                                {{ request('filter_type') == 'name' ? 'selected' : '' }}>
                                                Name</option>
                                            <option value="badge"
                                                {{ request('filter_type') == 'badge' ? 'selected' : '' }}>Badge</option>
                                            <option value="Department"
                                                {{ request('filter_type') == 'department' ? 'selected' : '' }}>Department
                                            </option>
                                            <option value="role"
                                                {{ request('filter_type') == 'role' ? 'selected' : '' }}>Role</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Search - Right Side -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label text-muted small fw-medium mb-2">
                                            Search
                                        </label>
                                        <div class="d-flex align-items-center">
                                            <div class="input-group input-group-sm shadow-sm">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Search..." value="{{ request('search') }}">

                                                @if (request('search'))
                                                    <a href="{{ route('datauser.index', ['show' => request('show')]) }}"
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
                                            <th style="width: 50px">No</th>
                                            <th>Name</th>
                                            <th>Badge</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Department</th>
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                            <tr>
                                                <td class="number-cell">{{ $loop->iteration }}</td>
                                                <td>{{ $user->nama }}</td>
                                                <td class="text-center">{{ $user->badge }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td class="text-center">{{ $user->no_tlpn }}</td>
                                                <td>{{ $user->department }}</td>
                                                <td class="text-center">
                                                    @switch($user->role)
                                                        @case('leader')
                                                            <span class="badge bg-success">{{ $user->role }}</span>
                                                        @break

                                                        @case('teknisi')
                                                            <span class="badge bg-info">{{ $user->role }}</span>
                                                        @break

                                                        @case('admin')
                                                            <span class="badge bg-primary">{{ $user->role }}</span>
                                                        @break

                                                        @case('ipqc')
                                                            <span class="badge bg-warning text-dark">{{ $user->role }}</span>
                                                        @break

                                                        @default
                                                            <span class="badge bg-secondary">{{ $user->role }}</span>
                                                    @endswitch
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('datauser.show', $user) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="far fa-eye"></i>
                                                        </a>

                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $user->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $user->id }}">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title"
                                                                id="deleteModalLabel{{ $user->id }}">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>Delete
                                                                Confirmation
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this user?</p>
                                                            <p class="text-muted">
                                                                Badge: {{ $user->badge }}<br>
                                                                Name: {{ $user->nama }}<br>
                                                                Role: {{ $user->role }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i>Cancel
                                                            </button>
                                                            <form action="{{ route('datauser.destroy', $user) }}"
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

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form method="POST"
                                                            action="{{ route('datauser.update', $user) }}"
                                                            id="editForm{{ $user->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $user->id }}">

                                                            <div class="modal-header bg-gradient-primary">
                                                                <h5 class="modal-title text-light">
                                                                    <i class="fas fa-user-edit me-2"></i>EDIT USER DATA
                                                                </h5>
                                                                <a href="{{ route('datauser.index') }}"
                                                                    class="btn btn-outline-light hover-scale">
                                                                    <i class="bi bi-arrow-left me-1"></i> Back
                                                                </a>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="badge{{ $user->id }}"
                                                                            class="form-label">Badge</label>
                                                                        <input type="text"
                                                                            class="form-control bg-light @error('badge') is-invalid @enderror hover-form"
                                                                            id="badge{{ $user->id }}" name="badge"
                                                                            value="{{ old('badge', $user->badge) }}"
                                                                            required>
                                                                        @error('badge')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="nama{{ $user->id }}"
                                                                            class="form-label">Name</label>
                                                                        <input type="text"
                                                                            class="form-control bg-light @error('nama') is-invalid @enderror hover-form"
                                                                            id="nama{{ $user->id }}" name="nama"
                                                                            value="{{ old('nama', $user->nama) }}"
                                                                            required>
                                                                        @error('nama')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="department{{ $user->id }}"
                                                                            class="form-label">Department</label>
                                                                        <input type="text"
                                                                            class="form-control bg-light @error('department') is-invalid @enderror hover-form"
                                                                            id="department{{ $user->id }}"
                                                                            name="department"
                                                                            value="{{ old('department', $user->department) }}"
                                                                            required>
                                                                        @error('department')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="email{{ $user->id }}"
                                                                            class="form-label">Email</label>
                                                                        <input type="email"
                                                                            class="form-control bg-light @error('email') is-invalid @enderror hover-form"
                                                                            id="email{{ $user->id }}" name="email"
                                                                            value="{{ old('email', $user->email) }}"
                                                                            required>
                                                                        @error('email')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="no_tlpn{{ $user->id }}"
                                                                            class="form-label">Phone</label>
                                                                        <input type="text"
                                                                            class="form-control bg-light @error('no_tlpn') is-invalid @enderror hover-form"
                                                                            id="no_tlpn{{ $user->id }}"
                                                                            name="no_tlpn"
                                                                            value="{{ old('no_tlpn', $user->no_tlpn) }}"
                                                                            required>
                                                                        @error('no_tlpn')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="username{{ $user->id }}"
                                                                            class="form-label">Username</label>
                                                                        <input type="text"
                                                                            class="form-control bg-light @error('username') is-invalid @enderror hover-form"
                                                                            id="username{{ $user->id }}"
                                                                            name="username"
                                                                            value="{{ old('username', $user->username) }}"
                                                                            required>
                                                                        @error('username')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="password{{ $user->id }}"
                                                                            class="form-label">Password</label>
                                                                        <input type="password"
                                                                            class="form-control bg-light @error('password') is-invalid @enderror hover-form"
                                                                            id="password{{ $user->id }}"
                                                                            name="password"
                                                                            placeholder="Leave blank to keep current password">
                                                                        @error('password')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="role{{ $user->id }}"
                                                                            class="form-label bg-light">Role</label>
                                                                        <select
                                                                            class="form-select bg-light @error('role') is-invalid @enderror hover-form"
                                                                            id="role{{ $user->id }}" name="role"
                                                                            required>
                                                                            @php
                                                                                $roles = \App\Models\User::distinct()
                                                                                    ->pluck('role')
                                                                                    ->toArray();
                                                                            @endphp
                                                                            @foreach ($roles as $roleOption)
                                                                                <option value="{{ $roleOption }}"
                                                                                    {{ old('role', $user->role) == $roleOption ? 'selected' : '' }}>
                                                                                    {{ $roleOption }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('role')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer bg-light">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    Cancel
                                                                    {{-- <i class="fas fa-times me-1"></i> --}}
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    Update
                                                                    {{-- <i class="fas fa-save me-1"></i> --}}
                                                                </button>
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
                                                                <p class="mb-0">No user data found that matches the search
                                                                    "{{ request('search') }}"</p>
                                                                <small class="d-block mt-2">
                                                                    @if (request('filter_type') && request('filter_type') != 'all')
                                                                        Filter: {{ ucfirst(request('filter_type')) }}
                                                                    @endif
                                                                </small>
                                                                <a href="{{ route('datauser.index', ['show' => request('show')]) }}"
                                                                    class="btn btn-sm btn-outline-secondary mt-3">
                                                                    <i class="fas fa-redo-alt me-1"></i>Reset
                                                                </a>
                                                            @else
                                                                <p class="mb-0">No user data available yet</p>
                                                                <a href="{{ route('datauser.create') }}"
                                                                    class="btn btn-sm btn-primary mt-3">
                                                                    <i class="fas fa-plus-circle me-1"></i>Add User
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Existing code for perPageSelect
                            document.getElementById('perPageSelect').addEventListener('change', function() {
                                let currentUrl = new URL(window.location.href);
                                currentUrl.searchParams.set('show', this.value);
                                const searchValue = document.querySelector('input[name="search"]')?.value;
                                if (searchValue) {
                                    currentUrl.searchParams.set('search', searchValue);
                                }
                                window.location.href = currentUrl.toString();
                            });



                            // Existing code for form validation
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
                                const modalId = '#editModal{{ old('user_id') }}';
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
                        });
                    </script>


                @endsection
