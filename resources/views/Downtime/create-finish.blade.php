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

                        <form method="POST" action="{{ route('finishdowntime.store') }}" id="finishdowntimeForm"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Hidden field for the machine ID -->
                            <input type="hidden" name="molding_machine" id="molding_machine"
                                value="{{ $downtimes->first()->id ?? '' }}">

                            <div class="row g-3">
                                <!-- Root Cause -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="root_cause" class="form-label fw-bold">
                                            Root Cause <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control @error('root_cause') is-invalid @enderror" id="root_cause" name="root_cause"
                                            rows="3" placeholder="Describe the root cause." required></textarea>
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
                                            rows="3" placeholder="Describe the action taken." required></textarea>
                                        @error('action_taken')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Documentation -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="dokumentasi" class="form-label fw-bold">
                                            Documentation (Image/Video) <small class="text-muted"></small>
                                        </label>
                                        <input type="file" accept="image/*,video/*,application/pdf" capture="environment"
                                            class="form-control @error('dokumentasi') is-invalid @enderror"
                                            name="dokumentasi" id="dokumentasi">
                                        @error('dokumentasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">upload work documentation if available</small>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Reset button functionality
            $('#resetBtn').click(function() {
                $('input:not([readonly]):not(#molding_machine), textarea').val('');
            });

            // Cancel button functionality
            $('#cancelBtn').click(function() {
                window.location.href = "{{ url()->previous() }}";
            });
        });
    </script>
@endsection
