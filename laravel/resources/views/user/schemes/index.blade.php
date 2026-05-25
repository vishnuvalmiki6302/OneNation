@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1>Pension Schemes</h1>
        <div class="page-subtitle">Browse and apply for available government pension schemes</div>
    </div>
</div>

<div class="row g-4">
    @forelse($schemes as $scheme)
    <div class="col-md-6 col-xl-4">
        <div class="card h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom-0 pt-4">
                <span class="badge-official bg-primary bg-opacity-10 text-primary mb-0 border-0">{{ $scheme->scheme_type }}</span>
                <span class="fw-bold text-success">₹{{ number_format($scheme->monthly_benefit_amount, 2) }}/mo</span>
            </div>
            <div class="card-body">
                <h4 class="fw-bold text-dark mb-2">{{ $scheme->scheme_name }}</h4>
                <p class="text-secondary small mb-3">Code: {{ $scheme->scheme_code }}</p>
                
                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-1"><i class="fas fa-check-circle text-success me-2"></i> Eligibility</h6>
                    <p class="text-secondary small mb-0 ms-4">{{ $scheme->eligibility_criteria }}</p>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 pb-4 pt-0">
                @if(in_array($scheme->id, $myApplications))
                    <button class="btn btn-secondary w-100 fw-bold" disabled>
                        <i class="fas fa-check-circle me-2"></i> Already Applied
                    </button>
                @else
                    <a href="{{ route('user.schemes.apply', $scheme->id) }}" class="btn btn-primary btn-primary-oneid w-100 fw-bold py-2 text-decoration-none text-center">
                        Apply Now
                    </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center py-5 bg-white border">
            <i class="fas fa-folder-open text-secondary mb-3" style="font-size: 3rem;"></i>
            <h4>No Active Schemes Available</h4>
            <p class="text-secondary mb-0">Currently there are no active pension schemes to apply for.</p>
        </div>
    </div>
    @endforelse
</div>
@endsection
