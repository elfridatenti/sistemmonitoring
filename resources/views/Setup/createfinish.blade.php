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
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h5 class="mb-0 text-center fw-semibold">Finish Setup</h5>
                    </div>

                    <div class="card-body p-4">
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
                        @if ($setups->isEmpty())
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>No pending setups available.
                            </div>
                        @else
                            <form method="POST" action="{{ route('finishsetup.store') }}" id="finishSetupForm">
                                @csrf

                                <!-- Machine Selection - Initially Visible -->
                                <div id="machineSelectionSection">
                                    <div class="form-group mb-4">
                                        <label for="molding_machine" class="form-label fw-bold">
                                            Pilih Molding Mesin <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('molding_machine') is-invalid @enderror"
                                            id="molding_machine" name="molding_machine" required>
                                            <option value="" selected disabled>Pilih Molding Mesin</option>
                                            @foreach ($setups->where('tanggal_start', '!=', null)->where('jam_start', '!=', null)->whereNull('tanggal_finish') as $setup)
                                                <option value="{{ $setup->id }}"
                                                    data-mould-type="{{ $setup->mould_type_mtc ?? '' }}"
                                                    data-marking-type="{{ $setup->marking_type_mtc ?? '' }}"
                                                    data-cable-grip-size="{{ $setup->cable_grip_size_mtc ?? '' }}"
                                                    data-issued-date="{{ $setup->schedule_datetime ? \Carbon\Carbon::parse($setup->schedule_datetime)->format('Y-m-d') : '' }}">
                                                    {{ $setup->mesin->molding_mc ?? 'No Data Available' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('molding_machine')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Setup Details (Initially Hidden) -->
                                <div id="setupDetails" style="display: none;">
                                    <!-- Selected Machine Display -->
                                  
                                    <!-- All Form Fields -->
                                    <div class="row g-3">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <!-- Issued Date -->
                                            <div class="form-group mb-3">
                                                <label for="issued_date" class="form-label fw-bold">Issued Date</label>
                                                <input type="text"
                                                    class="form-control @error('issued_date') is-invalid @enderror"
                                                    id="issued_date" name="issued_date" readonly>
                                                @error('issued_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Maintenance Name -->
                                            <div class="form-group mb-3">
                                                <label for="maintenance_name" class="form-label fw-bold">
                                                    Maintenance Repair <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('maintenance_name') is-invalid @enderror"
                                                    id="maintenance_name" name="maintenance_name"  placeholder="Masukkan nama maintenance yang melakukan repair."required>
                                                @error('maintenance_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Asset No BT -->
                                            <div class="form-group mb-3">
                                                <label for="asset_no_bt" class="form-label fw-bold">
                                                    Asset No BT <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('asset_no_bt') is-invalid @enderror"
                                                    id="asset_no_bt" name="asset_no_bt" placeholder="Masukkan asset no BT." required>
                                                @error('asset_no_bt')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Mould Type -->
                                            <div class="form-group mb-3">
                                                <label for="mould_type_mtc" class="form-label fw-bold">
                                                    Mould Type <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('mould_type_mtc') is-invalid @enderror"
                                                    id="mould_type_mtc" name="mould_type_mtc" placeholder="Masukkan mould type." required>
                                                @error('mould_type_mtc')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <!-- Marking Type -->
                                            <div class="form-group mb-3">
                                                <label for="marking_type_mtc" class="form-label fw-bold">
                                                    Marking Type <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('marking_type_mtc') is-invalid @enderror"
                                                    id="marking_type_mtc" name="marking_type_mtc" placeholder="Masukkan marking type."required>
                                                @error('marking_type_mtc')
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
                                                    id="cable_grip_size_mtc" name="cable_grip_size_mtc" placeholder="Masukkan cable grip size."required>
                                                @error('cable_grip_size_mtc')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Ampere Rating -->
                                            <div class="form-group mb-3">
                                                <label for="ampere_rating" class="form-label fw-bold">
                                                    Ampere Rating <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('ampere_rating') is-invalid @enderror"
                                                    id="ampere_rating" name="ampere_rating" placeholder="Masukkan ampere_rating."required>
                                                @error('ampere_rating')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Setup Problem (Full Width) -->
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label for="setup_problem" class="form-label fw-bold">
                                                    Setup Problem <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control @error('setup_problem') is-invalid @enderror" id="setup_problem"
                                                    name="setup_problem" rows="4" placeholder="Tuliskan setup problem."required></textarea>
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
                                            <button type="button" class="btn btn-danger" id="cancelBtn">
                                                Cancel
                                            </button>
                                        </div>
                                        <button type="submit" class="btn btn-success">
                                           Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Machine selection handler
            $('#molding_machine').change(function() {
                var selectedOption = $(this).find('option:selected');

                if ($(this).val()) {
                    // Hide machine selection section
                    $('#machineSelectionSection').hide();
                    
                    // Show setup details section
                    $('#setupDetails').show();
                    
                    // Update selected machine display
                    $('#selectedMachineText').text(selectedOption.text());
                    
                    // Set values from data attributes
                    $('#issued_date').val(selectedOption.data('issued-date') || '');
                    $('#mould_type_mtc').val(selectedOption.data('mould-type') || '');
                    $('#marking_type_mtc').val(selectedOption.data('marking-type') || '');
                    $('#cable_grip_size_mtc').val(selectedOption.data('cable-grip-size') || '');
                }
            });

            // Change machine button handler
            $('#changeMachineBtn').click(function() {
                // Show machine selection section
                $('#machineSelectionSection').show();
                
                // Hide setup details section
                $('#setupDetails').hide();
                
                // Reset form
                resetForm();
            });

            // Reset button handler
            $('#resetBtn').click(function() {
                // Reset user-editable fields only, keep machine selection
                $('input[type="text"]:not([readonly]), textarea').val('');
                $('.is-invalid').removeClass('is-invalid');
            });

            // Cancel button handler - completely reset the form
            $('#cancelBtn').click(function() {
                resetForm();
                $('#machineSelectionSection').show();
                $('#setupDetails').hide();
            });

            // Function to reset the form
            function resetForm() {
                $('#finishSetupForm')[0].reset();
                $('#molding_machine').prop('selectedIndex', 0);
                $('.is-invalid').removeClass('is-invalid');
            }

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