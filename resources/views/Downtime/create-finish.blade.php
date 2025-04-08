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
                        <h5 class="mb-0 text-center fw-semibold">Finish Downtime</h5>
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
                        @if ($downtimes->isEmpty())
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>No pending downtimes available.
                            </div>
                        @else
                            <form method="POST" action="{{ route('finishdowntime.store') }}" id="finishdowntimeForm">
                                @csrf

                                <!-- Step 1: Machine Selection -->
                                <div id="step1" class="downtime-step">
                                    <div class="form-group mb-4">
                                        <label for="molding_machine" class="form-label fw-bold">
                                            Pilih Molding Mesin <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('molding_machine') is-invalid @enderror"
                                            id="molding_machine" name="molding_machine" required>
                                            <option value="" selected disabled>Pilih Molding Mesin</option>
                                            @foreach ($downtimes->where('tanggal_start', '!=', null)->where('jam_start', '!=', null)->whereNull('tanggal_finish') as $downtime)
                                                <option value="{{ $downtime->id }}">
                                                    {{ $downtime->mesin->molding_mc ?? 'No Data Available' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('molding_machine')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Step 2: Details Form -->
                                <div id="step2" class="downtime-step" style="display: none;">
                                    <!-- Selected Machine Display -->
                                  

                                    <div class="row g-3">
                                        <!-- Maintenance Repair -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="maintenance_repair" class="form-label fw-bold">
                                                    Maintenance Repair <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('maintenance_repair') is-invalid @enderror"
                                                    id="maintenance_repair" name="maintenance_repair"
                                                    placeholder="Masukkan nama maintenance yang melakukan repair." required>
                                                @error('maintenance_repair')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Root Cause -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="root_cause" class="form-label fw-bold">
                                                    Root Cause <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control @error('root_cause') is-invalid @enderror" id="root_cause" name="root_cause"
                                                    rows="3" placeholder="Tuliskan root cause." required></textarea>
                                                @error('root_cause')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Action Taken -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="action_taken" class="form-label fw-bold">
                                                    Action Taken <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control @error('action_taken') is-invalid @enderror" id="action_taken" name="action_taken"
                                                    rows="3" placeholder="Tuliskan tindakan yang telah dilakukan." required></textarea>
                                                @error('action_taken')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

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
    // Molding machine change handler
    $('#molding_machine').change(function() {
        var selectedOption = $(this).find('option:selected');

        // Show step 2 with smooth transition
        if ($(this).val()) {
            $('#step1').fadeOut(300, function() {
                $('#selectedMachineText').text(selectedOption.text());
                $('#step2').fadeIn(300);
            });
        }
    });

    // Reset button functionality
    $('#resetBtn').click(function() {
        var selectedMachine = $('#molding_machine').val();
        $('#finishdowntimeForm')[0].reset();
        $('#molding_machine').val(selectedMachine);
        $('input:not([readonly]), textarea').val('');
        $('#step2').show();
    });

    // Cancel button functionality
    $('#cancelBtn').click(function() {
        $('#finishdowntimeForm')[0].reset();
        $('#step2').fadeOut(300, function() {
            $('#step1').fadeIn(300);
        });
    });
});
    </script>
@endsection
