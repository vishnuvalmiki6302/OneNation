@extends('layouts.admin')

@section('title', 'Fraud & Duplicate Detection - OneID-Pension Portal')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <div>
            <h1>Fraud & Duplicate Detection</h1>
            <p class="page-subtitle">Reviewing AI-flagged potential duplicate identities within the national pension registry.</p>
        </div>
        <div>
            <form action="{{ route('duplicate-detection.scan') }}" method="POST" onsubmit="return confirm('Initiate full system scan? This may take time.')">
                @csrf
                <button type="submit" class="btn-oneid btn-danger-oneid px-4">
                    <i class="fas fa-search-plus me-2"></i> Run Batch Scan
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Pending Reviews List -->
        <div class="col-lg-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.05em; color: var(--text-secondary); font-weight: 700;">
                    Pending Reviews ({{ $duplicates->total() }})
                </h6>
                <span class="badge bg-danger rounded-pill">High Priority</span>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse($duplicates as $duplicate)
                    <div class="card border-0 shadow-sm" style="border-left: 4px solid var(--danger) !important;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 0.75rem;">{{ number_format($duplicate->match_percentage, 1) }}% Match</span>
                                <span style="font-size: 0.7rem; color: var(--text-secondary);">{{ $duplicate->created_at->diffForHumans() }}</span>
                            </div>
                            <h6 class="mb-1" style="font-weight: 700; font-size: 0.95rem;">
                                {{ $duplicate->originalCitizen->full_name }} <span class="text-secondary fw-normal px-1">vs</span> {{ $duplicate->duplicateCitizen->full_name }}
                            </h6>
                            <div class="mb-2 text-secondary" style="font-size: 0.75rem; font-family: monospace;">
                                ID: *{{ substr($duplicate->originalCitizen->aadhaar_number, -4) }} vs *{{ substr($duplicate->duplicateCitizen->aadhaar_number, -4) }}
                            </div>
                            <div class="d-flex flex-wrap gap-1 mt-2">
                                @foreach(explode(',', $duplicate->match_reason) as $reason)
                                    <span class="badge bg-light text-dark border" style="font-size: 0.65rem; font-weight: 600;">{{ trim($reason) }}</span>
                                @endforeach
                            </div>
                            
                            <!-- Collapse trigger for details -->
                            <button class="btn btn-sm btn-link text-decoration-none w-100 mt-2 p-0 text-primary fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#review-{{ $duplicate->id }}">
                                Review Details <i class="fas fa-chevron-down ms-1" style="font-size: 0.7rem;"></i>
                            </button>

                            <!-- Collapsible Review Form -->
                            <div class="collapse mt-3 pt-3 border-top" id="review-{{ $duplicate->id }}">
                                <div class="row g-2 mb-3" style="font-size: 0.8rem;">
                                    <div class="col-6">
                                        <div class="text-secondary mb-1">Record A (Master)</div>
                                        <div class="fw-semibold">{{ $duplicate->originalCitizen->full_name }}</div>
                                        <div>{{ $duplicate->originalCitizen->date_of_birth->format('d-m-Y') }}</div>
                                        <div class="font-monospace text-secondary">{{ $duplicate->originalCitizen->mobile_number }}</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-secondary mb-1">Record B (Candidate)</div>
                                        <div class="fw-semibold">{{ $duplicate->duplicateCitizen->full_name }}</div>
                                        <div>{{ $duplicate->duplicateCitizen->date_of_birth->format('d-m-Y') }}</div>
                                        <div class="font-monospace text-secondary">{{ $duplicate->duplicateCitizen->mobile_number }}</div>
                                    </div>
                                </div>
                                
                                <form action="{{ route('duplicate-detection.review', $duplicate) }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="text" name="notes" class="form-control form-control-sm" placeholder="Reviewer notes (optional)">
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" name="action" value="merged" class="btn btn-sm btn-primary flex-grow-1 fw-semibold">Merge Records</button>
                                        <button type="submit" name="action" value="dismissed" class="btn btn-sm btn-outline-danger flex-grow-1 fw-semibold">Dismiss</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card border-0 shadow-sm bg-transparent">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-shield-check fa-3x text-success mb-3" style="opacity: 0.5;"></i>
                            <h6 class="text-secondary mb-0">No pending duplicate reviews.</h6>
                        </div>
                    </div>
                @endforelse

                @if($duplicates->hasPages())
                    {{ $duplicates->links() }}
                @endif
            </div>
        </div>

        <!-- Analysis Workspace Simulation (Visual representation of the selected active duplicate) -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 fw-bold">Analysis Workspace</h5>
                        <p class="text-secondary small mb-0">Comparing Record A (Master) vs Record B (Candidate)</p>
                    </div>
                    <div class="text-end">
                        <div class="display-6 fw-bold text-danger mb-0">AI Engine</div>
                        <span class="text-secondary small">System Risk Assessment</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-secondary font-weight-semibold">Field Attribute</th>
                                    <th class="text-secondary font-weight-semibold">Record A (Master)</th>
                                    <th class="text-secondary font-weight-semibold">Record B (Candidate)</th>
                                    <th class="text-secondary font-weight-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">Full Name</td>
                                    <td>Select a record on the left to analyze</td>
                                    <td>---</td>
                                    <td>---</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Date of Birth</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Aadhaar / ID</td>
                                    <td class="font-monospace">---</td>
                                    <td class="font-monospace">---</td>
                                    <td>---</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Phone</td>
                                    <td class="font-monospace">---</td>
                                    <td class="font-monospace">---</td>
                                    <td>---</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Address</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row g-4 mt-2">
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-3 h-100 border">
                                <h6 class="d-flex align-items-center gap-2 text-primary fw-bold mb-3">
                                    <i class="fas fa-brain"></i> AI Reasoning Engine
                                </h6>
                                <p class="small text-secondary mb-0 lh-lg">
                                    Select a record from the pending reviews queue to view the AI engine's detailed analysis and match logic. The system uses fuzzy string matching, Levenshtein distance for names, and weighted scoring for exact identifier matches.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-3 h-100 border">
                                <h6 class="d-flex align-items-center gap-2 text-secondary fw-bold mb-3">
                                    <i class="fas fa-history"></i> Audit Log
                                </h6>
                                <div class="small text-secondary">
                                    <div class="mb-3">
                                        <div class="fw-bold text-dark">System Ready</div>
                                        <div>Waiting for user selection.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
