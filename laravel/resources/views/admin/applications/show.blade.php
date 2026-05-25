@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('applications.index') }}" class="text-secondary text-decoration-none mb-2 d-inline-block">
            <i class="fas fa-arrow-left me-1"></i> Back to Applications
        </a>
        <h1>Review Application</h1>
        <div class="page-subtitle">Detailed review for {{ $application->citizen->full_name }}</div>
    </div>
    <span class="badge bg-warning text-dark px-3 py-2 fs-6 rounded-pill">Pending Review</span>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-white pb-0 border-bottom-0 pt-4">
                <h6 class="fw-bold text-dark text-uppercase mb-0"><i class="fas fa-user-circle me-2 text-primary"></i> Citizen Overview</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="small text-secondary fw-semibold">Full Name</div>
                    <div class="text-dark fw-bold fs-5">{{ $application->citizen->full_name }}</div>
                </div>
                <div class="mb-3">
                    <div class="small text-secondary fw-semibold">Aadhaar Number</div>
                    <div class="text-dark">{{ $application->citizen->aadhaar_number }}</div>
                </div>
                <div class="mb-3">
                    <div class="small text-secondary fw-semibold">Contact</div>
                    <div class="text-dark">{{ $application->citizen->mobile_number }} <br> {{ $application->citizen->email_address }}</div>
                </div>
                <div>
                    <div class="small text-secondary fw-semibold">Location</div>
                    <div class="text-dark">{{ $application->citizen->district }}, {{ $application->citizen->state }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header bg-white pb-0 border-bottom-0 pt-4">
                <h6 class="fw-bold text-dark text-uppercase mb-0"><i class="fas fa-file-contract me-2 text-primary"></i> Scheme Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="small text-secondary fw-semibold">Applied Scheme</div>
                        <div class="text-primary fw-bold fs-5">{{ $application->pensionScheme->scheme_name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="small text-secondary fw-semibold">Proposed Benefit</div>
                        <div class="text-success fw-bold fs-5">₹{{ number_format($application->monthly_benefit_amount, 2) }} / mo</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="small text-secondary fw-semibold">Enrollment Number</div>
                        <div class="text-dark">{{ $application->enrollment_number }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="small text-secondary fw-semibold">Application Date</div>
                        <div class="text-dark">{{ $application->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($detailedApplication)
<div class="card mb-4">
    <div class="card-header bg-white pt-4 pb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-list-alt text-primary me-2"></i> Comprehensive Application Data</h5>
    </div>
    <div class="card-body p-0">
        <div class="row g-0">
            <!-- Left Column -->
            <div class="col-md-6 border-end">
                <div class="p-4">
                    <h6 class="fw-bold text-secondary text-uppercase border-bottom pb-2 mb-3">Personal & Family</h6>
                    
                    <div class="row mb-2">
                        <div class="col-5 text-secondary">Marital Status</div>
                        <div class="col-7 fw-medium">{{ $detailedApplication->marital_status }}</div>
                    </div>
                    @if($detailedApplication->marital_status === 'Married')
                    <div class="row mb-2">
                        <div class="col-5 text-secondary">Spouse Name</div>
                        <div class="col-7 fw-medium">{{ $detailedApplication->spouse_name }}</div>
                    </div>
                    @endif
                    <div class="row mb-2">
                        <div class="col-5 text-secondary">Dependents</div>
                        <div class="col-7 fw-medium">{{ $detailedApplication->number_of_dependents }}</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-5 text-secondary">Religion</div>
                        <div class="col-7 fw-medium">{{ $detailedApplication->religion ?? 'N/A' }}</div>
                    </div>

                    <h6 class="fw-bold text-secondary text-uppercase border-bottom pb-2 mb-3">Employment & Income</h6>
                    <div class="row mb-2">
                        <div class="col-5 text-secondary">Status</div>
                        <div class="col-7 fw-medium">{{ $detailedApplication->employment_status }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-secondary">Monthly Income</div>
                        <div class="col-7 fw-medium text-success">₹{{ number_format($detailedApplication->monthly_income, 2) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-secondary">Total Assets</div>
                        <div class="col-7 fw-medium">₹{{ number_format($detailedApplication->total_assets, 2) }}</div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <div class="p-4">
                    <h6 class="fw-bold text-secondary text-uppercase border-bottom pb-2 mb-3">Category & Health</h6>
                    <div class="row mb-2">
                        <div class="col-5 text-secondary">Caste Category</div>
                        <div class="col-7 fw-medium">
                            <span class="badge bg-secondary">{{ $detailedApplication->caste_category }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-secondary">Health Status</div>
                        <div class="col-7 fw-medium">{{ $detailedApplication->health_status }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-secondary">Disability</div>
                        <div class="col-7 fw-medium">
                            @if($detailedApplication->disability_status !== 'No')
                                <span class="badge bg-warning text-dark"><i class="fas fa-wheelchair me-1"></i> {{ $detailedApplication->disability_status }}</span>
                            @else
                                {{ $detailedApplication->disability_status }}
                            @endif
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-5 text-secondary">Health Insurance</div>
                        <div class="col-7 fw-medium">{{ $detailedApplication->health_insurance_status }}</div>
                    </div>

                    <h6 class="fw-bold text-secondary text-uppercase border-bottom pb-2 mb-3">Education</h6>
                    <div class="row mb-2">
                        <div class="col-5 text-secondary">Level</div>
                        <div class="col-7 fw-medium">{{ $detailedApplication->education_level }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-secondary">
    <i class="fas fa-info-circle me-2"></i> Comprehensive detailed application data is not available for this record.
</div>
@endif

<!-- Admin Actions -->
<div class="card border-primary mb-5" style="border-width: 2px;">
    <div class="card-header bg-primary bg-opacity-10 pt-4 pb-3">
        <h5 class="fw-bold text-primary mb-0"><i class="fas fa-gavel me-2"></i> Administrative Decision</h5>
    </div>
    <div class="card-body p-4">
        <p class="text-secondary mb-4">Review all the provided information carefully. Approving this application will activate the pension assignment for the citizen.</p>
        
        <div class="d-flex gap-3">
            <form action="{{ route('applications.update', $application->id) }}" method="POST" class="flex-grow-1">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="Active">
                <button type="submit" class="btn btn-success w-100 py-3 fw-bold fs-5" style="border-radius: 8px;">
                    <i class="fas fa-check-circle me-2"></i> Approve Application
                </button>
            </form>
            
            <form action="{{ route('applications.update', $application->id) }}" method="POST" class="flex-grow-1">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="Rejected">
                <button type="submit" class="btn btn-danger w-100 py-3 fw-bold fs-5" style="border-radius: 8px;" onclick="return confirm('Are you sure you want to reject this application?')">
                    <i class="fas fa-times-circle me-2"></i> Reject Application
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
