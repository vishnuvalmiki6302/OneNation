@extends('layouts.admin')

@section('title', 'Pension Assignments - OneID-Pension Portal')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <div>
            <h1>Pension Assignments</h1>
            <p class="page-subtitle">Manage citizen enrollments in pension schemes</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('citizen-pensions.create') }}" class="btn-oneid btn-warning-oneid">
                <i class="fas fa-link"></i> Assign Pension
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card stat-blue">
                <div class="stat-icon"><i class="fas fa-file-invoice"></i></div>
                <div class="stat-label">Total Assignments</div>
                <div class="stat-value">{{ number_format($assignments->total()) }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-green">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-label">Active Disbursements</div>
                <div class="stat-value">{{ \App\Models\CitizenPension::where('pension_status', 'Active')->count() }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-orange">
                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-label">Pending Approval</div>
                <div class="stat-value">{{ \App\Models\CitizenPension::where('pension_status', 'Pending')->count() }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-red">
                <div class="stat-icon"><i class="fas fa-ban"></i></div>
                <div class="stat-label">Suspended</div>
                <div class="stat-value">{{ \App\Models\CitizenPension::where('pension_status', 'Suspended')->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Assignments Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Enrollment / Citizen</th>
                        <th>Pension Scheme</th>
                        <th>Start Date</th>
                        <th>Benefit Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $assignment)
                        <tr>
                            <td>
                                <div style="font-family: monospace; font-size: 0.82rem; font-weight: 600;">{{ $assignment->enrollment_number }}</div>
                                <a href="{{ route('citizens.show', $assignment->citizen) }}" style="font-size: 0.85rem; color: var(--primary); text-decoration: none;">
                                    {{ $assignment->citizen->full_name }}
                                </a>
                            </td>
                            <td>
                                <div>{{ $assignment->pensionScheme->scheme_name }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $assignment->pensionScheme->scheme_code }}</div>
                            </td>
                            <td>{{ $assignment->pension_start_date->format('d M Y') }}</td>
                            <td style="font-weight: 600;">₹{{ number_format($assignment->monthly_benefit_amount, 2) }}</td>
                            <td>
                                <span class="badge-status badge-{{ strtolower($assignment->pension_status) }}">
                                    {{ $assignment->pension_status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('citizen-pensions.show', $assignment) }}" class="btn-icon" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('citizen-pensions.edit', $assignment) }}" class="btn-icon" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ route('citizen-pensions.destroy', $assignment) }}" onsubmit="return confirm('Delete this assignment?')">
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
                            <td colspan="6" class="text-center py-5" style="color: var(--text-secondary);">
                                <i class="fas fa-link fa-3x mb-3 d-block" style="opacity: 0.2;"></i>
                                <p class="mb-2">No pension assignments created yet</p>
                                <a href="{{ route('citizen-pensions.create') }}" class="btn-oneid btn-warning-oneid">
                                    <i class="fas fa-plus"></i> Create First Assignment
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($assignments->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div style="font-size: 0.82rem; color: var(--text-secondary);">
                Showing {{ $assignments->firstItem() }}-{{ $assignments->lastItem() }} of {{ number_format($assignments->total()) }} results
            </div>
            {{ $assignments->links() }}
        </div>
    @endif
</div>
@endsection
