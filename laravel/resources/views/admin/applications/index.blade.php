@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1>Pending Applications</h1>
        <div class="page-subtitle">Review and verify pension scheme applications from citizens.</div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive table-container">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Enrollment No.</th>
                        <th>Citizen Details</th>
                        <th>Scheme</th>
                        <th>Applied On</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                    <tr>
                        <td class="fw-bold">{{ $app->enrollment_number }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $app->citizen->full_name }}</div>
                            <div class="small text-secondary">Aadhaar: {{ $app->citizen->aadhaar_number }}</div>
                        </td>
                        <td>
                            <div class="text-primary fw-medium">{{ $app->pensionScheme->scheme_name }}</div>
                            <div class="small text-success">₹{{ number_format($app->monthly_benefit_amount, 2) }}/mo</div>
                        </td>
                        <td>
                            {{ $app->created_at->format('d M Y') }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('applications.show', $app->id) }}" class="btn btn-sm btn-primary-oneid fw-bold">
                                <i class="fas fa-search me-1"></i> Review Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-clipboard-check text-secondary mb-3" style="font-size: 2rem;"></i>
                            <h5 class="text-dark">All Caught Up!</h5>
                            <p class="text-secondary mb-0">There are no pending scheme applications to review.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
