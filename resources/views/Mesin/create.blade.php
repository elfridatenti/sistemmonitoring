@extends('layout.header-sidebar')
@section('content')
<style>
    :root {
        --primary: #4F46E5;
    --primary-hover: #4338CA;
    --secondary: #6B7280;
    --secondary-hover: #4B5563;
    --background: #F9FAFB;
    --surface: #FFFFFF;
    --border: #E5E7EB;
    --text: #111827;
    --text-secondary: #6B7280;
    }

    .molding-container {
        max-width: 600px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .molding-card {
        background: var(--surface);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 2rem;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }

    .molding-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .card-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        color: var(--text);
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-prefix {
        position: absolute;
        left: 1rem;
        color: var(--input-prefix);
        font-weight: 500;
        pointer-events: none;
        user-select: none;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--border);
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background-color: var(--surface);
        padding-left: 3.5rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .form-control:hover {
        border-color: var(--primary);
        background-color: var(--background);
    }

    .form-control.is-invalid {
        border-color: #EF4444;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23EF4444' viewBox='0 0 24 24'%3E%3Cpath d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1.5rem;
        padding-right: 2.5rem;
    }

    .invalid-feedback {
        color: #EF4444;
        font-size: 0.8rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .helper-text {
        color: var(--text-secondary);
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }

    .btn-container {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }



    .btn-primary {
        background-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: var(--secondary);
        color: white;
    }

    .btn-secondary:hover {
        background-color: var(--secondary-hover);
        transform: translateY(-1px);
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .molding-card {
        animation: slideIn 0.4s ease-out;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .loading-spinner {
        display: inline-block;
        width: 1.5rem;
        height: 1.5rem;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
    }

    @media (max-width: 640px) {
        .molding-container {
            padding: 1rem;
            margin: 1rem auto;
        }
        
        .molding-card {
            padding: 1.5rem;
        }
        
        .btn-container {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="molding-container">
    <div class="molding-card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="bi bi-gear-fill"></i>
                Add New Molding Machine
            </h2>
        </div>
        
        <form action="{{ route('mesin.store') }}" method="POST" id="moldingForm">
            @csrf
            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-hash"></i>
                    Molding Machine Number
                </label>
                <div class="input-group">
                    <span class="input-prefix">IM </span>
                    <input 
                        type="text" 
                        name="molding_mc" 
                        class="form-control @error('molding_mc') is-invalid @enderror"
                        value="{{ old('molding_mc') }}" 
                        placeholder="Enter machine number"
                        required
                    >
                </div>
                <div class="helper-text">Only enter the number, "IM" prefix will be added automatically</div>
                @error('molding_mc')
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="btn-container">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="bi bi-check-circle"></i>
                    Save
                </button>
                <a href="{{ route('mesin.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('moldingForm');
    const submitBtn = document.getElementById('submitBtn');
    const input = document.querySelector('.form-control');
    
    // Form submission handling
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Add "IM " prefix to the value before submission
        const machineNumber = input.value.trim();
        input.value = 'IM ' + machineNumber;
        
        submitBtn.innerHTML = '<span class="loading-spinner"></span> Saving...';
        submitBtn.disabled = true;
        
        form.submit();
    });
    
    // Input animations
    input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'translateY(-2px)';
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'translateY(0)';
    });
    
    // Auto-format input to uppercase
    input.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
        
        // Remove "IM " if user tries to type it
        if (this.value.startsWith('IM')) {
            this.value = this.value.replace('IM', '');
        }
    });
});
</script>
@endsection 