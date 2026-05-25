@extends('layouts.admin')

@section('title', 'Assignment Details - OneID-Pension Portal')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <div>
            <h1>Assignment Details</h1>
            <p class="page-subtitle">Enrollment #{{ $citizenPension->enrollment_number }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('citizen-pensions.edit', $citizenPension) }}" class="btn-oneid btn-accent-oneid">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('citizen-pensions.index') }}" class="btn-oneid btn-outline-oneid">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Beneficiary Info -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex align-items-center gap-2">
                    <i class="fas fa-user" style="color: var(--primary);"></i>
                    <h6 class="mb-0">Beneficiary Details</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary-light); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700;">
                            {{ strtoupper(substr($citizenPension->citizen->full_name, 0, 1)) }}
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $citizenPension->citizen->full_name }}</h5>
                            <a href="{{ route('citizens.show', $citizenPension->citizen) }}" style="font-size: 0.82rem; color: var(--accent); text-decoration: none;">View Full Profile <i class="fas fa-external-link-alt ms-1"></i></a>
                        </div>
                    </div>

                    <table class="table table-borderless table-sm m-0">
                        <tbody>
                            <tr>
                                <td style="width: 120px; color: var(--text-secondary); font-size: 0.82rem;">Aadhaar</td>
                                <td style="font-family: monospace; font-weight: 600;">{{ substr($citizenPension->citizen->aadhaar_number, 0, 4) }} **** {{ substr($citizenPension->citizen->aadhaar_number, -4) }}</td>
                            </tr>
                            <tr>
                                <td style="color: var(--text-secondary); font-size: 0.82rem;">Mobile</td>
                                <td>{{ $citizenPension->citizen->mobile_number }}</td>
                            </tr>
                            <tr>
                                <td style="color: var(--text-secondary); font-size: 0.82rem;">Address</td>
                                <td>{{ $citizenPension->citizen->district }}, {{ $citizenPension->citizen->state }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Scheme Info -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex align-items-center gap-2">
                    <i class="fas fa-file-contract" style="color: var(--success);"></i>
                    <h6 class="mb-0">Scheme Information</h6>
                </div>
                <div class="card-body">
                    <h5 class="mb-1">{{ $citizenPension->pensionScheme->scheme_name }}</h5>
                    <div class="mb-4 d-flex gap-2">
                        <span class="badge" style="background: var(--surface); color: var(--text-primary); border: 1px solid var(--border-light);">{{ $citizenPension->pensionScheme->scheme_type }}</span>
                        <span class="badge" style="background: var(--surface); color: var(--text-primary); border: 1px solid var(--border-light);">{{ $citizenPension->pensionScheme->scheme_code }}</span>
                    </div>

                    <table class="table table-borderless table-sm m-0">
                        <tbody>
                            <tr>
                                <td style="width: 120px; color: var(--text-secondary); font-size: 0.82rem;">Provider</td>
                                <td>{{ $citizenPension->pensionScheme->provider_type }}</td>
                            </tr>
                            <tr>
                                <td style="color: var(--text-secondary); font-size: 0.82rem;">Scheme Base</td>
                                <td>₹{{ number_format($citizenPension->pensionScheme->monthly_benefit_amount, 2) }}/month</td>
                            </tr>
                            <tr>
                                <td style="color: var(--text-secondary); font-size: 0.82rem;">Scheme Status</td>
                                <td>
                                    <span class="badge-status badge-{{ strtolower($citizenPension->pensionScheme->status) }} py-1">
                                        {{ $citizenPension->pensionScheme->status }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Assignment Details -->
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent d-flex align-items-center gap-2">
                    <i class="fas fa-info-circle" style="color: var(--info);"></i>
                    <h6 class="mb-0">Disbursement & Status Details</h6>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Current Status</div>
                            <span class="badge-status badge-{{ strtolower($citizenPension->pension_status) }}">
                                {{ $citizenPension->pension_status }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Start Date</div>
                            <div style="font-weight: 600;">{{ $citizenPension->pension_start_date->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-3">
                            <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Monthly Disbursement</div>
                            <div style="font-weight: 700; font-size: 1.25rem; color: var(--primary);">₹{{ number_format($citizenPension->monthly_benefit_amount, 2) }}</div>
                        </div>
                        <div class="col-md-3">
                            <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Annual Benefit</div>
                            <div style="font-weight: 600;">₹{{ number_format($citizenPension->annual_benefit, 2) }}</div>
                        </div>
                    </div>

                    @if($citizenPension->notes)
                        <hr class="my-4 border-light">
                        <div>
                            <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px;">Internal Notes</div>
                            <div style="background: rgba(2, 119, 189, 0.05); border-left: 3px solid var(--info); padding: 12px 16px; border-radius: 0 var(--radius-sm) var(--radius-sm) 0; font-size: 0.88rem;">
                                {{ $citizenPension->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
