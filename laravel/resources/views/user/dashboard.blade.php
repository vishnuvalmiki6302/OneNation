@extends('layouts.admin')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white border-0 shadow-lg">
            <div class="card-body p-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h2 class="display-5 fw-bold mb-3" style="color: white;">Welcome back, {{ auth()->user()->name }}!</h2>
                        <p class="lead mb-4 opacity-75">Access your pension portal, view your assignments, and track your benefits.</p>
                        @if(auth()->user()->citizen)
                        <button class="btn btn-light btn-lg text-primary fw-bold px-4 hover-shadow" data-bs-toggle="modal" data-bs-target="#aadhaarModal">
                            <i class="fas fa-id-card me-2"></i> View Digital Aadhaar
                        </button>
                        @else
                        <a href="{{ route('profile.create') }}" class="btn btn-light btn-lg text-primary fw-bold px-4">
                            <i class="fas fa-user-plus me-2"></i> Complete Profile
                        </a>
                        @endif
                    </div>
                    <div class="col-lg-4 text-center d-none d-lg-block">
                        <i class="fas fa-user-shield" style="font-size: 8rem; opacity: 0.2;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Pension Status Card -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Pension Status</span>
                <i class="fas fa-chart-pie text-secondary"></i>
            </div>
            <div class="card-body text-center d-flex flex-column justify-content-center py-5">
                @php
                    $activePensions = $user->citizen->pensionAssignments()->where('pension_status', 'Active')->get();
                    $pendingPensions = $user->citizen->pensionAssignments()->where('pension_status', 'Pending')->get();
                @endphp

                @if($activePensions->count() > 0)
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem; opacity: 0.8;"></i>
                    </div>
                    <h3 class="fw-bold mb-2 text-success">Active</h3>
                    <p class="text-secondary mb-2">You have {{ $activePensions->count() }} active pension(s).</p>
                    <div class="text-start mt-3">
                        @foreach($activePensions as $pension)
                            <div class="border rounded p-2 mb-2 bg-light">
                                <div class="fw-bold text-dark">{{ $pension->pensionScheme->scheme_name }}</div>
                                <div class="small text-success">₹{{ number_format($pension->monthly_benefit_amount, 2) }}/mo</div>
                            </div>
                        @endforeach
                    </div>
                @elseif($pendingPensions->count() > 0)
                    <div class="mb-4">
                        <i class="fas fa-hourglass-half text-warning" style="font-size: 4rem; opacity: 0.8;"></i>
                    </div>
                    <h3 class="fw-bold mb-2 text-warning">Pending Review</h3>
                    <p class="text-secondary mb-0">Your application is currently being verified by an administrator.</p>
                @else
                    <div class="mb-4">
                        <i class="fas fa-clock text-secondary" style="font-size: 4rem; opacity: 0.5;"></i>
                    </div>
                    <h3 class="fw-bold mb-2">No Active Pension</h3>
                    <p class="text-secondary mb-0">You have not applied for any pension schemes yet. Visit the schemes page to apply.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions Card -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                Quick Actions
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('user.schemes.index') }}" class="text-decoration-none">
                            <div class="stat-card border border-primary border-opacity-25 bg-primary bg-opacity-10 h-100 p-4 rounded-3 text-center transition-all hover-shadow">
                                <i class="fas fa-file-invoice-dollar text-primary mb-3" style="font-size: 2.5rem;"></i>
                                <h5 class="fw-bold text-dark mb-1">Apply for Pension</h5>
                                <p class="text-secondary small mb-0">Start a new scheme application</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="text-decoration-none">
                            <div class="stat-card border border-success border-opacity-25 bg-success bg-opacity-10 h-100 p-4 rounded-3 text-center transition-all hover-shadow">
                                <i class="fas fa-history text-success mb-3" style="font-size: 2.5rem;"></i>
                                <h5 class="fw-bold text-dark mb-1">Payment History</h5>
                                <p class="text-secondary small mb-0">View recent disbursements</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="text-decoration-none">
                            <div class="stat-card border border-info border-opacity-25 bg-info bg-opacity-10 h-100 p-4 rounded-3 text-center transition-all hover-shadow">
                                <i class="fas fa-headset text-info mb-3" style="font-size: 2.5rem;"></i>
                                <h5 class="fw-bold text-dark mb-1">Support Desk</h5>
                                <p class="text-secondary small mb-0">Raise a ticket for assistance</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('profile.create') }}" class="text-decoration-none">
                            <div class="stat-card border border-warning border-opacity-25 bg-warning bg-opacity-10 h-100 p-4 rounded-3 text-center transition-all hover-shadow">
                                <i class="fas fa-user-edit text-warning mb-3" style="font-size: 2.5rem;"></i>
                                <h5 class="fw-bold text-dark mb-1">Update Profile</h5>
                                <p class="text-secondary small mb-0">Manage your contact details</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md) !important;
    }
    
    /* Aadhaar Card Styles */
    .aadhaar-wrapper {
        background: url('https://www.transparenttextures.com/patterns/cubes.png'), linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        padding: 24px;
        position: relative;
        overflow: hidden;
        border: 1px solid #dcdcdc;
        width: 100%;
        max-width: 480px;
        margin: 0 auto;
        font-family: 'Inter', sans-serif;
    }

    .aadhaar-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .flag-graphic {
        display: flex;
        flex-direction: column;
        gap: 3px;
        width: 80px;
    }
    .flag-graphic .stripe {
        height: 6px;
        border-radius: 3px;
    }

    .emblem-block {
        text-align: center;
    }
    .emblem-block i {
        font-size: 2rem;
        color: #333;
    }
    .emblem-text {
        font-size: 0.5rem;
        font-weight: 800;
        margin-top: 2px;
        letter-spacing: 0.5px;
    }

    .aadhaar-logo-block {
        text-align: center;
        position: relative;
    }
    .aadhaar-logo-icon {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 40px;
    }
    .aadhaar-logo-icon .fa-sun {
        color: #fbbc05;
        font-size: 2.2rem;
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
    }
    .aadhaar-logo-icon .fa-fingerprint {
        color: #db3a34;
        font-size: 1.5rem;
        position: absolute;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        border-radius: 50%;
        padding: 2px;
    }
    .aadhaar-logo-text {
        color: #db3a34;
        font-weight: 800;
        font-size: 0.75rem;
        margin-top: 2px;
    }

    .govt-text {
        font-size: 1.15rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 24px;
        color: #1a1a1a;
        letter-spacing: 0.5px;
    }

    .card-body-row {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        padding-left: 10px;
    }

    .avatar-box {
        background-color: #e2e8f0;
        border-radius: 8px;
        width: 110px;
        height: 130px;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        overflow: hidden;
        border: 2px solid #cbd5e1;
    }
    .avatar-box i {
        font-size: 7.5rem;
        color: #94a3b8;
        margin-bottom: -10px;
    }

    .details-box {
        flex-grow: 1;
        padding-top: 5px;
    }
    .citizen-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1a1a1a;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .citizen-meta {
        font-size: 0.95rem;
        color: #333;
        font-weight: 500;
        margin-bottom: 2px;
    }

    .aadhaar-number-display {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1a1a1a;
        text-align: center;
        margin-top: 24px;
        margin-bottom: 16px;
        letter-spacing: 3px;
        font-family: 'Courier New', monospace;
    }

    .bottom-divider {
        height: 4px;
        background-color: #b91c1c;
        margin: 0 -24px 12px -24px;
    }

    .my-aadhaar-text {
        text-align: center;
        font-size: 1.25rem;
        font-weight: 800;
        color: #1a1a1a;
        letter-spacing: 1px;
    }
</style>

@if(auth()->user()->citizen)
@push('modals')
<!-- Aadhaar Modal -->
<div class="modal fade" id="aadhaarModal" tabindex="-1" aria-labelledby="aadhaarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background: transparent;">
            
            <div class="modal-header bg-white border-0 rounded-top pb-0" style="padding: 15px 20px;">
                <h5 class="modal-title fw-bold" id="aadhaarModalLabel"><i class="fas fa-id-card text-primary me-2"></i> Digital Identity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body bg-white rounded-bottom" style="padding: 30px 20px;">
                <div class="aadhaar-wrapper">
                    <div class="aadhaar-header-row">
                        <div class="flag-graphic">
                            <div class="stripe" style="background: #ff9933;"></div>
                            <div class="stripe" style="background: #ffffff; border: 1px solid #e2e8f0;"></div>
                            <div class="stripe" style="background: #138808;"></div>
                        </div>
                        <div class="emblem-block">
                            <i class="fas fa-chess-rook"></i>
                            <div class="emblem-text">सत्यमेव जयते</div>
                        </div>
                        <div class="aadhaar-logo-block">
                            <div class="aadhaar-logo-icon">
                                <i class="fas fa-sun"></i>
                                <i class="fas fa-fingerprint"></i>
                            </div>
                            <div class="aadhaar-logo-text">AADHAAR</div>
                        </div>
                    </div>
                    
                    <div class="govt-text">GOVERNMENT OF INDIA</div>
                    
                    <div class="card-body-row">
                        <div class="avatar-box shadow-sm">
                            @if(auth()->user()->citizen->gender === 'Female')
                                <i class="fas fa-user-tie"></i>
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>
                        <div class="details-box">
                            <div class="citizen-name">{{ auth()->user()->citizen->full_name }}</div>
                            <div class="citizen-meta">{{ auth()->user()->citizen->gender }}</div>
                            <div class="citizen-meta">{{ \Carbon\Carbon::parse(auth()->user()->citizen->date_of_birth)->format('d-m-Y') }}</div>
                        </div>
                    </div>
                    
                    <div class="aadhaar-number-display">
                        {{ substr(auth()->user()->citizen->aadhaar_number, 0, 4) }} 
                        {{ substr(auth()->user()->citizen->aadhaar_number, 4, 4) }} 
                        {{ substr(auth()->user()->citizen->aadhaar_number, 8, 4) }}
                    </div>
                    
                    <div class="bottom-divider"></div>
                    <div class="my-aadhaar-text">MY AADHAAR</div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endpush
@endif
@endsection
