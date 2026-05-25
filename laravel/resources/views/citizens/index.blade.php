@extends('layouts.admin')

@section('title', 'Beneficiary Management - OneID-Pension Portal')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1>Beneficiary Management</h1>
            <p class="page-subtitle">Oversee and verify citizen pension profiles with real-time Aadhaar integration</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('citizens.create') }}" class="btn-oneid btn-primary-oneid">
                <i class="fas fa-user-plus"></i> Register Citizen
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card stat-blue">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-label">Total Beneficiaries</div>
                <div class="stat-value">{{ number_format($citizens->total()) }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-green">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-label">Active Pensions</div>
                <div class="stat-value">{{ \App\Models\Citizen::where('pension_status', 'Active')->count() }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-orange">
                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-label">Pending Verification</div>
                <div class="stat-value">{{ \App\Models\Citizen::where('pension_status', 'Pending')->count() }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-purple">
                <div class="stat-icon"><i class="fas fa-id-card"></i></div>
                <div class="stat-label">No Pension</div>
                <div class="stat-value">{{ \App\Models\Citizen::where('pension_status', 'None')->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Citizens Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Citizen Name</th>
                        <th>OneID / Aadhaar</th>
                        <th>Mobile</th>
                        <th>State</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($citizens as $citizen)
                        <tr>
                            <td>
                                <div style="font-weight: 600;">{{ $citizen->full_name }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $citizen->district }}, {{ $citizen->state }}</div>
                            </td>
                            <td>
                                <span style="font-family: monospace; font-size: 0.82rem;">
                                    {{ substr($citizen->aadhaar_number, 0, 4) }} {{ substr($citizen->aadhaar_number, 4, 4) }} {{ substr($citizen->aadhaar_number, 8, 4) }}
                                </span>
                            </td>
                            <td>{{ $citizen->mobile_number }}</td>
                            <td>{{ $citizen->state }}</td>
                            <td>{{ $citizen->gender }}</td>
                            <td>
                                <span class="badge-status badge-{{ strtolower($citizen->pension_status) }}">
                                    {{ $citizen->pension_status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('citizens.show', $citizen) }}" class="btn-icon" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('citizens.edit', $citizen) }}" class="btn-icon" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ route('citizens.destroy', $citizen) }}" onsubmit="return confirm('Delete this citizen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5" style="color: var(--text-secondary);">
                                <i class="fas fa-users fa-3x mb-3 d-block" style="opacity: 0.2;"></i>
                                <p class="mb-2">No citizens registered yet</p>
                                <a href="{{ route('citizens.create') }}" class="btn-oneid btn-primary-oneid">
                                    <i class="fas fa-plus"></i> Register First Citizen
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($citizens->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div style="font-size: 0.82rem; color: var(--text-secondary);">
                Showing {{ $citizens->firstItem() }}-{{ $citizens->lastItem() }} of {{ number_format($citizens->total()) }} results
            </div>
            {{ $citizens->links() }}
        </div>
    @endif
</div>
@endsection
