@extends('layout.header-sidebar')
@section('content')

<style>
    .bg-gradient-primary {
    background: linear-gradient(120deg, #3a62ac, #2c4b8a);
    color: white;
    border-bottom: none;
}
</style>
<div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white">
                        <span class="">USER DETAIL</span>
                        <a href="{{ route('datauser.index') }}" class="btn btn-light btn-sm rounded-pill shadow-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>

                    <!-- Detail View -->
                    <div class="card-body" id="detail-view">
                        <div class="row mb-3">
                            <label class="col-md-4 fw-bold">Badge:</label>
                            <div class="col-md-8">{{ $user->badge }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 fw-bold">Name:</label>
                            <div class="col-md-8">{{ $user->nama }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 fw-bold">Jabatan:</label>
                            <div class="col-md-8">{{ $user->level_user }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 fw-bold">Email:</label>
                            <div class="col-md-8">{{ $user->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 fw-bold">Phone:</label>
                            <div class="col-md-8">{{ $user->no_tlpn }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 fw-bold">Username:</label>
                            <div class="col-md-8">{{ $user->username }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 fw-bold">Role:</label>
                            <div class="col-md-8">{{ $user->role }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-sm">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-hide alerts after 5 seconds
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, 5000);
                });
            });
        </script>
    @endpush
@endsection

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 15px;
    }

    .card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .btn:hover {
        background-color: #0056b3;
        color: #ffffff;
    }
</style>
@endpush
