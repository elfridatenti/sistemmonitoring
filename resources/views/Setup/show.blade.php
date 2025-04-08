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
        transition: transform 0.2s ease;
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

    /* Additional Refinements */
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .badge {
        padding: 0.5em 1em;
        font-weight: 500;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    .rounded-3 {
        border-radius: 0.5rem !important;
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
                                <h5 class="modal-title  mb-0">DETAIL PERMINTAAN SETUP </h5>
                            </div>
                            <a href="{{ route('setup.index') }}" class="btn btn-outline-light hover-scale">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">                       
                        <div class="p-3 bg-light rounded-3 info-card hover-shadow mb-4">
                            <h6 class="text-primary mb-3 border-bottom pb-2">Request Item by Production</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Leader</label>
                                        <div class="fw-medium">{{ $setup->leader }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Line</label>
                                        <div class="fw-medium">{{ $setup->line }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Schedule DateTime</label>
                                        <div class="fw-medium">
                                            {{ \Carbon\Carbon::parse($setup->schedule_datetime)->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Molding Machine</label>
                                        <div class="fw-medium">{{ $setup->mesin->molding_mc ?? 'N/A' }}</div>
                                    </div>
                                    
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Part Number</label>
                                        <div class="fw-medium">{{ $setup->part_number }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Quantity Product</label>
                                        <div class="fw-medium">{{ number_format($setup->qty_product) }}</div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Customer</label>
                                        <div class="fw-medium">{{ $setup->customer }}</div>
                                    </div>
                                </div>
                                  <!-- Right Column -->
                            <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Job Request</label>
                                        <div class="fw-medium">{{ $setup->job_request }}</div>
                                    </div>
                             
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">Mould Type</label>
                                            <div class="fw-medium">{{ $setup->mould_type }}</div>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">Mould Category</label>
                                            <div class="fw-medium">{{ $setup->mould_category }}</div>
                                        </div>
                        
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">Mould Cavity</label>
                                            <div class="fw-medium">{{ $setup->mould_cavity }}</div>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">Marking Type</label>
                                            <div class="fw-medium">{{ $setup->marking_type }}</div>
                                        </div>

                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">Cable Grip Size</label>
                                            <div class="fw-medium">{{ $setup->cable_grip_size }}</div>
                                        </div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small">Status</label>
                                        <div>
                                            <span class="badge bg-{{ 
                                                $setup->status == 'Menunggu' ? 'secondary' : 
                                                ($setup->status == 'Sedang Diproses' ? 'warning' : 
                                                ($setup->status == 'Menunggu QC Approve' ? 'info' : 
                                                ($setup->status == 'Completed' ? 'success' : 'primary'))) 
                                            }} hover-scale">
                                                {{ $setup->status }}
                                            </span>
                                        </div>
                                    </div>
                                       
                                </div>
                            </div>
                        </div>
                    
                           <!-- Timeline Section -->
                    <div class="mt-4">
                        <div class="p-3 bg-light rounded-3 info-card hover-shadow">
                            <h6 class="text-primary mb-3 border-bottom pb-2">Timeline</h6>
                            <div class="timeline">
                                <!-- Submit Time -->
                                <div class="timeline-item mb-3 d-flex align-items-center hover-translate">
                                    <div class="timeline-icon bg-primary rounded-circle p-2 me-3 shadow-sm">
                                        <i class="fas fa-paper-plane text-white small"></i>
                                    </div>
                                    <div>
                                        <label class="text-muted small">Submit Time</label>
                                        <div class="fw-medium">
                                            {{ $setup->tanggal_submit ? $setup->tanggal_submit_formatted : 'N/A' }} ; 
                                            {{ $setup->jam_submit ? $setup->jam_submit_formatted : 'N/A' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Start Time -->
                                <div class="timeline-item mb-3 d-flex align-items-center hover-translate">
                                    <div class="timeline-icon bg-info rounded-circle p-2 me-3 shadow-sm">
                                        <i class="fas fa-play text-white small"></i>
                                    </div>
                                    <div>
                                        <label class="text-muted small">Start Time</label>
                                        <div class="fw-medium">
                                            {{ $setup->tanggal_start ? $setup->tanggal_start_formatted : 'N/A' }} ; 
                                            {{ $setup->jam_start ? $setup->jam_start_formatted : 'N/A' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Finish Time (Leader Only) -->
                                @if(auth()->user()->role === 'leader')
                                <div class="timeline-item mb-3 d-flex align-items-center hover-translate">
                                    <div class="timeline-icon bg-success rounded-circle p-2 me-3 shadow-sm">
                                        <i class="fas fa-check text-white small"></i>
                                    </div>
                                    <div>
                                        <label class="text-muted small">Finish Time</label>
                                        <div class="fw-medium">
                                            {{ $setup->tanggal_finish ? $setup->tanggal_finish_formatted : 'N/A' }} ; 
                                            {{ $setup->jam_finish ? $setup->jam_finish_formatted : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection
