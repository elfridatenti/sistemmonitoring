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
            <div class="col-12">
                <div class="card form-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="mb-0">{{ __('REQUEST SETUP BY PRODUCTION') }}</h4>
                            {{-- <span class="step-badge">Request Setup</span> --}}
                        </div>
                        <div class="form-notes">
                            <p class="mb-0"><i class="fas fa-info-circle me-2"></i>Note the following:</p>
                            <ul class="mb-0 mt-1">
                                <li>Make sure the leader name is correct</li>
                                <li>All fields must be filled in with the correct information</li>
                                <li>Recheck all data before saving  </li>
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

                        <form method="POST" action="{{ route('setup.store') }}" id="setupForm">
                            @csrf

                            <!-- Maintenance Name field - this will control visibility of other fields -->
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="maintenance_name" class="form-label">Maintenance Name</label>
                                    <div class="select-wrapper">
                                        <select class="form-control @error('maintenance_name') is-invalid @enderror"
                                            id="maintenance_name" name="maintenance_name" required>
                                            <option value="" selected disabled>Select Available Technicians</option>
                                            @if ($availableTeknisiUsers->count() > 0)
                                                @foreach ($availableTeknisiUsers as $teknisi)
                                                    <option value="{{ $teknisi->id }}"
                                                        {{ old('maintenance_name') == $teknisi->id ? 'selected' : '' }}>
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
                                    @error('maintenance_name')
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

                            <!-- This div contains all other form fields that will be shown only after maintenance name is selected -->
                            <div id="conditionalFormSections" style="width: 100%;">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="leader" class="form-label">Leader</label>
                                            <input type="text" class="form-control @error('leader') is-invalid @enderror"
                                                id="leader" name="leader" value="{{ old('leader', $user->nama) }}"
                                                readonly>
                                            @error('leader')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="line" class="form-label">Line</label>
                                            <input type="text" class="form-control @error('line') is-invalid @enderror"
                                                id="line" name="line" value="{{ old('line') }}" required
                                                placeholder="Input Line">
                                            @error('line')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="schedule_datetime" class="form-label">Schedule Date & Time</label>
                                            <input type="datetime-local"
                                                class="form-control @error('schedule_datetime') is-invalid @enderror"
                                                id="schedule_datetime" name="schedule_datetime"
                                                value="{{ old('schedule_datetime', isset($data) ? date('Y-m-d\TH:i', strtotime($data->schedule_datetime)) : '') }}">
                                            @error('schedule_datetime')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="part_number" class="form-label">Part Number</label>
                                            <input type="text"
                                                class="form-control @error('part_number') is-invalid @enderror"
                                                id="part_number" name="part_number" value="{{ old('part_number') }}"
                                                required placeholder="Input Part Number">
                                            @error('part_number')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="customer" class="form-label">Customer</label>
                                            <input type="text"
                                                class="form-control @error('customer') is-invalid @enderror"
                                                id="customer" name="customer" value="{{ old('customer') }}" required
                                                placeholder="Input Customer">
                                            @error('customer')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="qty_product" class="form-label">Quantity Product</label>
                                            <input type="number"
                                                class="form-control @error('qty_product') is-invalid @enderror"
                                                id="qty_product" name="qty_product" value="{{ old('qty_product') }}"
                                                required placeholder="Input Quantity Product">
                                            @error('qty_product')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="mould_type" class="form-label">Mould Type</label>
                                            <input type="text"
                                                class="form-control @error('mould_type') is-invalid @enderror"
                                                id="mould_type" name="mould_type" value="{{ old('mould_type') }}"
                                                required placeholder="Input Mould Type">
                                            @error('mould_type')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="mould_cavity" class="form-label">Mould Cavity</label>
                                            <input type="text"
                                                class="form-control @error('mould_cavity') is-invalid @enderror"
                                                id="mould_cavity" name="mould_cavity" value="{{ old('mould_cavity') }}"
                                                required placeholder="Input Mould Cavity">
                                            @error('mould_cavity')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="mould_category" class="form-label">Mould Category</label>
                                            <div class="select-wrapper">
                                                <select class="form-control @error('mould_category') is-invalid @enderror"
                                                    id="mould_category" name="mould_category" required>
                                                    <option value="" selected disabled>Select Mould Category</option>
                                                    <option value="Mold Connector"
                                                        {{ old('mould_category') == 'Mold Connector' ? 'selected' : '' }}>
                                                        Mold Connector</option>
                                                    <option value="Mold Inner"
                                                        {{ old('mould_category') == 'Mold Inner' ? 'selected' : '' }}>
                                                        Mold Inner</option>
                                                    <option value="Mold Plug"
                                                        {{ old('mould_category') == 'Mold Plug' ? 'selected' : '' }}>
                                                        Mold Plug</option>
                                                    <option value="Mold Grommet"
                                                        {{ old('mould_category') == 'Mold Grommet' ? 'selected' : '' }}>
                                                        Mold Grommet</option>
                                                </select>
                                                <span class="select-icon">
                                                    <i class="fas fa-chevron-down"></i>
                                                </span>
                                            </div>
                                            @error('mould_category')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="marking_type" class="form-label">Marking Type</label>
                                            <input type="text"
                                                class="form-control @error('marking_type') is-invalid @enderror"
                                                id="marking_type" name="marking_type" value="{{ old('marking_type') }}"
                                                required placeholder="Input Marking Type">
                                            @error('marking_type')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="cable_grip_size" class="form-label">Cable Grip Size</label>
                                            <input type="text"
                                                class="form-control @error('cable_grip_size') is-invalid @enderror"
                                                id="cable_grip_size" name="cable_grip_size"
                                                value="{{ old('cable_grip_size') }}" required
                                                placeholder="Input Cable Grip Size">
                                            @error('cable_grip_size')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label for="molding_machine" class="form-label">Molding Machine</label>
                                            <div class="select-wrapper">
                                                <select
                                                    class="form-control @error('molding_machine') is-invalid @enderror"
                                                    id="molding_machine" name="molding_machine">
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

                                
                                <div class="form-group mb-4">
                                    <label for="job_request" class="form-label">Job Request</label>
                                    <textarea class="form-control @error('job_request') is-invalid @enderror" id="job_request" name="job_request"
                                        rows="4" required placeholder="Input Job Request details">{{ old('job_request') }}</textarea>
                                    @error('job_request')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
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
            const form = document.getElementById('setupForm');
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

            // Machine selection tracking
            let selectedMesins = [];
            @foreach ($mesins as $mesin)
                selectedMesins.push({{ $mesin->mesin_id }});
            @endforeach

            $('#molding_machine').on('change', function() {
                let selectedMesinId = $(this).val();
                if (selectedMesinId !== '') {
                    selectedMesins.push(parseInt(selectedMesinId));
                }
            });
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const scheduleDatetime = document.getElementById('schedule_datetime');
    const form = document.getElementById('setupForm');

    // Set min datetime attribute to be 2 hours from now (changed from 10 minutes)
    function updateMinDatetime() {
        const now = new Date();
        // Add 2 hours to current time (changed from 10 minutes)
        now.setHours(now.getHours() + 2);
        
        // Format date to YYYY-MM-DDThh:mm format required by datetime-local input
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        const minDatetime = `${year}-${month}-${day}T${hours}:${minutes}`;
        
        // Set min attribute
        scheduleDatetime.setAttribute('min', minDatetime);
        
        // Store this value to use for validation
        scheduleDatetime.dataset.minDateTime = minDatetime;
        
        return minDatetime;
    }
    
    // Initial setup
    const minDatetime = updateMinDatetime();
    
    // If there's no value yet, set a default value 3 hours from now (changed from 30 minutes)
    if (!scheduleDatetime.value) {
        const defaultDate = new Date();
        defaultDate.setHours(defaultDate.getHours() + 3); // Set it 3 hours ahead for better UX
        
        const year = defaultDate.getFullYear();
        const month = String(defaultDate.getMonth() + 1).padStart(2, '0');
        const day = String(defaultDate.getDate()).padStart(2, '0');
        const hours = String(defaultDate.getHours()).padStart(2, '0');
        const minutes = String(defaultDate.getMinutes()).padStart(2, '0');
        
        scheduleDatetime.value = `${year}-${month}-${day}T${hours}:${minutes}`;
    }
    
    // Validate on change
    scheduleDatetime.addEventListener('change', function() {
        const selectedTime = new Date(this.value).getTime();
        const minTime = new Date(this.dataset.minDateTime).getTime();
        
        if (selectedTime < minTime) {
            // Invalid time selected
            this.classList.add('is-invalid');
            
            if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                const errorMsg = document.createElement('div');
                errorMsg.className = 'invalid-feedback';
                errorMsg.innerHTML = 'Schedule time must be at least 2 hours from now'; // Updated error message
                this.parentNode.appendChild(errorMsg);
            }
        } else {
            // Valid time, remove error styling
            this.classList.remove('is-invalid');
            const errorFeedback = this.nextElementSibling;
            if (errorFeedback && errorFeedback.classList.contains('invalid-feedback')) {
                errorFeedback.remove();
            }
        }
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        // Update min datetime in case the page has been open for a while
        updateMinDatetime();
        
        const selectedTime = new Date(scheduleDatetime.value).getTime();
        const minTime = new Date(scheduleDatetime.dataset.minDateTime).getTime();
        
        if (selectedTime < minTime) {
            e.preventDefault();
            scheduleDatetime.classList.add('is-invalid');
            
            if (!scheduleDatetime.nextElementSibling || !scheduleDatetime.nextElementSibling.classList.contains('invalid-feedback')) {
                const errorMsg = document.createElement('div');
                errorMsg.className = 'invalid-feedback';
                errorMsg.innerHTML = 'Schedule time must be at least 2 hours from now'; // Updated error message
                scheduleDatetime.parentNode.appendChild(errorMsg);
            }
            
            // Scroll to the error
            scheduleDatetime.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            
            // Show alert
            alert('Schedule time must be at least 2 hours from now'); // Updated alert message
        }
    });
});
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the maintenance name dropdown and all form sections that should be conditionally displayed
            const maintenanceNameSelect = document.getElementById('maintenance_name');
            // Reset dropdown maintenance saat halaman dimuat
            const maintenanceRepairSelect = document.getElementById('maintenance_name');
            if (maintenanceNameSelect) {
                maintenanceNameSelect.value = '';
            }
            const formSections = document.getElementById('conditionalFormSections');

            // Initially hide the form sections
            formSections.style.display = 'none';

            // Add event listener to the maintenance name dropdown
            maintenanceNameSelect.addEventListener('change', function() {
                // If a maintenance name is selected, show the rest of the form
                if (this.value) {
                    formSections.style.display = 'block';
                    // Smooth scroll to the newly visible form sections
                    setTimeout(() => {
                        formSections.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                } else {
                    formSections.style.display = 'none';
                }
            });

            // Validasi form (your existing code)
            const form = document.getElementById('setupForm');
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
