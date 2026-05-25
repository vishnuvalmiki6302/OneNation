@extends('layouts.admin')

@section('title', 'Search & Analytics - OneID-Pension Portal')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <div>
            <h1>Search & Analytics</h1>
            <p class="page-subtitle">Global search across citizens, schemes, and assignments</p>
        </div>
    </div>

    <!-- Search Box -->
    <div class="card mb-4">
        <div class="card-body p-4">
            <form action="{{ route('search.index') }}" method="GET" class="d-flex gap-2">
                <div class="flex-grow-1 position-relative">
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                    <input type="text" name="q" class="form-control form-control-lg ps-5" 
                           placeholder="Enter citizen name, Aadhaar, scheme code, or enrollment number..." 
                           value="{{ $query }}" style="border-radius: var(--radius-md);">
                </div>
                <button type="submit" class="btn-oneid btn-primary-oneid px-4" style="border-radius: var(--radius-md);">
                    Search Records
                </button>
            </form>
        </div>
    </div>

    @if($query)
        <h5 class="mb-3">Search Results for "{{ $query }}"</h5>
        
        @if($totalResults > 0)
            <div class="row g-4">
                
                <!-- Citizens Results -->
                @if($results['citizens']->count() > 0)
                <div class="col-12">
                    <div class="card border-primary" style="border-left: 4px solid var(--primary);">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-users text-primary me-2"></i>Citizens Found ({{ $results['citizens']->count() }})</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Citizen Name</th>
                                            <th>Aadhaar</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['citizens'] as $citizen)
                                        <tr>
                                            <td style="font-weight: 600;">{{ $citizen->full_name }}</td>
                                            <td style="font-family: monospace;">{{ substr($citizen->aadhaar_number, 0, 4) }} **** {{ substr($citizen->aadhaar_number, -4) }}</td>
                                            <td>{{ $citizen->mobile_number }}</td>
                                            <td><span class="badge-status badge-{{ strtolower($citizen->pension_status) }}">{{ $citizen->pension_status }}</span></td>
                                            <td><a href="{{ route('citizens.show', $citizen) }}" class="btn-oneid btn-outline-oneid btn-sm py-1 px-2">View</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Assignments Results -->
                @if($results['assignments']->count() > 0)
                <div class="col-12">
                    <div class="card border-warning" style="border-left: 4px solid var(--warning);">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-link text-warning me-2"></i>Pension Assignments Found ({{ $results['assignments']->count() }})</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Enrollment #</th>
                                            <th>Citizen</th>
                                            <th>Scheme</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['assignments'] as $assignment)
                                        <tr>
                                            <td style="font-family: monospace; font-weight: 600;">{{ $assignment->enrollment_number }}</td>
                                            <td>{{ $assignment->citizen->full_name }}</td>
                                            <td>{{ $assignment->pensionScheme->scheme_name }}</td>
                                            <td><span class="badge-status badge-{{ strtolower($assignment->pension_status) }}">{{ $assignment->pension_status }}</span></td>
                                            <td><a href="{{ route('citizen-pensions.show', $assignment) }}" class="btn-oneid btn-outline-oneid btn-sm py-1 px-2">View</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Schemes Results -->
                @if($results['schemes']->count() > 0)
                <div class="col-12">
                    <div class="card border-success" style="border-left: 4px solid var(--success);">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-file-contract text-success me-2"></i>Pension Schemes Found ({{ $results['schemes']->count() }})</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Scheme Name</th>
                                            <th>Code</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['schemes'] as $scheme)
                                        <tr>
                                            <td style="font-weight: 600;">{{ $scheme->scheme_name }}</td>
                                            <td style="font-family: monospace;">{{ $scheme->scheme_code }}</td>
                                            <td>{{ $scheme->scheme_type }}</td>
                                            <td><a href="{{ route('pension-schemes.show', $scheme) }}" class="btn-oneid btn-outline-oneid btn-sm py-1 px-2">View</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        @else
            <!-- No Results -->
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-search fa-3x mb-3 text-secondary" style="opacity: 0.3;"></i>
                    <h4 class="text-secondary">No matching records found</h4>
                    <p class="text-secondary mb-0">Try adjusting your search query or check for typos.</p>
                </div>
            </div>
        @endif
    @else
        <!-- Empty State (No query) -->
        <div class="card bg-transparent border-0 shadow-none">
            <div class="card-body text-center py-5">
                <i class="fas fa-search-plus fa-3x mb-3 text-secondary" style="opacity: 0.2;"></i>
                <h4 class="text-secondary">Global Search Analytics</h4>
                <p class="text-secondary">Enter a search term above to find citizens, schemes, or enrollment records across the system.</p>
            </div>
        </div>
    @endif
</div>
@endsection
