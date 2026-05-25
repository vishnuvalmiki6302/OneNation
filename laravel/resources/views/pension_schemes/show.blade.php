@extends('layouts.admin')

@section('title', $pensionScheme->scheme_name . ' - Scheme Details')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <div>
            <h1>{{ $pensionScheme->scheme_name }}</h1>
            <p class="page-subtitle">Scheme Code: <span style="font-family: monospace;">{{ $pensionScheme->scheme_code }}</span></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pension-schemes.edit', $pensionScheme) }}" class="btn-oneid btn-accent-oneid">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('pension-schemes.index') }}" class="btn-oneid btn-outline-oneid">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0 text-uppercase" style="font-size: 0.78rem; letter-spacing: 0.08em; color: var(--text-secondary);">Status</h6>
                        <span class="badge-status badge-{{ strtolower($pensionScheme->status) }}">{{ $pensionScheme->status }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Type / Provider</div>
                        <div style="font-weight: 600;">{{ $pensionScheme->scheme_type }} · {{ $pensionScheme->provider_type }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Monthly Benefit</div>
                        <div style="font-weight: 700; font-size: 1.25rem; color: var(--primary);">₹{{ number_format($pensionScheme->monthly_benefit_amount, 2) }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Eligibility Criteria</div>
                        <div style="font-size: 0.88rem;">{{ $pensionScheme->eligibility_criteria }}</div>
                    </div>
                    
                    @if($pensionScheme->description)
                        <div>
                            <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Description</div>
                            <div style="font-size: 0.88rem;">{{ $pensionScheme->description }}</div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="stat-card stat-blue">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-label">Total Enrolled Citizens</div>
                <div class="stat-value">{{ $pensionScheme->citizenPensions->count() }}</div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0"><i class="fas fa-users me-2" style="color: var(--accent);"></i>Enrolled Beneficiaries</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Citizen Name</th>
                                    <th>Aadhaar</th>
                                    <th>Enrollment #</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pensionScheme->citizenPensions as $assignment)
                                    <tr>
                                        <td>
                                            <a href="{{ route('citizens.show', $assignment->citizen) }}" style="font-weight: 600; text-decoration: none; color: var(--primary);">
                                                {{ $assignment->citizen->full_name }}
                                            </a>
                                        </td>
                                        <td style="font-family: monospace;">{{ substr($assignment->citizen->aadhaar_number, 0, 4) }} **** {{ substr($assignment->citizen->aadhaar_number, -4) }}</td>
                                        <td style="font-family: monospace;">{{ $assignment->enrollment_number }}</td>
                                        <td>
                                            <span class="badge-status badge-{{ strtolower($assignment->pension_status) }}">
                                                {{ $assignment->pension_status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4" style="color: var(--text-secondary);">
                                            <i class="fas fa-users-slash fa-2x mb-2 d-block" style="opacity: 0.2;"></i>
                                            No citizens enrolled in this scheme yet
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
