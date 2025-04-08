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
                                <i class="fas fa-clock text-light fs-4"></i>
                            </div>
                            <h5 class="modal-title  mb-0">DETAIL DOWNTIME</h5>
                        </div>
                        <a href="{{ route('downtime.index') }}" class="btn btn-outline-light hover-scale">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body" id="detail-view">
                    <!-- Main Details Section -->
                    <div class="row g-4">
                        <!-- Left Column -->
                        <div class="col-md-12">
                            <div class="p-3 bg-light rounded-3 info-card hover-shadow">
                                <h6 class="text-primary mb-3 border-bottom pb-2">Request Item by Production</h6>
                                <div class="row">
                                <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <label class="text-muted small">Leader</label>
                                    <div class="fw-medium">{{ $downtime->user->nama }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="text-muted small">Badge</label>
                                    <div class="fw-medium">{{ $downtime->badge }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="text-muted small">Raised Operator</label>
                                    <div class="fw-medium">{{ $downtime->raised_operator }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="text-muted small">Raised IPQC</label>
                                    <div class="fw-medium">{{ $downtime->raised_ipqc }}</div>
                                </div>                          
                                <div class="info-item mb-3">
                                    <label class="text-muted small">Line</label>
                                    <div class="fw-medium">{{ $downtime->line }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <label class="text-muted small">Molding Machine</label>
                                    <div class="fw-medium">{{ $downtime->mesin->molding_mc ?? 'N/A' }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="text-muted small">Defect Category</label>
                                    <div class="fw-medium">
                                        @if(is_numeric($downtime->defect_category))
                                            {{ $downtime->defect->defect_category ?? 'N/A' }}
                                        @else
                                            {{ $downtime->defect_category }}
                                        @endif
                                    </div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="text-muted small">Problem/Defect Details</label>
                                    <div class="fw-medium">{{ $downtime->problem_defect }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="text-muted small">Status</label>
                                    <div>
                                        <span class="badge bg-{{ 
                                            $downtime->status == 'Menunggu' ? 'secondary' : 
                                            ($downtime->status == 'Sedang Diproses' ? 'warning' : 
                                            ($downtime->status == 'Menunggu QC Approve' ? 'info' : 
                                            ($downtime->status == 'Completed' ? 'success' : 'primary'))) 
                                        }} hover-scale">
                                            {{ $downtime->status }}
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
                                            {{ $downtime->tanggal_submit ? $downtime->tanggal_submit_formatted : 'N/A' }} ; 
                                            {{ $downtime->jam_submit ? $downtime->jam_submit_formatted : 'N/A' }}
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
                                            {{ $downtime->tanggal_start ? $downtime->tanggal_start_formatted : 'N/A' }} ; 
                                            {{ $downtime->jam_start ? $downtime->jam_start_formatted : 'N/A' }}
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
                                            {{ $downtime->tanggal_finish ? $downtime->tanggal_finish_formatted : 'N/A' }} ; 
                                            {{ $downtime->jam_finish ? $downtime->jam_finish_formatted : 'N/A' }}
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