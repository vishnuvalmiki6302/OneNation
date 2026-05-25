@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1">Support Tickets</h1>
        <div class="page-subtitle text-secondary">Manage and resolve citizen support queries</div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom pt-4 pb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-headset text-primary me-2"></i> All Tickets</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Ticket #</th>
                        <th>Citizen</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td class="ps-4 font-monospace text-secondary">{{ $ticket->ticket_number }}</td>
                            <td class="fw-bold">{{ $ticket->user->name ?? 'Unknown' }}</td>
                            <td>{{ Str::limit($ticket->subject, 40) }}</td>
                            <td>
                                @if($ticket->status === 'Open')
                                    <span class="badge bg-danger rounded-pill px-3">Open</span>
                                @elseif($ticket->status === 'In Progress')
                                    <span class="badge bg-warning text-dark rounded-pill px-3">In Progress</span>
                                @else
                                    <span class="badge bg-success rounded-pill px-3">Closed</span>
                                @endif
                            </td>
                            <td class="text-secondary small">{{ $ticket->created_at->diffForHumans() }}</td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#replyModal{{ $ticket->id }}">
                                    <i class="fas fa-reply me-1"></i> Review & Reply
                                </button>
                            </td>
                        </tr>

                        <!-- Reply Modal -->
                        <div class="modal fade" id="replyModal{{ $ticket->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title fw-bold text-dark">
                                            Ticket {{ $ticket->ticket_number }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="mb-4">
                                                <h6 class="fw-bold text-dark mb-1">Subject</h6>
                                                <div class="p-3 bg-light rounded text-dark">{{ $ticket->subject }}</div>
                                            </div>

                                            <div class="mb-4">
                                                <h6 class="fw-bold text-dark mb-1">Description from Citizen</h6>
                                                <div class="p-3 bg-light rounded text-dark" style="white-space: pre-wrap;">{{ $ticket->description }}</div>
                                            </div>

                                            @if($ticket->image_path)
                                                <div class="mb-4">
                                                    <h6 class="fw-bold text-dark mb-2">Attached Image</h6>
                                                    <a href="{{ Storage::url($ticket->image_path) }}" target="_blank">
                                                        <img src="{{ Storage::url($ticket->image_path) }}" class="img-thumbnail rounded shadow-sm" style="max-height: 200px;" alt="Attachment">
                                                    </a>
                                                </div>
                                            @endif

                                            @if($ticket->status === 'Closed')
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-success mb-1">Admin Reply (Resolved at {{ \Carbon\Carbon::parse($ticket->resolved_at)->format('d M Y, H:i') }})</h6>
                                                    <div class="p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded text-dark" style="white-space: pre-wrap;">{{ $ticket->admin_reply }}</div>
                                                </div>
                                            @else
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-primary">Your Reply to Citizen <span class="text-danger">*</span></label>
                                                    <textarea name="admin_reply" class="form-control" rows="5" placeholder="Type the resolution or reply here..." required></textarea>
                                                    <div class="form-text">Submitting a reply will automatically resolve and close this ticket.</div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Close</button>
                                            @if($ticket->status !== 'Closed')
                                                <button type="submit" class="btn btn-primary fw-bold"><i class="fas fa-paper-plane me-1"></i> Submit Reply & Close Ticket</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                <i class="fas fa-check-circle fa-3x mb-3 text-success opacity-50"></i>
                                <h5>All Caught Up!</h5>
                                <p>There are no pending support tickets at the moment.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
