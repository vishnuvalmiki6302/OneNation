@extends('layouts.admin')

@section('title', $citizen->full_name . ' - Citizen Profile')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <div>
            <h1>{{ $citizen->full_name }}</h1>
            <p class="page-subtitle">Citizen Profile — ID #{{ $citizen->id }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('citizens.edit', $citizen) }}" class="btn-oneid btn-accent-oneid">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('citizens.index') }}" class="btn-oneid btn-outline-oneid">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center" style="padding: 32px 20px;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 2rem; color: white; font-weight: 700;">
                        {{ strtoupper(substr($citizen->full_name, 0, 1)) }}
                    </div>
                    <h5 style="font-weight: 700; margin-bottom: 4px;">{{ $citizen->full_name }}</h5>
                    <p style="color: var(--text-secondary); font-size: 0.85rem;">{{ $citizen->district }}, {{ $citizen->state }}</p>
                    <span class="badge-status badge-{{ strtolower($citizen->pension_status) }}" style="font-size: 0.82rem; padding: 6px 16px;">
                        {{ $citizen->pension_status }}
                    </span>
                </div>
                <div class="card-body" style="border-top: 1px solid var(--border-light);">
                    <div class="mb-3">
                        <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Aadhaar Number</div>
                        <div style="font-family: monospace; font-weight: 600;">{{ substr($citizen->aadhaar_number, 0, 4) }} {{ substr($citizen->aadhaar_number, 4, 4) }} {{ substr($citizen->aadhaar_number, 8, 4) }}</div>
                    </div>
                    <div class="mb-3">
                        <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Mobile</div>
                        <div style="font-weight: 600;">{{ $citizen->mobile_number }}</div>
                    </div>
                    <div class="mb-3">
                        <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Email</div>
                        <div>{{ $citizen->email_address ?? '—' }}</div>
                    </div>
                    <div class="mb-3">
                        <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Gender / Age</div>
                        <div>{{ $citizen->gender }} · {{ $citizen->age }} years</div>
                    </div>
                    <div class="mb-3">
                        <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Date of Birth</div>
                        <div>{{ $citizen->date_of_birth->format('d M Y') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.72rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px;">Address</div>
                        <div>{{ $citizen->full_address }}, {{ $citizen->district }}, {{ $citizen->state }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pension Assignments -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0"><i class="fas fa-money-bill-wave me-2" style="color: var(--accent);"></i>Linked Pension Schemes</h6>
                    <a href="{{ route('citizen-pensions.create') }}" class="btn-oneid btn-accent-oneid" style="padding: 6px 14px; font-size: 0.82rem;">
                        <i class="fas fa-plus"></i> Assign Pension
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Enrollment #</th>
                                    <th>Scheme</th>
                                    <th>Start Date</th>
                                    <th>Monthly Benefit</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($citizen->pensionAssignments as $assignment)
                                    <tr>
                                        <td style="font-family: monospace;">{{ $assignment->enrollment_number }}</td>
                                        <td style="font-weight: 600;">
                                            {{ $assignment->pensionScheme->scheme_name ?? 'N/A' }}
                                            <div style="font-size: 0.72rem; color: var(--text-secondary);">{{ $assignment->pensionScheme->scheme_type ?? '' }}</div>
                                        </td>
                                        <td>{{ $assignment->pension_start_date->format('d M Y') }}</td>
                                        <td style="font-weight: 600;">₹{{ number_format($assignment->monthly_benefit_amount, 2) }}</td>
                                        <td>
                                            <span class="badge-status badge-{{ strtolower($assignment->pension_status) }}">
                                                {{ $assignment->pension_status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4" style="color: var(--text-secondary);">
                                            <i class="fas fa-link-slash fa-2x mb-2 d-block" style="opacity: 0.2;"></i>
                                            No pension schemes linked
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
