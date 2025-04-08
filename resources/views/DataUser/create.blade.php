@extends('layout.header-sidebar')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .form-card {
            background-color: #ffffff;
            border-radius: 10px;
            border: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-3px);
        }

        .card-header {
            background: linear-gradient(120deg, #3a62ac, #2c4b8a);
            color: white;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            border-bottom: none;
            position: relative;
        }

        .step-badge {
            background-color: rgba(255, 255, 255, 0.9);
            color: #3a62ac;
            padding: 0.35rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2rem;
            background-color: #ffffff;
        }

        /* Form Fields Styling */
        .form-control {
            border-radius: 6px;
            border: 1px solid #c5ccd6;
            /* Darker border color but still subtle */
            padding: 0.4rem 0.9rem;
            font-size: 0.95rem;
            transition: all 0.25s ease;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: #3a62ac;
            box-shadow: 0 0 0 3px rgba(58, 98, 172, 0.15);
            background-color: #ffffff;
        }

        /* Form Label Styling */
        .form-label {
            font-weight: 600;
            /* Increased from 500 to 600 for more boldness */
            color: #2c3e50;
            /* Slightly darker color for better contrast */
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }


        .form-control::placeholder {
            color: #a9b4c0;
            font-size: 0.9rem;
        }

        .form-control:hover:not(:focus) {
            border-color: #b8c2d0;
        }



        /* Select Box Styling */
        .select-wrapper {
            position: relative;
        }

        .select-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6c757d;
        }

        select.form-control {
            appearance: none;
            padding-right: 30px;
        }

        /* Buttons Styling */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 1.5rem;
        }



        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #3a62ac;
        }

        .btn-primary:hover {
            background-color: #2c4b8a;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-warning {
            background-color: #e5a54b;
            color: #ffffff;
        }

        .btn-warning:hover {
            background-color: #d69638;
            color: #ffffff;
        }

        /* Alerts Styling */
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

        .me-1 {
            margin-right: 4px;
        }

        /* Textarea Special Styling */
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Responsive Adjustments */
        @media (max-width: 991.98px) {
            .col-md-4 {
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 767.98px) {
            .card-body {
                padding: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        /* Note/Info in Card Header Styling */
        .form-notes {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 6px;
            padding: 0.7rem;
            margin-top: 0.5rem;
            font-size: 0.70rem;
        }

        .form-notes p {
            font-weight: 600;
        }

        .form-notes ul {
            padding-left: 1.8rem;
            margin-bottom: 0;
        }

        .form-notes li {
            margin-bottom: 0.15rem;
        }

        /* Adjust responsive behavior for the notes */
        @media (max-width: 767.98px) {
            .form-notes {
                padding: 0.5rem;
            }

            .form-notes ul {
                padding-left: 1.5rem;
            }
        }
    </style>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card form-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="mb-0">{{ __('Create New User') }}</h4>
                            {{-- <span class="step-badge">User Registration</span> --}}
                        </div>
                        <div class="form-notes">
                            <p class="mb-0"><i class="fas fa-info-circle me-2"></i> Perhatikan hal-hal berikut:</p>
                            <ul class="mb-0 mt-1">
                                <li>Pastikan semua kolom terisi dengan benar</li>
                                <li>Periksa kembali semua data sebelum menyimpan</li>
                            </ul>
                        </div>
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

                        <!-- Alert Info untuk data tidak ditemukan -->
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


                        <form method="POST" action="{{ route('datauser.store') }}" id="userForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label for="badge" class="form-label">
                                            <i class="bi bi-badge-ad me-1"></i>Badge Number
                                        </label>
                                        <input type="text" class="form-control @error('badge') is-invalid @enderror"
                                            id="badge" name="badge" value="{{ old('badge') }}" required
                                            placeholder="Enter badge number">
                                        @error('badge')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label for="nama" class="form-label">
                                            <i class="bi bi-person me-1"></i>Full Name
                                        </label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama') }}" required
                                            placeholder="Enter full name">
                                        @error('nama')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label for="level_user" class="form-label">
                                            <i class="bi bi-layers me-1"></i>Jabatan
                                        </label>
                                        <input type="text" class="form-control @error('level_user') is-invalid @enderror"
                                            id="level_user" name="level_user"
                                            value="{{ old('level_user', $user->level_user ?? '') }}" required
                                            placeholder="Enter jabatan">
                                        @error('level_user')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label for="email" class="form-label">
                                            <i class="bi bi-envelope me-1"></i>Email Address
                                        </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" required
                                            placeholder="Enter email address">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label for="no_tlpn" class="form-label">
                                            <i class="bi bi-telephone me-1"></i>Phone Number
                                        </label>
                                        <input type="tel" class="form-control @error('no_tlpn') is-invalid @enderror"
                                            id="no_tlpn" name="no_tlpn" value="{{ old('no_tlpn') }}" required
                                            placeholder="Enter phone number">
                                        @error('no_tlpn')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label for="username" class="form-label">
                                            <i class="bi bi-person-badge me-1"></i>Username
                                        </label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="username" name="username" value="{{ old('username') }}" required
                                            placeholder="Enter username">
                                        @error('username')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                         
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="password" class="form-label">
                                            <i class="bi bi-lock me-1"></i>Password
                                        </label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" required placeholder="Enter password">
                                            <button class="btn password-toggle" type="button" id="togglePassword">
                                                <i class="bi bi-eye" id="toggleIcon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                  
                            
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="role" class="form-label">
                                            <i class="bi bi-shield-lock me-1"></i>System Role
                                        </label>
                                        <div class="select-wrapper">
                                            <select class="form-control @error('role') is-invalid @enderror"
                                                id="role" name="role" required>
                                                <option value="">Select Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="leader">Leader</option>
                                                <option value="teknisi">Teknisi</option>
                                                <option value="ipqc">IPQC</option>
                                            </select>
                                            <span class="select-icon">
                                                <i class="fas fa-chevron-down"></i>
                                            </span>
                                        </div>
                                        @error('role')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <a href="{{ route('datauser.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                                <button type="reset" class="btn btn-warning">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetButton = form.querySelector('button[type="reset"]');
            resetButton.addEventListener('click', function(e) {
                e.preventDefault();
                form.reset();
            });

            // Password visibility toggle
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('bi-eye');
                this.querySelector('i').classList.toggle('bi-eye-slash');
            });

            // Phone number formatting
            const phoneInput = document.getElementById('no_tlpn');
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    if (value.length <= 4) {
                        value = value;
                    } else if (value.length <= 8) {
                        value = value.slice(0, 4) + '-' + value.slice(4);
                    } else {
                        value = value.slice(0, 4) + '-' + value.slice(4, 8) + '-' + value.slice(8, 12);
                    }
                }
                e.target.value = value;
            });

            // Username auto-generation
            const nameInput = document.getElementById('nama');
            const usernameInput = document.getElementById('username');

            nameInput.addEventListener('input', function() {
                if (!usernameInput.value) {
                    const username = this.value
                        .toLowerCase()
                        .replace(/\s+/g, '.')
                        .replace(/[^a-z0-9.]/g, '');
                    usernameInput.value = username;
                }
            });

            // Form validation
            const form = document.getElementById('userForm');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll(
                    'input[required], select[required], textarea[required]');

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Pastikan seluruh kolom terisi!');
                }

                if (form.checkValidity()) {
                    form.classList.add('was-validated');
                }
            });
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the icon
            if (type === 'text') {
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        });
    });
    </script>
@endsection
