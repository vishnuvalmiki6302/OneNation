@extends('layouts.admin')

@section('title', 'Dashboard - OneID-Pension Portal')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1>System Overview</h1>
            <p class="page-subtitle">Central Administration Hub</p>
        </div>
        <span class="badge-status badge-active" style="font-size: 0.78rem; padding: 6px 16px;">
            <i class="fas fa-circle" style="font-size: 6px;"></i> LIVE UPDATES
        </span>
    </div>

    <!-- Statistics Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-blue">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-label">Total Beneficiaries</div>
                <div class="stat-value">{{ number_format($totalCitizens) }}</div>
                <div class="stat-meta">Registered in system</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-green">
                <div class="stat-icon"><i class="fas fa-file-contract"></i></div>
                <div class="stat-label">Active Schemes</div>
                <div class="stat-value">{{ $activeSchemes }}</div>
                <div class="stat-meta">Running programs</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-orange">
                <div class="stat-icon"><i class="fas fa-clone"></i></div>
                <div class="stat-label">Duplicates Detected</div>
                <div class="stat-value">{{ $duplicateRecords }}</div>
                @if($duplicateRecords > 0)
                    <div class="stat-meta" style="color: var(--danger);"><i class="fas fa-exclamation-triangle"></i> High Risk</div>
                @else
                    <div class="stat-meta" style="color: var(--success);">All Clear</div>
                @endif
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-purple">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-label">Active Assignments</div>
                <div class="stat-value">{{ number_format($activeAssignments) }}</div>
                <div class="stat-meta">Currently active</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-blue">
                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-label">Pending Verifications</div>
                <div class="stat-value">{{ number_format($pendingAssignments) }}</div>
                <div class="stat-meta">Awaiting review</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-red">
                <div class="stat-icon"><i class="fas fa-rupee-sign"></i></div>
                <div class="stat-label">Monthly Disbursal</div>
                <div class="stat-value">₹{{ number_format($totalBenefitsPaid, 0) }}</div>
                <div class="stat-meta">Active pensions</div>
            </div>
        </div>
    </div>

    <!-- Main Content: Two columns -->
    <div class="row g-4 mb-4">
        <!-- Recent Citizens Table -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0" style="font-size: 1rem;"><i class="fas fa-users me-2" style="color: var(--accent);"></i>Recent Citizens</h6>
                    <a href="{{ route('citizens.index') }}" class="btn-oneid btn-outline-oneid" style="padding: 4px 12px; font-size: 0.78rem;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Citizen Name</th>
                                    <th>Aadhaar</th>
                                    <th>State</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCitizens as $citizen)
                                    <tr>
                                        <td>
                                            <div style="font-weight: 600;">{{ $citizen->full_name }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $citizen->mobile_number }}</div>
                                        </td>
                                        <td style="font-family: monospace; font-size: 0.82rem;">
                                            {{ substr($citizen->aadhaar_number, 0, 4) }} **** {{ substr($citizen->aadhaar_number, -4) }}
                                        </td>
                                        <td>{{ $citizen->state }}</td>
                                        <td>
                                            <span class="badge-status badge-{{ strtolower($citizen->pension_status) }}">
                                                {{ $citizen->pension_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('citizens.show', $citizen) }}" class="btn-icon" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4" style="color: var(--text-secondary);">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block" style="opacity: 0.3;"></i>
                                            No citizens registered yet
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Pension Schemes -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0" style="font-size: 1rem;"><i class="fas fa-file-contract me-2" style="color: var(--success);"></i>Top Pension Schemes</h6>
                    <a href="{{ route('pension-schemes.index') }}" class="btn-oneid btn-outline-oneid" style="padding: 4px 12px; font-size: 0.78rem;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Scheme Name</th>
                                    <th>Code</th>
                                    <th>Enrollments</th>
                                    <th>Benefit/mo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topSchemes as $scheme)
                                    <tr>
                                        <td style="font-weight: 600;">{{ $scheme->scheme_name }}</td>
                                        <td>
                                            <span style="background: var(--surface); padding: 2px 8px; border-radius: 4px; font-size: 0.78rem; font-family: monospace;">
                                                {{ $scheme->scheme_code }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary rounded-pill">{{ $scheme->citizen_pensions_count }}</span>
                                        </td>
                                        <td style="font-weight: 600;">₹{{ number_format($scheme->monthly_benefit_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4" style="color: var(--text-secondary);">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block" style="opacity: 0.3;"></i>
                                            No schemes available
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

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0" style="font-size: 1rem;"><i class="fas fa-bolt me-2" style="color: var(--warning);"></i>Quick Actions</h6>
        </div>
        <div class="card-body d-flex flex-wrap gap-3">
            <a href="{{ route('citizens.create') }}" class="btn-oneid btn-primary-oneid">
                <i class="fas fa-user-plus"></i> Register Citizen
            </a>
            <a href="{{ route('pension-schemes.create') }}" class="btn-oneid btn-success-oneid">
                <i class="fas fa-plus-circle"></i> Create Scheme
            </a>
            <a href="{{ route('citizen-pensions.create') }}" class="btn-oneid btn-warning-oneid">
                <i class="fas fa-link"></i> Assign Pension
            </a>
            <form method="POST" action="{{ route('duplicate-detection.scan') }}" class="d-inline" onsubmit="return confirm('Run a full duplicate scan? This may take a moment.')">
                @csrf
                <button type="submit" class="btn-oneid btn-danger-oneid">
                    <i class="fas fa-search"></i> Run Batch Scan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
