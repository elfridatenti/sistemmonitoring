@extends('layout.header-sidebar')

@section('content')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(120deg, #3a62ac, #2c4b8a);
            color: white;
            border-bottom: none;
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

        .alert-info {
            background-color: #e7f0ff;
            color: #2c4b8a;
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
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h5 class="mb-0 text-center fw-semibold">Finish Setup</h5>
                    </div>

                    <div class="card-body p-4">
                        <!-- Alerts -->
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

                        <form method="POST" action="{{ route('finishsetup.store') }}" id="finishSetupForm"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Hidden input for the machine ID -->
                            <input type="hidden" id="molding_machine" name="molding_machine"
                                value="{{ request('setup_id', '') }}">

                            <!-- Form Fields in Horizontal Flow -->
                            <div class="row g-3">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <!-- Mould Type -->
                                    <div class="form-group mb-3">
                                        <label for="mould_type_mtc" class="form-label fw-bold">
                                            Mould Type <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('mould_type_mtc') is-invalid @enderror"
                                            id="mould_type_mtc" name="mould_type_mtc" placeholder="Input mould type."
                                            required
                                            value="{{ request('setup_id') ? $setups->firstWhere('id', request('setup_id'))->mould_type_mtc ?? '' : '' }}">
                                        @error('mould_type_mtc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Cable Grip Size -->
                                    <div class="form-group mb-3">
                                        <label for="cable_grip_size_mtc" class="form-label fw-bold">
                                            Cable Grip Size <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('cable_grip_size_mtc') is-invalid @enderror"
                                            id="cable_grip_size_mtc" name="cable_grip_size_mtc"
                                            placeholder="Input cable grip size." required
                                            value="{{ request('setup_id') ? $setups->firstWhere('id', request('setup_id'))->cable_grip_size_mtc ?? '' : '' }}">
                                        @error('cable_grip_size_mtc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Asset No BT -->
                                    <div class="form-group mb-3">
                                        <label for="asset_no_bt" class="form-label fw-bold">
                                            Asset No BT <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('asset_no_bt') is-invalid @enderror" id="asset_no_bt"
                                            name="asset_no_bt" placeholder="Input asset no BT." required>
                                        @error('asset_no_bt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="marking_type_mtc" class="form-label fw-bold">
                                            Marking Type <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('marking_type_mtc') is-invalid @enderror"
                                            id="marking_type_mtc" name="marking_type_mtc" placeholder="Input marking type."
                                            required
                                            value="{{ request('setup_id') ? $setups->firstWhere('id', request('setup_id'))->marking_type_mtc ?? '' : '' }}">
                                        @error('marking_type_mtc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">

                                    <!-- Marking Type -->


                                    <!-- Ampere Rating -->
                                    <div class="form-group mb-3">
                                        <label for="ampere_rating" class="form-label fw-bold">
                                            Ampere Rating <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('ampere_rating') is-invalid @enderror"
                                            id="ampere_rating" name="ampere_rating" placeholder="Input ampere rating."
                                            required>
                                        @error('ampere_rating')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <!-- Dokumentasi -->
                                    <div class="form-group mb-3">
                                        <label for="dokumentasi" class="form-label fw-bold">
                                            Documentation (Image/Video)
                                        </label>
                                        <input type="file" accept="image/*,video/*" capture="environment"
                                            class="form-control @error('dokumentasi') is-invalid @enderror"
                                            name="dokumentasi" id="dokumentasi">
                                        @error('dokumentasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">upload work documentation</small>
                                    </div>

                                    <!-- Setup Problem -->
                                    <div class="form-group mb-3">
                                        <label for="setup_problem" class="form-label fw-bold">
                                            Setup Problem <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control @error('setup_problem') is-invalid @enderror" id="setup_problem" name="setup_problem"
                                            rows="4" placeholder="Explain the setup problem" required></textarea>
                                        @error('setup_problem')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-warning" id="resetBtn">
                                        Reset
                                    </button>
                                    <a href="{{ route('setup.index') }}" class="btn btn-danger">
                                        Cancel
                                    </a>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Reset button handler - reset all user input fields except readonly fields
            $('#resetBtn').click(function() {
                // Clear all text inputs and textareas except readonly fields
                $('input[type="text"]:not([readonly]), textarea').val('');

                // Reset file input by clearing its value
                $('#dokumentasi').val('');

                // Remove any validation error styling
                $('.is-invalid').removeClass('is-invalid');
            });

            // Form submission handler with validation
            $('#finishSetupForm').submit(function(e) {
                let isValid = true;
                $(this).find('[required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endsection
