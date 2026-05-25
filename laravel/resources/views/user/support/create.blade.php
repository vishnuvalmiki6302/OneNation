@extends('layouts.admin')

@section('title', 'Support Desk')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('dashboard') }}" class="text-secondary text-decoration-none mb-2 d-inline-block">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
        <h1>Support Desk</h1>
        <div class="page-subtitle">Raise a query or track your existing support tickets</div>
    </div>
</div>

<div class="row g-4">
    <!-- Ticket Form -->
    <div class="col-lg-5">
        <div class="card h-100 border-info border-opacity-25 shadow-sm">
            <div class="card-header bg-info bg-opacity-10 pt-4 pb-3">
                <h5 class="fw-bold text-info mb-0"><i class="fas fa-paper-plane me-2"></i> Submit a Query</h5>
            </div>
            <div class="card-body p-4">
                <p class="text-secondary small mb-4">Facing issues with payments, scheme applications, or profile updates? Describe your exact problem below.</p>
                
                <form action="{{ route('user.support.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control bg-light" placeholder="e.g. Payment not received for May" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Detailed Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control bg-light" rows="5" placeholder="Explain your exact problem in detail..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Supporting Image (Optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Attach a screenshot of the error if applicable (Max 5MB).</div>
                    </div>

                    <button type="submit" class="btn btn-info text-white w-100 py-3 fw-bold rounded-3">
                        <i class="fas fa-headset me-2"></i> Submit Ticket
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Ticket History -->
    <div class="col-lg-7">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white pt-4 pb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-list-ul text-primary me-2"></i> Your Tickets</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($tickets as $ticket)
                        <div class="list-group-item p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="fw-bold fs-5 text-dark">{{ $ticket->subject }}</div>
                                <div>
                                    @if($ticket->status === 'Closed')
                                        <span class="badge bg-success rounded-pill px-3">Resolved & Closed</span>
                                    @elseif($ticket->status === 'In Progress')
                                        <span class="badge bg-warning text-dark rounded-pill px-3">In Progress</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3">Open</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex gap-3 text-secondary small mb-3">
                                <span><i class="fas fa-hashtag me-1"></i> {{ $ticket->ticket_number }}</span>
                                <span><i class="fas fa-calendar-alt me-1"></i> {{ $ticket->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                            <p class="mb-3 text-secondary">{{ $ticket->description }}</p>
                            
                            @if($ticket->image_path)
                                <div class="mb-3">
                                    <a href="{{ Storage::url($ticket->image_path) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                        <i class="fas fa-image me-1"></i> View Attached Image
                                    </a>
                                </div>
                            @endif

                            @if($ticket->admin_reply)
                                <div class="mt-3 p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded text-dark">
                                    <div class="fw-bold text-success mb-1"><i class="fas fa-user-tie me-1"></i> Admin Response ({{ \Carbon\Carbon::parse($ticket->resolved_at)->format('d M Y, h:i A') }}):</div>
                                    <div style="white-space: pre-wrap;">{{ $ticket->admin_reply }}</div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-5 text-secondary">
                            <i class="fas fa-check-circle fa-3x mb-3 text-success opacity-50"></i>
                            <h5>No Open Tickets</h5>
                            <p>You have not raised any support queries yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
