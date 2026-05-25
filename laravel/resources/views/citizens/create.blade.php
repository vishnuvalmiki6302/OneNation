@extends('layouts.admin')

@section('title', 'Register New Citizen - OneID-Pension Portal')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <div>
            <h1>Register New Citizen</h1>
            <p class="page-subtitle">Add a new beneficiary to the OneID Pension System</p>
        </div>
        <a href="{{ route('citizens.index') }}" class="btn-oneid btn-outline-oneid">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="fas fa-user-plus" style="color: var(--accent);"></i>
            <span style="font-size: 1rem;">Citizen Registration Form</span>
        </div>
        <div class="card-body">
            <form action="{{ route('citizens.store') }}" method="POST">
                @csrf

                <h6 class="mb-3 pb-2" style="border-bottom: 1px solid var(--border-light); color: var(--text-secondary); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.08em;">
                    <i class="fas fa-id-card me-2"></i>Identity Information
                </h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                               id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="Enter citizen's full name" required>
                        @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="aadhaar_number" class="form-label">Aadhaar Number (12 digits) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('aadhaar_number') is-invalid @enderror"
                               id="aadhaar_number" name="aadhaar_number" value="{{ old('aadhaar_number') }}"
                               maxlength="12" pattern="[0-9]{12}" placeholder="XXXX XXXX XXXX" required>
                        @error('aadhaar_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="mobile_number" class="form-label">Mobile Number (10 digits) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('mobile_number') is-invalid @enderror"
                               id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}"
                               maxlength="10" pattern="[0-9]{10}" placeholder="98XXXXXXXX" required>
                        @error('mobile_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email_address" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email_address') is-invalid @enderror"
                               id="email_address" name="email_address" value="{{ old('email_address') }}" placeholder="citizen@example.com">
                        @error('email_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <h6 class="mb-3 mt-2 pb-2" style="border-bottom: 1px solid var(--border-light); color: var(--text-secondary); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.08em;">
                    <i class="fas fa-user me-2"></i>Personal Details
                </h6>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                            <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                            <option value="Other" @selected(old('gender') === 'Other')>Other</option>
                        </select>
                        @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                               id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                        @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pension_status" class="form-label">Pension Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('pension_status') is-invalid @enderror" id="pension_status" name="pension_status" required>
                            <option value="None" @selected(old('pension_status', 'None') === 'None')>None</option>
                            <option value="Pending" @selected(old('pension_status') === 'Pending')>Pending</option>
                            <option value="Active" @selected(old('pension_status') === 'Active')>Active</option>
                        </select>
                        @error('pension_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <h6 class="mb-3 mt-2 pb-2" style="border-bottom: 1px solid var(--border-light); color: var(--text-secondary); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.08em;">
                    <i class="fas fa-map-marker-alt me-2"></i>Address Details
                </h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                        <select class="form-select @error('state') is-invalid @enderror" id="state" name="state" required>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state }}" @selected(old('state') === $state)>{{ $state }}</option>
                            @endforeach
                        </select>
                        @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('district') is-invalid @enderror"
                               id="district" name="district" value="{{ old('district') }}" placeholder="Enter district" required>
                        @error('district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="full_address" class="form-label">Full Address <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('full_address') is-invalid @enderror"
                              id="full_address" name="full_address" rows="3" placeholder="Enter complete address" required>{{ old('full_address') }}</textarea>
                    @error('full_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-oneid btn-primary-oneid">
                        <i class="fas fa-save"></i> Register Citizen
                    </button>
                    <a href="{{ route('citizens.index') }}" class="btn-oneid btn-outline-oneid">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
