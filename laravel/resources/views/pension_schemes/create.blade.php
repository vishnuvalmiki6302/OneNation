@extends('layouts.admin')

@section('title', 'Create Pension Scheme - OneID-Pension Portal')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <div>
            <h1>Create Pension Scheme</h1>
            <p class="page-subtitle">Define a new pension program</p>
        </div>
        <a href="{{ route('pension-schemes.index') }}" class="btn-oneid btn-outline-oneid">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="fas fa-plus-circle" style="color: var(--success);"></i>
            <span style="font-size: 1rem;">Scheme Details Form</span>
        </div>
        <div class="card-body">
            <form action="{{ route('pension-schemes.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="scheme_name" class="form-label">Scheme Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('scheme_name') is-invalid @enderror"
                               id="scheme_name" name="scheme_name" value="{{ old('scheme_name') }}" required>
                        @error('scheme_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="scheme_code" class="form-label">Scheme Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('scheme_code') is-invalid @enderror"
                               id="scheme_code" name="scheme_code" value="{{ old('scheme_code') }}" placeholder="e.g. NPS-2024" required>
                        @error('scheme_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="scheme_type" class="form-label">Scheme Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('scheme_type') is-invalid @enderror" id="scheme_type" name="scheme_type" required>
                            <option value="">Select Type</option>
                            <option value="Social Security" @selected(old('scheme_type') === 'Social Security')>Social Security</option>
                            <option value="Healthcare" @selected(old('scheme_type') === 'Healthcare')>Healthcare</option>
                            <option value="Disability" @selected(old('scheme_type') === 'Disability')>Disability</option>
                            <option value="Old Age" @selected(old('scheme_type') === 'Old Age')>Old Age</option>
                            <option value="Other" @selected(old('scheme_type') === 'Other')>Other</option>
                        </select>
                        @error('scheme_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="provider_type" class="form-label">Provider Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('provider_type') is-invalid @enderror" id="provider_type" name="provider_type" required>
                            <option value="">Select Provider</option>
                            <option value="Government" @selected(old('provider_type') === 'Government')>Government</option>
                            <option value="Private" @selected(old('provider_type') === 'Private')>Private</option>
                            <option value="NGO" @selected(old('provider_type') === 'NGO')>NGO</option>
                        </select>
                        @error('provider_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="monthly_benefit_amount" class="form-label">Monthly Benefit Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('monthly_benefit_amount') is-invalid @enderror"
                               id="monthly_benefit_amount" name="monthly_benefit_amount" value="{{ old('monthly_benefit_amount') }}" required>
                        @error('monthly_benefit_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Draft" @selected(old('status', 'Draft') === 'Draft')>Draft</option>
                            <option value="Active" @selected(old('status') === 'Active')>Active</option>
                            <option value="Inactive" @selected(old('status') === 'Inactive')>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="eligibility_criteria" class="form-label">Eligibility Criteria <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('eligibility_criteria') is-invalid @enderror"
                              id="eligibility_criteria" name="eligibility_criteria" rows="3" required>{{ old('eligibility_criteria') }}</textarea>
                    @error('eligibility_criteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-oneid btn-success-oneid">
                        <i class="fas fa-save"></i> Save Scheme
                    </button>
                    <a href="{{ route('pension-schemes.index') }}" class="btn-oneid btn-outline-oneid">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
