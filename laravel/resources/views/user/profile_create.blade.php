@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h3 class="mb-0 text-primary fw-bold">Complete Your Profile</h3>
                <p class="text-secondary mb-0">Please link your Aadhaar and provide your details to apply for schemes.</p>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profile.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Full Name (As per Aadhaar) *</label>
                            <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name', $citizen?->full_name ?? auth()->user()->name) }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Aadhaar Number *</label>
                            <input type="text" name="aadhaar_number" class="form-control @error('aadhaar_number') is-invalid @enderror" placeholder="12-digit number" value="{{ old('aadhaar_number', $citizen?->aadhaar_number) }}" required minlength="12" maxlength="12">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Mobile Number *</label>
                            <input type="text" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" placeholder="10-digit number" value="{{ old('mobile_number', $citizen?->mobile_number) }}" required minlength="10" maxlength="10">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of Birth *</label>
                            <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $citizen?->date_of_birth?->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gender *</label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender', $citizen?->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $citizen?->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $citizen?->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">State *</label>
                            <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state', $citizen?->state) }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">District *</label>
                            <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district', $citizen?->district) }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Full Address *</label>
                            <textarea name="full_address" class="form-control @error('full_address') is-invalid @enderror" rows="3" required>{{ old('full_address', $citizen?->full_address) }}</textarea>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-primary-oneid py-2 fw-bold text-uppercase">
                            Save Profile & Continue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
