@extends('layouts.admin')

@section('title', 'My Certificates')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('dashboard') }}" class="text-secondary text-decoration-none mb-2 d-inline-block">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
            <h1>My Documents</h1>
            <div class="page-subtitle">Upload and manage your necessary documents</div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Upload Form -->
        <div class="col-lg-4">
            <div class="card h-100 border-primary border-opacity-25 shadow-sm">
                <div class="card-header bg-primary bg-opacity-10 pt-4 pb-3">
                    <h5 class="fw-bold text-primary mb-0"><i class="fas fa-upload me-2"></i> Upload New Document</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.certificates.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Document Type <span
                                    class="text-danger">*</span></label>
                            <select name="document_type" class="form-select bg-light" required>
                                <option value="">Select Type...</option>
                                <option value="Life Certificate (Jeevan Pramaan)">Life Certificate (Jeevan Pramaan)</option>
                                <option value="Income Certificate">Income Certificate</option>
                                <option value="Medical/Disability Certificate">Medical/Disability Certificate</option>
                                <option value="Address Proof">Address Proof</option>
                                <option value="Other">Other Document</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Document Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="document_name" class="form-control bg-light"
                                placeholder="e.g. Life Certificate 2026" required>
                            <div class="form-text">Give your document a clear name.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">File Attachment <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text">Max size: 5MB. Formats: PDF, JPG, PNG.</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3">
                            <i class="fas fa-cloud-upload-alt me-2"></i> Upload Document
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Uploaded Certificates List -->
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white pt-4 pb-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-folder-open text-warning me-2"></i> Your Documents
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Document</th>
                                    <th>Type</th>
                                    <th>Uploaded On</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($certificates as $cert)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $cert->document_name }}</div>
                                        </td>
                                        <td><span
                                                class="badge bg-secondary bg-opacity-10 text-secondary">{{ $cert->document_type }}</span>
                                        </td>
                                        <td class="text-secondary small">{{ $cert->created_at->format('d M Y, h:i A') }}</td>
                                        <td>
                                            @if($cert->status === 'Approved')
                                                <span class="badge bg-success rounded-pill px-3">Approved</span>
                                            @elseif($cert->status === 'Rejected')
                                                <span class="badge bg-danger rounded-pill px-3">Rejected</span>
                                            @else
                                                <span class="badge bg-warning text-dark rounded-pill px-3">Pending Review</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ Storage::url($cert->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-secondary">
                                            <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                            <h5>No Certificates Uploaded</h5>
                                            <p>You haven't uploaded any supporting documents yet.</p>
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
@endsection