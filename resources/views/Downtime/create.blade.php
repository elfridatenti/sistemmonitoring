@extends('layout.header-sidebar')


@section('content')


    <style>
        /* Card Styling */
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
            <div class="col-md-12">
                <div class="card form-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="mb-0">{{ __(' DOWNTIME REPORT BY PRODUCTION') }}</h4>
                            {{-- <span class="step-badge">Step 1</span> --}}
                        </div>
                        <div class="form-notes">
                            <p class="mb-0"><i class="fas fa-info-circle me-2"></i> Please note the following:</p>
                            <ul class="mb-0 mt-1">
                                <li>Ensure the leader's name is correct</li>
                                <li>All fields must be filled with accurate information</li>
                                <li>Double-check all data before saving</li>
                            </ul>
                        </div>
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


                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('downtime.store') }}" id="downtimeForm">
                            @csrf
                            <!-- First row: Leader (alone) -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label for="maintenance_repair" class="form-label">Maintenance Name</label>
                                        <div class="select-wrapper">
                                            <select class="form-control @error('maintenance_repair') is-invalid @enderror"
                                                id="maintenance_repair" name="maintenance_repair" required>
                                                <option value="" selected disabled>Select Available Technicians
                                                </option>
                                                @if ($availableTeknisiUsers->count() > 0)
                                                    @foreach ($availableTeknisiUsers as $teknisi)
                                                        <option value="{{ $teknisi->id }}"
                                                            {{ old('maintenance_repair') == $teknisi->id ? 'selected' : '' }}>
                                                            {{ $teknisi->nama }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled>No technicians available</option>
                                                @endif
                                            </select>
                                            <span class="select-icon">
                                                <i class="fas fa-chevron-down"></i>
                                            </span>
                                        </div>
                                        @error('maintenance_repair')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        @if ($availableTeknisiUsers->count() == 0)
                                            <small class="text-danger">
                                                <i class="fas fa-info-circle me-1"></i>
                                                All technicians are handling other work. Please try again later.
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4" id="leaderSection" style="display: none;">
                                    <div class="form-group mb-4">
                                        <label for="leader" class="form-label">Leader</label>
                                        <input type="text" class="form-control @error('leader') is-invalid @enderror"
                                            id="leader" name="leader" value="{{ old('leader', $user->nama) }}"
                                            placeholder="Masukkan nama leader" readonly>
                                        @error('leader')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Container untuk semua kolom lain yang dikondisikan -->
                            <div id="conditionalFormSections" style="display: none; width: 100%;">
                                <!-- Second row: Line, Badge, Molding Machine -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="line" class="form-label">Line</label>
                                            <input type="text" class="form-control @error('line') is-invalid @enderror"
                                                id="line" name="line" value="{{ old('line') }}"
                                                placeholder="Input Line">
                                            @error('line')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="badge" class="form-label">Badge</label>
                                            <input type="text" class="form-control @error('badge') is-invalid @enderror"
                                                id="badge" name="badge" value="{{ old('badge') }}"
                                                placeholder="Input Badge">
                                            @error('badge')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="molding_machine" class="form-label">Molding Machine</label>
                                            <div class="select-wrapper">
                                                <select class="form-control @error('molding_machine') is-invalid @enderror"
                                                    id="molding_machine" name="molding_machine" required>
                                                    <option value="">Select Molding Machine</option>
                                                    @foreach ($mesins as $mesin)
                                                        <option value="{{ $mesin->id }}"
                                                            {{ old('molding_machine') == $mesin->id ? 'selected' : '' }}>
                                                            {{ $mesin->molding_mc }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="select-icon">
                                                    <i class="fas fa-chevron-down"></i>
                                                </span>
                                            </div>
                                            @error('molding_machine')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Third row: Raised Operator, Raised IPQC, Defect Category -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="raised_operator" class="form-label">Raised Operator</label>
                                            <input type="text"
                                                class="form-control @error('raised_operator') is-invalid @enderror"
                                                id="raised_operator" name="raised_operator"
                                                value="{{ old('raised_operator') }}"
                                                placeholder="Input name of operator machine">
                                            @error('raised_operator')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="raised_ipqc" class="form-label">Raised IPQC</label>
                                            <input type="text"
                                                class="form-control @error('raised_ipqc') is-invalid @enderror"
                                                id="raised_ipqc" name="raised_ipqc" value="{{ old('raised_ipqc') }}"
                                                placeholder="Input name QC">
                                            @error('raised_ipqc')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <div id="standard_defect_div">
                                                <label for="defect_category" class="form-label"> Defect Category</label>
                                                <div class="select-wrapper">
                                                    <select name="defect_category"
                                                        class="form-control @error('defect_category') is-invalid @enderror"
                                                        id="defect_category">
                                                        <option value="">Select Defect Category</option>
                                                        @foreach ($defects as $defect)
                                                            <option value="{{ $defect->id }}">
                                                                {{ $defect->defect_category }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="select-icon">
                                                        <i class="fas fa-chevron-down"></i>
                                                    </span>
                                                </div>
                                                @error('defect_category')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div id="custom_defect_div" style="display: none;">
                                                <label for="custom_defect_category" class="form-label">Custom Defect
                                                    Categories</label>
                                                <input type="text" name="custom_defect_category"
                                                    class="form-control @error('custom_defect_category') is-invalid @enderror"
                                                    placeholder="Input a new defect category">
                                                @error('custom_defect_category')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <!-- Checkbox moved below the fields -->
                                            <div class="custom-control custom-checkbox mt-1">
                                                <input type="checkbox" class="custom-control-input" id="is_custom_defect"
                                                    name="is_custom_defect" value="1" style="cursor: pointer;">
                                                <label class="custom-control-label" for="is_custom_defect"
                                                    style="cursor: pointer;">Custom Defect Categories</label>
                                                @error('is_custom_defect')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fourth row: Problem/Defect (alone) -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <label for="problem_defect" class="form-label">Problem/Defect</label>
                                            <textarea class="form-control @error('problem_defect') is-invalid @enderror" id="problem_defect"
                                                name="problem_defect" rows="4" placeholder= "Describe the problem or defect in detail">{{ old('problem_defect') }}</textarea>
                                            @error('problem_defect')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="form-actions">
                                    <button type="button" class="btn btn-secondary" onclick="location.reload()">
                                        <i class="fas fa-times-circle me-1"></i> Cancel
                                    </button>
                                    <button type="reset" class="btn btn-warning">
                                        <i class="fas fa-redo-alt me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Save
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
            // Validasi form
            const form = document.getElementById('downtimeForm');
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
            });

            // Perbaikan selector tombol cancel

            // Perbaikan selector tombol cancel
            const cancelButton = document.querySelector('.btn-secondary');
            cancelButton.addEventListener('click', function(e) {
                e.preventDefault();
                // Sembunyikan bagian form yang muncul setelah pemilihan maintenance
                const formSections = document.getElementById('conditionalFormSections');
                formSections.style.display = 'none';

                // Reset dropdown maintenance
                const maintenanceRepairSelect = document.getElementById('maintenance_repair');
                maintenanceRepairSelect.value = '';

                // Opsional: Scroll kembali ke bagian atas
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

                Opsional: Reset form jika diperlukan
                document.getElementById('downtimeForm').reset();
            });
            //    const cancelButton = document.querySelector('.btn-secondary');
            //    cancelButton.addEventListener('click', function() {
            //        window.location.href = '/downtime';  
            //    });

            const resetButton = form.querySelector('button[type="reset"]');
            resetButton.addEventListener('click', function(e) {
                e.preventDefault();
                form.reset();
            });

            // Toggle untuk kategori defect kustom
            document.getElementById('is_custom_defect').addEventListener('change', function() {
                const standardDefectDiv = document.getElementById('standard_defect_div');
                const customDefectDiv = document.getElementById('custom_defect_div');

                if (this.checked) {
                    standardDefectDiv.style.display = 'none';
                    customDefectDiv.style.display = 'block';
                } else {
                    standardDefectDiv.style.display = 'block';
                    customDefectDiv.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the maintenance name dropdown and all form sections that should be conditionally displayed
            // Reset dropdown maintenance saat halaman dimuat
            const maintenanceRepairSelect = document.getElementById('maintenance_repair');
            const leaderSection = document.getElementById('leaderSection');
            const formSections = document.getElementById('conditionalFormSections');
            const customDefectCheckbox = document.getElementById('is_custom_defect');
            const standardDefectDiv = document.getElementById('standard_defect_div');
            const customDefectDiv = document.getElementById('custom_defect_div');

            if (maintenanceRepairSelect) {
                maintenanceRepairSelect.value = '';
            }

            // Initially hide the form sections and leader section
            formSections.style.display = 'none';
            leaderSection.style.display = 'none';

            // Add event listener to the maintenance name dropdown
            maintenanceRepairSelect.addEventListener('change', function() {
                // If a maintenance name is selected, show the leader section and the rest of the form
                if (this.value) {
                    leaderSection.style.display = 'block';
                    formSections.style.display = 'block';
                    // Smooth scroll to the newly visible form sections
                    setTimeout(() => {
                        formSections.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                } else {
                    leaderSection.style.display = 'none';
                    formSections.style.display = 'none';
                }
            });

            // Event listener untuk checkbox defect kustom
            if (customDefectCheckbox) {
                customDefectCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        standardDefectDiv.style.display = 'none';
                        customDefectDiv.style.display = 'block';
                    } else {
                        standardDefectDiv.style.display = 'block';
                        customDefectDiv.style.display = 'none';
                    }
                });

                // Cek pada load halaman untuk checkbox defect kustom
                if (customDefectCheckbox.checked) {
                    standardDefectDiv.style.display = 'none';
                    customDefectDiv.style.display = 'block';
                }
            }

            // Validasi form (your existing code)
            const form = document.getElementById('downtimeForm');
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
            });

            // Machine selection tracking (your existing code)
            let selectedMesins = [];
            // This part will be populated from your Blade template
            $('#molding_machine').on('change', function() {
                let selectedMesinId = $(this).val();
                if (selectedMesinId !== '') {
                    selectedMesins.push(parseInt(selectedMesinId));
                }
            });
        });
    </script>

@endsection
