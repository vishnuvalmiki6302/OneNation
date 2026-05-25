@extends('layouts.admin')

@section('title', 'Assign Pension - OneID-Pension Portal')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <div>
            <h1>Assign Pension</h1>
            <p class="page-subtitle">Enroll a citizen in a pension scheme</p>
        </div>
        <a href="{{ route('citizen-pensions.index') }}" class="btn-oneid btn-outline-oneid">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="fas fa-link" style="color: var(--warning);"></i>
            <span style="font-size: 1rem;">Pension Assignment Form</span>
        </div>
        <div class="card-body">
            <form action="{{ route('citizen-pensions.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="citizen_id" class="form-label">Beneficiary (Citizen) <span class="text-danger">*</span></label>
                        <select class="form-select @error('citizen_id') is-invalid @enderror" id="citizen_id" name="citizen_id" required>
                            <option value="">Select Citizen</option>
                            @foreach($citizens as $citizen)
                                <option value="{{ $citizen->id }}" @selected(old('citizen_id') == $citizen->id)>
                                    {{ $citizen->full_name }} ({{ substr($citizen->aadhaar_number, -4) }})
                                </option>
                            @endforeach
                        </select>
                        @error('citizen_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="pension_scheme_id" class="form-label">Pension Scheme <span class="text-danger">*</span></label>
                        <select class="form-select @error('pension_scheme_id') is-invalid @enderror" id="pension_scheme_id" name="pension_scheme_id" required>
                            <option value="">Select Scheme</option>
                            @foreach($schemes as $scheme)
                                <option value="{{ $scheme->id }}" @selected(old('pension_scheme_id') == $scheme->id)>
                                    {{ $scheme->scheme_name }} (₹{{ $scheme->monthly_benefit_amount }})
                                </option>
                            @endforeach
                        </select>
                        @error('pension_scheme_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="enrollment_number" class="form-label">Enrollment Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('enrollment_number') is-invalid @enderror"
                               id="enrollment_number" name="enrollment_number" value="{{ old('enrollment_number') }}" placeholder="ENR-..." required>
                        @error('enrollment_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pension_start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('pension_start_date') is-invalid @enderror"
                               id="pension_start_date" name="pension_start_date" value="{{ old('pension_start_date') }}" required>
                        @error('pension_start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pension_status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('pension_status') is-invalid @enderror" id="pension_status" name="pension_status" required>
                            <option value="Pending" @selected(old('pension_status', 'Pending') === 'Pending')>Pending</option>
                            <option value="Active" @selected(old('pension_status') === 'Active')>Active</option>
                            <option value="Suspended" @selected(old('pension_status') === 'Suspended')>Suspended</option>
                            <option value="Completed" @selected(old('pension_status') === 'Completed')>Completed</option>
                        </select>
                        @error('pension_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="monthly_benefit_amount" class="form-label">Custom Benefit Amount (₹) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('monthly_benefit_amount') is-invalid @enderror"
                           id="monthly_benefit_amount" name="monthly_benefit_amount" value="{{ old('monthly_benefit_amount') }}" 
                           placeholder="Enter amount or leave default for scheme" required>
                    <div class="form-text">Defaults to scheme's base amount, but can be overridden.</div>
                    @error('monthly_benefit_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="notes" class="form-label">Internal Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror"
                              id="notes" name="notes" rows="3" placeholder="Add any approval notes or remarks">{{ old('notes') }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-oneid btn-warning-oneid">
                        <i class="fas fa-save"></i> Assign Pension
                    </button>
                    <a href="{{ route('citizen-pensions.index') }}" class="btn-oneid btn-outline-oneid">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
