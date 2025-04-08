@extends('layout.header-sidebar')

@section('content')

<!-- Custom CSS -->
<style>
    /* Card and Container Styles */
    .card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .info-card {
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    /* Hover Effects */
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .hover-scale {
        transition: transform 0.2s ease;
    }

    .hover-scale:hover {
        transform: scale(1.05);
    }

    .hover-translate {
        transitiontransition: transform 0.2s ease;
    }

    .hover-translate:hover {
        transform: translateX(5px);
    }

    /* Timeline Styles */
    .timeline-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .timeline-item:hover .timeline-icon {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Info Item Styles */
    .info-item {
        padding: 8px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .info-item:hover {
        background-color: rgba(255, 255, 255, 0.7);
        transform: translateX(5px);
    }

    /* Button Styles */
    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* General Transitions */
    .transition-all {
        transition: all 0.3s ease;
    }

    /* Shadow Styles */
    .shadow-lg {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .shadow-sm {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }

    /* Badge Styles */
    .badge {
        padding: 0.5em 1em;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    /* Text and Background Colors */
    .bg-light {
        background-color: #f8f9fa !important;
    }

    .text-primary {
        color: #0d6efd !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    /* Border Styles */
    .border-bottom {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
    }

    .rounded-3 {
        border-radius: 0.5rem !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }

        .info-card {
            margin-bottom: 1rem;
        }

        .timeline-item {
            margin-bottom: 1.5rem;
        }
    }

    .bg-gradient-primary {
    background: linear-gradient(120deg, #3a62ac, #2c4b8a);
    color: white;
    border-bottom: none;
}
</style>

<div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg transition-all">

                    <!-- Card Header -->
                    <div class="card-header bg-gradient-primary border-bottom-0 rounded-top-4 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="modal-icon bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-tools text-light fs-4"></i>
                                </div>
                                <h5 class="modal-title  mb-0">DETAIL REKAPITULASI SETUP</h5>
                            </div>
                            <a href="{{ route('rekapsetup.index') }}" class="btn btn-outline-light hover-scale">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>


                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Request Item by Production Section -->
                        <div class="p-3 bg-light rounded-3 info-card hover-shadow mb-4">
                            <h6 class="text-primary mb-3 border-bottom pb-2">Request Item by Production</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Leader</label>
                                        <div class="fw-medium">{{ $setup->leader ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Line</label>
                                        <div class="fw-medium">{{ $setup->line ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Schedule DateTime</label>
                                        <div class="fw-medium">
                                            {{ \Carbon\Carbon::parse($setup->schedule_datetime)->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Part Number</label>
                                        <div class="fw-medium">{{ $setup->part_number ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Quantity Product</label>
                                        <div class="fw-medium">{{ $setup->qty_product ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Customer</label>
                                        <div class="fw-medium">{{ $setup->customer ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Job Request</label>
                                        <div class="fw-medium">{{ $setup->job_request ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Mould Type</label>
                                        <div class="fw-medium">{{ $setup->mould_type ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Mould Category</label>
                                        <div class="fw-medium">{{ $setup->mould_category ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Marking Type</label>
                                        <div class="fw-medium">{{ $setup->marking_type ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Mould Cavity</label>
                                        <div class="fw-medium">{{ $setup->mould_cavity ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Cable Grip Size</label>
                                        <div class="fw-medium">{{ $setup->cable_grip_size ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Molding Machine</label>
                                        <div class="fw-medium">{{ $setup->mesin->molding_mc ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- After Setup by tooling/teknisi Section -->
                        <div class="p-3 bg-light rounded-3 info-card hover-shadow mb-4">
                            <h6 class="text-primary mb-3 border-bottom pb-2">After Setup by tooling/teknisi</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Issued Date</label>
                                        <div class="fw-medium">
                                            {{ $setup->issued_date ? \Carbon\Carbon::parse($setup->issued_date)->format('d M Y') : 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Asset No BT</label>
                                        <div class="fw-medium">{{ $setup->asset_no_bt ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Maintenance Name</label>
                                        <div class="fw-medium">{{ $setup->maintenance_name ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Setup Problem</label>
                                        <div class="fw-medium">{{ $setup->setup_problem ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Mould Type (MTC)</label>
                                        <div class="fw-medium">{{ $setup->mould_type_mtc ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Marking Type (MTC)</label>
                                        <div class="fw-medium">{{ $setup->marking_type_mtc ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Cable Grip Size (MTC)</label>
                                        <div class="fw-medium">{{ $setup->cable_grip_size_mtc ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Ampere Rating</label>
                                        <div class="fw-medium">{{ $setup->ampere_rating ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- IPQC Checking Item by IPQC Section -->
                        <div class="p-3 bg-light rounded-3 info-card hover-shadow mb-4">
                            <h6 class="text-primary mb-3 border-bottom pb-2">IPQC Checking Item by IPQC</h6>
                            <div class="row g-3">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    @if (isset($setup->marking))
                                        <div class="info-item mt-3">
                                            <label class="text-muted small">Marking</label>
                                            <div>
                                                <span
                                                    class="badge {{ $setup->marking === 'Pass' ? 'bg-success' : 'bg-danger' }} hover-scale">
                                                    {{ $setup->marking ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                    @if (isset($setup->relief))
                                        <div class="info-item mt-3">
                                            <label class="text-muted small">Relief</label>
                                            <div>
                                                <span
                                                    class="badge {{ $setup->relief === 'Pass' ? 'bg-success' : 'bg-danger' }} hover-scale">
                                                    {{ $setup->relief ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                    @if (isset($setup->mismatch))
                                    <div class="info-item mt-3">
                                        <label class="text-muted small">Mismatch</label>
                                        <div>
                                            <span
                                                class="badge {{ $setup->mismatch === 'Pass' ? 'bg-success' : 'bg-danger' }} hover-scale">
                                                {{ $setup->mismatch ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                
                                </div>
                                <!-- Center Column -->
                                <div class="col-md-6">
                                    @if (isset($setup->pin_bar_connector))
                                <div class="info-item mt-3">
                                    <label class="text-muted small">Pin Bar Connector</label>
                                    <div>
                                        <span
                                            class="badge {{ $setup->pin_bar_connector === 'Pass' ? 'bg-success' : 'bg-danger' }} hover-scale">
                                            {{ $setup->pin_bar_connector ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                                   
                                    <div class="info-item mt-3">
                                        <label class="text-muted small">QC Approve</label>
                                        <div class="fw-medium">{{ $setup->qc_approve ?? 'N/A' }}</div>
                                    </div>

                                    <div class="info-item mt-3">
                                        <label class="text-muted small">Status</label>
                                        <div>
                                            <span
                                                class="badge bg-{{ $setup->status == 'Open' ? 'warning' : ($setup->status == 'Completed' ? 'success' : 'primary') }} hover-scale">
                                                {{ $setup->status ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timestamps Section -->
                        <div class="p-3 bg-light rounded-3 info-card hover-shadow">
                            <h6 class="text-primary mb-3 border-bottom pb-2">Timestamps</h6>
                            <div class="timeline">
                                <div class="timeline-item mb-3 d-flex align-items-center hover-translate">
                                    <div class="timeline-icon bg-primary rounded-circle p-2 me-3 shadow-sm">
                                        <i class="fas fa-paper-plane text-white small"></i>
                                    </div>
                                    <div>
                                        <label class="text-muted small">Submit Time</label>
                                        <div class="fw-medium">
                                            {{ $setup->tanggal_submit ? $setup->tanggal_submit_formatted : 'N/A' }}
                                            {{ $setup->jam_submit ? $setup->jam_submit_formatted : '' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="timeline-item mb-3 d-flex align-items-center hover-translate">
                                    <div class="timeline-icon bg-warning rounded-circle p-2 me-3 shadow-sm">
                                        <i class="fas fa-play text-white small"></i>
                                    </div>
                                    <div>
                                        <label class="text-muted small">Start Time</label>
                                        <div class="fw-medium">
                                            {{ $setup->tanggal_start ? $setup->tanggal_start_formatted : 'N/A' }}
                                            {{ $setup->jam_start ? $setup->jam_start_formatted : '' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="timeline-item mb-3 d-flex align-items-center hover-translate">
                                    <div class="timeline-icon bg-success rounded-circle p-2 me-3 shadow-sm">
                                        <i class="fas fa-check text-white small"></i>
                                    </div>
                                    <div>
                                        <label class="text-muted small">Finish Time</label>
                                        <div class="fw-medium">
                                            {{ $setup->tanggal_finish ? $setup->tanggal_finish_formatted : 'N/A' }}
                                            {{ $setup->jam_finish ? $setup->jam_finish_formatted : '' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
