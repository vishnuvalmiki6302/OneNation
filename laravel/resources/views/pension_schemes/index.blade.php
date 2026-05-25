@extends('layouts.admin')

@section('title', 'Pension Schemes - OneID-Pension Portal')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <div>
            <h1>Pension Schemes</h1>
            <p class="page-subtitle">Manage available government and private pension programs</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pension-schemes.create') }}" class="btn-oneid btn-success-oneid">
                <i class="fas fa-plus-circle"></i> Create Scheme
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card stat-green">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-label">Active Schemes</div>
                <div class="stat-value">{{ \App\Models\PensionScheme::where('status', 'Active')->count() }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-purple">
                <div class="stat-icon"><i class="fas fa-file-signature"></i></div>
                <div class="stat-label">Draft Schemes</div>
                <div class="stat-value">{{ \App\Models\PensionScheme::where('status', 'Draft')->count() }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-blue">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-label">Total Enrollments</div>
                <div class="stat-value">{{ \App\Models\CitizenPension::count() }}</div>
            </div>
        </div>
    </div>

    <!-- Schemes Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Scheme Details</th>
                        <th>Type / Provider</th>
                        <th>Monthly Benefit</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schemes as $scheme)
                        <tr>
                            <td>
                                <div style="font-weight: 600;">{{ $scheme->scheme_name }}</div>
                                <div style="font-family: monospace; font-size: 0.75rem; color: var(--text-secondary); background: var(--surface); padding: 2px 6px; display: inline-block; border-radius: 4px; margin-top: 4px;">
                                    {{ $scheme->scheme_code }}
                                </div>
                            </td>
                            <td>
                                <div>{{ $scheme->scheme_type }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $scheme->provider_type }}</div>
                            </td>
                            <td style="font-weight: 600;">₹{{ number_format($scheme->monthly_benefit_amount, 2) }}</td>
                            <td>
                                <span class="badge-status badge-{{ strtolower($scheme->status) }}">
                                    {{ $scheme->status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('pension-schemes.show', $scheme) }}" class="btn-icon" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pension-schemes.edit', $scheme) }}" class="btn-icon" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ route('pension-schemes.destroy', $scheme) }}" onsubmit="return confirm('Delete this scheme?')">
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
                            <td colspan="5" class="text-center py-5" style="color: var(--text-secondary);">
                                <i class="fas fa-file-contract fa-3x mb-3 d-block" style="opacity: 0.2;"></i>
                                <p class="mb-2">No pension schemes created yet</p>
                                <a href="{{ route('pension-schemes.create') }}" class="btn-oneid btn-success-oneid">
                                    <i class="fas fa-plus"></i> Create First Scheme
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($schemes->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div style="font-size: 0.82rem; color: var(--text-secondary);">
                Showing {{ $schemes->firstItem() }}-{{ $schemes->lastItem() }} of {{ number_format($schemes->total()) }} results
            </div>
            {{ $schemes->links() }}
        </div>
    @endif
</div>
@endsection
