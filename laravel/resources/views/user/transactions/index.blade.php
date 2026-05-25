@extends('layouts.admin')

@section('title', 'Payment History')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('dashboard') }}" class="text-secondary text-decoration-none mb-2 d-inline-block">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
        <h1>Payment History</h1>
        <div class="page-subtitle">View your recent pension disbursements</div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white pt-4 pb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-history text-success me-2"></i> Recent Transactions</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Reference ID</th>
                        <th>Scheme</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                        <tr>
                            <td class="ps-4 fw-medium text-dark">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}</td>
                            <td><span class="font-monospace text-secondary">{{ $tx->transaction_reference }}</span></td>
                            <td>
                                <div class="fw-bold">{{ $tx->pensionScheme->scheme_name ?? 'N/A' }}</div>
                            </td>
                            <td class="fw-bold text-success">₹{{ number_format($tx->amount, 2) }}</td>
                            <td>
                                @if($tx->status === 'Success')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><i class="fas fa-check-circle me-1"></i> Success</span>
                                @elseif($tx->status === 'Pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill"><i class="fas fa-clock me-1"></i> Pending</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill"><i class="fas fa-times-circle me-1"></i> Failed</span>
                                @endif
                            </td>
                            <td class="text-secondary small">{{ $tx->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                <i class="fas fa-file-invoice-dollar fa-3x mb-3 opacity-25"></i>
                                <h5>No Transactions Found</h5>
                                <p>You have no payment history available at this time.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
