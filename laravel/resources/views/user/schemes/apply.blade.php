@extends('layouts.admin')

@section('title', 'Apply for Pension Scheme')

@section('styles')
<style>
    .form-section {
        background: white;
        padding: 30px;
        margin-bottom: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .section-header {
        border-bottom: 3px solid #667eea;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .section-header h3 {
        color: #333;
        margin: 0;
        font-weight: 600;
    }

    .section-header p {
        color: #666;
        font-size: 14px;
        margin: 5px 0 0 0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .form-label .required {
        color: #dc3545;
        font-weight: bold;
    }

    .form-hint {
        font-size: 12px;
        color: #999;
        margin-top: 5px;
    }

    .form-control, .form-select {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px 12px;
        font-size: 14px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .file-upload-wrapper {
        border: 2px dashed #ddd;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .file-upload-wrapper:hover {
        border-color: #667eea;
        background-color: #f9f9f9;
    }

    .conditional-field {
        display: none;
    }

    .conditional-field.show {
        display: block;
    }

    .progress-indicator {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
    }

    .progress-step {
        flex: 1;
        height: 40px;
        background: #f0f0f0;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #999;
        transition: all 0.3s;
    }

    .progress-step.active {
        background: #667eea;
        color: white;
    }

    .progress-step.completed {
        background: #28a745;
        color: white;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .btn-large {
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-submit {
        background: #28a745;
        color: white;
    }

    .btn-draft {
        background: #f0f0f0;
        color: #333;
    }

    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="text-center mb-4">
        <h2 class="mb-2">Apply for {{ $scheme->scheme_name }}</h2>
        <p class="text-muted">Complete the form below to submit your application</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Progress Indicator -->
    <div class="progress-indicator d-none d-md-flex mb-4">
        <div class="progress-step active" id="step-1">1. Personal Info</div>
        <div class="progress-step" id="step-2">2. ID & Address</div>
        <div class="progress-step" id="step-3">3. Employment & Income</div>
        <div class="progress-step" id="step-4">4. Other Info</div>
        <div class="progress-step" id="step-5">5. Review & Submit</div>
    </div>

    <form action="{{ route('citizen.application.store', $scheme->id) }}" method="POST" enctype="multipart/form-data" id="pensionApplicationForm">
        @csrf

        <!-- SECTION 1: PERSONAL INFORMATION -->
        <div class="form-section section-block" id="section-1">
            <div class="section-header">
                <h3><i class="fas fa-user"></i> Personal Information</h3>
                <p>Provide your basic personal details</p>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" class="form-control" name="full_name" value="{{ old('full_name', $citizen->full_name) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Date of Birth <span class="required">*</span></label>
                    <input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth', $citizen->date_of_birth?->format('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label class="form-label">Gender <span class="required">*</span></label>
                    <select class="form-select" name="gender" required>
                        <option value="">Select</option>
                        <option value="Male" @selected(old('gender', $citizen->gender) == 'Male')>Male</option>
                        <option value="Female" @selected(old('gender', $citizen->gender) == 'Female')>Female</option>
                        <option value="Other" @selected(old('gender', $citizen->gender) == 'Other')>Other</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label class="form-label">Marital Status <span class="required">*</span></label>
                    <select class="form-select" name="marital_status" id="marital_status" required onchange="toggleSpouseFields()">
                        <option value="">Select</option>
                        <option value="Single" @selected(old('marital_status') == 'Single')>Single</option>
                        <option value="Married" @selected(old('marital_status') == 'Married')>Married</option>
                        <option value="Divorced" @selected(old('marital_status') == 'Divorced')>Divorced</option>
                        <option value="Widowed" @selected(old('marital_status') == 'Widowed')>Widowed</option>
                        <option value="Prefer not to say" @selected(old('marital_status') == 'Prefer not to say')>Prefer not to say</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label class="form-label">Religion</label>
                    <select class="form-select" name="religion">
                        <option value="">Select</option>
                        <option value="General" @selected(old('religion') == 'General')>General</option>
                        <option value="Hindu" @selected(old('religion') == 'Hindu')>Hindu</option>
                        <option value="Muslim" @selected(old('religion') == 'Muslim')>Muslim</option>
                        <option value="Christian" @selected(old('religion') == 'Christian')>Christian</option>
                        <option value="Sikh" @selected(old('religion') == 'Sikh')>Sikh</option>
                        <option value="Buddhist" @selected(old('religion') == 'Buddhist')>Buddhist</option>
                        <option value="Other" @selected(old('religion') == 'Other')>Other</option>
                    </select>
                </div>
            </div>

            <!-- Spouse Fields (Conditional) -->
            <div id="spouse_fields" class="row conditional-field">
                <div class="col-md-6 form-group">
                    <label class="form-label">Spouse Name <span class="required">*</span></label>
                    <input type="text" class="form-control" name="spouse_name" value="{{ old('spouse_name') }}">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Spouse Aadhaar <span class="required">*</span></label>
                    <input type="text" class="form-control" name="spouse_aadhaar" value="{{ old('spouse_aadhaar') }}" maxlength="12">
                </div>
            </div>

            <div class="button-group">
                <div></div>
                <button type="button" class="btn btn-primary px-4 py-2" onclick="nextSection(2)">Next <i class="fas fa-arrow-right ms-2"></i></button>
            </div>
        </div>

        <!-- SECTION 2: IDENTIFICATION & ADDRESS -->
        <div class="form-section section-block" id="section-2" style="display:none;">
            <div class="section-header">
                <h3><i class="fas fa-id-card"></i> Identification & Address</h3>
                <p>Provide your government IDs and contact details</p>
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label class="form-label">Aadhaar Number <span class="required">*</span></label>
                    <input type="text" class="form-control" name="aadhaar_number" value="{{ old('aadhaar_number', $citizen->aadhaar_number) }}" maxlength="12" required>
                </div>
                <div class="col-md-4 form-group">
                    <label class="form-label">PAN Number</label>
                    <input type="text" class="form-control" name="pan_number" value="{{ old('pan_number') }}">
                </div>
                <div class="col-md-4 form-group">
                    <label class="form-label">Voter ID</label>
                    <input type="text" class="form-control" name="voter_id" value="{{ old('voter_id') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Mobile Number <span class="required">*</span></label>
                    <input type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number', $citizen->mobile_number) }}" maxlength="10" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $citizen->email_address) }}">
                </div>
            </div>

            <h5 class="mt-4 mb-3 border-bottom pb-2">Address Details</h5>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">State <span class="required">*</span></label>
                    <input type="text" class="form-control" name="state" value="{{ old('state', $citizen->state) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">District <span class="required">*</span></label>
                    <input type="text" class="form-control" name="district" value="{{ old('district', $citizen->district) }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">City/Town <span class="required">*</span></label>
                    <input type="text" class="form-control" name="city" value="{{ old('city') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Pincode <span class="required">*</span></label>
                    <input type="text" class="form-control" name="pincode" value="{{ old('pincode') }}" maxlength="6" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Full Address <span class="required">*</span></label>
                <textarea class="form-control" name="full_address" rows="3" required>{{ old('full_address', $citizen->full_address) }}</textarea>
            </div>

            <div class="row mt-4">
                <div class="col-md-6 form-group">
                    <label class="form-label">Aadhaar File Upload (PDF/JPG)</label>
                    <input type="file" class="form-control" name="aadhaar_file" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Address Proof Upload (PDF/JPG)</label>
                    <input type="file" class="form-control" name="address_proof_file" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>

            <div class="button-group">
                <button type="button" class="btn btn-secondary px-4 py-2" onclick="nextSection(1)"><i class="fas fa-arrow-left me-2"></i> Previous</button>
                <button type="button" class="btn btn-primary px-4 py-2" onclick="nextSection(3)">Next <i class="fas fa-arrow-right ms-2"></i></button>
            </div>
        </div>

        <!-- SECTION 3: EMPLOYMENT & INCOME -->
        <div class="form-section section-block" id="section-3" style="display:none;">
            <div class="section-header">
                <h3><i class="fas fa-briefcase"></i> Employment & Income</h3>
                <p>Provide your occupational and financial details</p>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Employment Status <span class="required">*</span></label>
                    <select class="form-select" name="employment_status" id="employment_status" required onchange="toggleEmploymentFields()">
                        <option value="">Select</option>
                        <option value="Employed" @selected(old('employment_status') == 'Employed')>Employed</option>
                        <option value="Self-employed" @selected(old('employment_status') == 'Self-employed')>Self-employed</option>
                        <option value="Unemployed" @selected(old('employment_status') == 'Unemployed')>Unemployed</option>
                        <option value="Retired" @selected(old('employment_status') == 'Retired')>Retired</option>
                        <option value="Student" @selected(old('employment_status') == 'Student')>Student</option>
                        <option value="Homemaker" @selected(old('employment_status') == 'Homemaker')>Homemaker</option>
                        <option value="Other" @selected(old('employment_status') == 'Other')>Other</option>
                    </select>
                </div>
                <div class="col-md-6 form-group conditional-field" id="employment_fields">
                    <label class="form-label">Organization / Occupation Name <span class="required">*</span></label>
                    <input type="text" class="form-control" name="organization_name" value="{{ old('organization_name') }}">
                </div>
            </div>

            <h5 class="mt-4 mb-3 border-bottom pb-2">Financial Details</h5>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Monthly Income (₹) <span class="required">*</span></label>
                    <input type="number" class="form-control" name="monthly_income" value="{{ old('monthly_income') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Total Assets Value (₹)</label>
                    <input type="number" class="form-control" name="total_assets" value="{{ old('total_assets') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Number of Dependents <span class="required">*</span></label>
                    <input type="number" class="form-control" name="number_of_dependents" value="{{ old('number_of_dependents', 0) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Financial Dependents <span class="required">*</span></label>
                    <input type="number" class="form-control" name="financial_dependents" value="{{ old('financial_dependents', 0) }}" required>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6 form-group">
                    <label class="form-label">Income Certificate Upload (PDF/JPG)</label>
                    <input type="file" class="form-control" name="income_certificate_file" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Bank Statement Upload (PDF/JPG)</label>
                    <input type="file" class="form-control" name="bank_statement_file" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>

            <div class="button-group">
                <button type="button" class="btn btn-secondary px-4 py-2" onclick="nextSection(2)"><i class="fas fa-arrow-left me-2"></i> Previous</button>
                <button type="button" class="btn btn-primary px-4 py-2" onclick="nextSection(4)">Next <i class="fas fa-arrow-right ms-2"></i></button>
            </div>
        </div>

        <!-- SECTION 4: OTHER INFO -->
        <div class="form-section section-block" id="section-4" style="display:none;">
            <div class="section-header">
                <h3><i class="fas fa-heartbeat"></i> Health & Category Information</h3>
                <p>Provide your category, education, and health details</p>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Caste Category <span class="required">*</span></label>
                    <select class="form-select" name="caste_category" id="caste_category" required onchange="toggleCategoryFields()">
                        <option value="">Select</option>
                        <option value="General" @selected(old('caste_category') == 'General')>General</option>
                        <option value="OBC" @selected(old('caste_category') == 'OBC')>OBC</option>
                        <option value="SC" @selected(old('caste_category') == 'SC')>SC</option>
                        <option value="ST" @selected(old('caste_category') == 'ST')>ST</option>
                        <option value="EWS" @selected(old('caste_category') == 'EWS')>EWS</option>
                    </select>
                </div>
                <div class="col-md-6 form-group conditional-field" id="category_certificate_field">
                    <label class="form-label">Category Certificate Upload</label>
                    <input type="file" class="form-control" name="caste_certificate_file" accept=".pdf,.jpg,.png">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Disability Status <span class="required">*</span></label>
                    <select class="form-select" name="disability_status" id="disability_status" required onchange="toggleDisabilityFields()">
                        <option value="No" @selected(old('disability_status') == 'No')>No</option>
                        <option value="Physically disabled" @selected(old('disability_status') == 'Physically disabled')>Physically disabled</option>
                        <option value="Mentally disabled" @selected(old('disability_status') == 'Mentally disabled')>Mentally disabled</option>
                        <option value="Other" @selected(old('disability_status') == 'Other')>Other</option>
                    </select>
                </div>
                <div class="col-md-6 form-group conditional-field" id="disability_certificate_field">
                    <label class="form-label">Disability Certificate Upload</label>
                    <input type="file" class="form-control" name="disability_certificate_file" accept=".pdf,.jpg,.png">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Health Status <span class="required">*</span></label>
                    <select class="form-select" name="health_status" required>
                        <option value="">Select</option>
                        <option value="Good" @selected(old('health_status') == 'Good')>Good</option>
                        <option value="Fair" @selected(old('health_status') == 'Fair')>Fair</option>
                        <option value="Poor" @selected(old('health_status') == 'Poor')>Poor</option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Health Insurance Status <span class="required">*</span></label>
                    <select class="form-select" name="health_insurance_status" required>
                        <option value="">Select</option>
                        <option value="Government scheme" @selected(old('health_insurance_status') == 'Government scheme')>Government scheme</option>
                        <option value="Private insurance" @selected(old('health_insurance_status') == 'Private insurance')>Private insurance</option>
                        <option value="No insurance" @selected(old('health_insurance_status') == 'No insurance')>No insurance</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Highest Education Level <span class="required">*</span></label>
                    <select class="form-select" name="education_level" required>
                        <option value="">Select</option>
                        <option value="Illiterate" @selected(old('education_level') == 'Illiterate')>Illiterate</option>
                        <option value="Below 5th" @selected(old('education_level') == 'Below 5th')>Below 5th</option>
                        <option value="5-8th" @selected(old('education_level') == '5-8th')>5-8th</option>
                        <option value="9-10th" @selected(old('education_level') == '9-10th')>9-10th</option>
                        <option value="11-12th" @selected(old('education_level') == '11-12th')>11-12th</option>
                        <option value="Bachelor" @selected(old('education_level') == 'Bachelor')>Bachelor's</option>
                        <option value="Master" @selected(old('education_level') == 'Master')>Master's</option>
                        <option value="PhD" @selected(old('education_level') == 'PhD')>PhD</option>
                        <option value="Other" @selected(old('education_level') == 'Other')>Other</option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Currently Studying? <span class="required">*</span></label>
                    <select class="form-select" name="currently_studying" required>
                        <option value="No" @selected(old('currently_studying') == 'No')>No</option>
                        <option value="Yes" @selected(old('currently_studying') == 'Yes')>Yes</option>
                    </select>
                </div>
            </div>

            <div class="button-group">
                <button type="button" class="btn btn-secondary px-4 py-2" onclick="nextSection(3)"><i class="fas fa-arrow-left me-2"></i> Previous</button>
                <button type="button" class="btn btn-primary px-4 py-2" onclick="nextSection(5)">Next <i class="fas fa-arrow-right ms-2"></i></button>
            </div>
        </div>

        <!-- SECTION 5: REVIEW -->
        <div class="form-section section-block" id="section-5" style="display:none;">
            <div class="section-header">
                <h3><i class="fas fa-check-double"></i> Review & Submit</h3>
                <p>Verify your details and agree to the terms</p>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> Please ensure all details and documents provided are accurate. Providing false information may lead to rejection or legal action.
            </div>

            <div class="form-check mb-3 mt-4">
                <input class="form-check-input" type="checkbox" name="data_verification" id="data_verification" value="1" required>
                <label class="form-check-label" for="data_verification">
                    I declare that all information provided in this application is true and correct to the best of my knowledge.
                </label>
            </div>
            
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="consent" id="consent" value="1" required>
                <label class="form-check-label" for="consent">
                    I consent to the processing of my personal data for the purpose of evaluating my eligibility for the {{ $scheme->scheme_name }}.
                </label>
            </div>

            <div class="button-group border-top pt-4">
                <button type="button" class="btn btn-secondary px-4 py-2" onclick="nextSection(4)"><i class="fas fa-arrow-left me-2"></i> Previous</button>
                <button type="submit" class="btn btn-success px-5 py-2 fw-bold"><i class="fas fa-paper-plane me-2"></i> Submit Application</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function nextSection(step) {
        // Hide all sections
        document.querySelectorAll('.section-block').forEach(el => el.style.display = 'none');
        // Show target section
        document.getElementById('section-' + step).style.display = 'block';

        // Update progress indicators
        document.querySelectorAll('.progress-step').forEach(el => {
            el.classList.remove('active');
        });
        
        for (let i = 1; i <= 5; i++) {
            let stepEl = document.getElementById('step-' + i);
            if (i < step) {
                stepEl.classList.add('completed');
                stepEl.classList.remove('active');
            } else if (i === step) {
                stepEl.classList.add('active');
                stepEl.classList.remove('completed');
            } else {
                stepEl.classList.remove('completed');
                stepEl.classList.remove('active');
            }
        }
        window.scrollTo(0, 0);
    }

    function toggleSpouseFields() {
        const status = document.getElementById('marital_status').value;
        const fields = document.getElementById('spouse_fields');
        if (status === 'Married') {
            fields.classList.add('show');
            fields.querySelectorAll('input').forEach(el => el.setAttribute('required', 'required'));
        } else {
            fields.classList.remove('show');
            fields.querySelectorAll('input').forEach(el => el.removeAttribute('required'));
        }
    }

    function toggleEmploymentFields() {
        const status = document.getElementById('employment_status').value;
        const fields = document.getElementById('employment_fields');
        if (status === 'Employed') {
            fields.classList.add('show');
            fields.querySelector('input').setAttribute('required', 'required');
        } else {
            fields.classList.remove('show');
            fields.querySelector('input').removeAttribute('required');
        }
    }

    function toggleCategoryFields() {
        const status = document.getElementById('caste_category').value;
        const fields = document.getElementById('category_certificate_field');
        if (status !== 'General' && status !== '') {
            fields.classList.add('show');
        } else {
            fields.classList.remove('show');
        }
    }

    function toggleDisabilityFields() {
        const status = document.getElementById('disability_status').value;
        const fields = document.getElementById('disability_certificate_field');
        if (status !== 'No') {
            fields.classList.add('show');
        } else {
            fields.classList.remove('show');
        }
    }

    // Run on load in case of validation errors
    document.addEventListener('DOMContentLoaded', function() {
        toggleSpouseFields();
        toggleEmploymentFields();
        toggleCategoryFields();
        toggleDisabilityFields();
    });
</script>
@endsection
