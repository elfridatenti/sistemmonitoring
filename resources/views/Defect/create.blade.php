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

.defect-container {
    max-width: 600px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.defect-card {
    background: var(--surface);
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    padding: 2rem;
    border: 1px solid var(--border);
    transition: all 0.3s ease;
}

.defect-card:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    transform: translateY(-2px);
}

.card-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border);
}

.card-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text);
    margin: 0;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 500;
    color: var(--text);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--border);
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    background-color: var(--surface);
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    outline: none;
}

.form-control:hover {
    border-color: var(--primary);
    background-color: var(--background);
}

.form-control.is-invalid {
    border-color: #DC2626;
}

.invalid-feedback {
    color: #DC2626;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.btn-container {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}



.btn-primary {
    background-color: var(--primary);
    color: white;
    border: none;
}

.btn-primary:hover {
    background-color: var(--primary-hover);
    transform: translateY(-1px);
}

.btn-secondary {
    background-color: var(--secondary);
    color: white;
    border: none;
}

.btn-secondary:hover {
    background-color: var(--secondary-hover);
    transform: translateY(-1px);
}

/* Add subtle animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.defect-card {
    animation: fadeIn 0.3s ease-out;
}

/* Responsive design */
@media (max-width: 640px) {
    .defect-container {
        padding: 1rem;
        margin: 1rem auto;
    }
    
    .defect-card {
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

<div class="defect-container">
    <div class="defect-card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Add New Defect Category
            </h2>
        </div>
        
        <form action="{{ route('defect.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-tag-fill me-1"></i>
                    Defect Category
                </label>
                <input 
                    type="text" 
                    name="defect_category" 
                    class="form-control @error('defect_category') is-invalid @enderror"
                    value="{{ old('defect_category') }}" 
                    placeholder="Enter defect category"
                    required
                >
                @error('defect_category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="btn-container">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle-fill"></i>
                    Save
                </button>
                <a href="{{ route('defect.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state to submit button
    const form = document.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function() {
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Saving...';
        submitBtn.disabled = true;
    });

    // Add input animation
    const input = document.querySelector('.form-control');
    input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'translateY(-2px)';
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'translateY(0)';
    });
});
</script>
@endsection