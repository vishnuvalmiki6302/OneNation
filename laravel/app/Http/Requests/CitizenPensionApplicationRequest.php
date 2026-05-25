<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CitizenPensionApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Personal Information
            'full_name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z\s]*$/',
            'date_of_birth' => 'required|date|before:today|after:1920-01-01',
            'gender' => 'required|in:Male,Female,Other',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed,Prefer not to say',
            'religion' => 'nullable|in:General,Hindu,Muslim,Christian,Sikh,Buddhist,Other',

            // Identification
            'aadhaar_number' => 'required|digits:12',
            'aadhaar_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'pan_number' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/',
            'voter_id' => 'nullable|regex:/^[A-Z]{3}[0-9]{7}$/',

            // Address
            'state' => 'required|string|in:' . implode(',', $this->getStates()),
            'district' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'pincode' => 'required|digits:6|regex:/^[0-9]{6}$/',
            'full_address' => 'required|string|max:500',
            'address_proof_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Contact
            'mobile_number' => 'required|digits:10|regex:/^[6-9][0-9]{9}$/',
            'email' => 'nullable|email|max:255',

            // Family
            'spouse_name' => 'nullable|string|max:255|required_if:marital_status,Married',
            'spouse_aadhaar' => 'nullable|digits:12|required_if:marital_status,Married',
            'number_of_dependents' => 'required|integer|min:0|max:10',
            'disability_status' => 'required|in:No,Physically disabled,Mentally disabled,Other',
            'disability_certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120|required_unless:disability_status,No',

            // Employment
            'employment_status' => 'required|in:Employed,Self-employed,Unemployed,Retired,Student,Homemaker,Other',
            'occupation_type' => 'nullable|string|required_if:employment_status,Employed',
            'organization_name' => 'nullable|string|max:255|required_if:employment_status,Employed',

            // Income
            'monthly_income' => 'required|numeric|min:0|max:999999999',
            'income_source' => 'nullable|array',
            'income_certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'annual_income_tax_return' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'bank_statement_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'financial_dependents' => 'required|integer|min:0|max:20',
            'total_assets' => 'nullable|numeric|min:0|max:999999999',

            // Category
            'caste_category' => 'required|in:General,OBC,SC,ST,EWS',
            'caste_certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120|required_unless:caste_category,General,EWS',
            'ews_certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120|required_if:caste_category,EWS',
            'bpl_status' => 'nullable|in:BPL,APL,Not applicable',

            // Health
            'health_status' => 'required|in:Good,Fair,Poor',
            'chronic_diseases' => 'nullable|array',
            'health_insurance_status' => 'required|in:Government scheme,Private insurance,No insurance',
            'medical_certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Education
            'education_level' => 'required|in:Below 5th,5-8th,9-10th,11-12th,Diploma,Bachelor,Master,PhD,Professional degree,Illiterate,Other',
            'currently_studying' => 'required|in:Yes,No',
            'education_proof_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120|required_if:currently_studying,Yes',

            // Consent & Agreements
            'consent' => 'required|accepted',
            'data_verification' => 'required|accepted'
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Full name is required',
            'full_name.regex' => 'Full name can only contain letters and spaces',
            'date_of_birth.before' => 'Date of birth must be before today',
            'aadhaar_number.digits' => 'Aadhaar number must be exactly 12 digits',
            'mobile_number.digits' => 'Mobile number must be exactly 10 digits',
            'mobile_number.regex' => 'Mobile number must start with 6-9',
            'monthly_income.numeric' => 'Monthly income must be a valid number',
            'aadhaar_file.max' => 'File size must not exceed 5MB',
            'consent.accepted' => 'You must accept the terms and conditions'
        ];
    }

    public function getStates(): array
    {
        return [
            'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh',
            'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka',
            'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram',
            'Nagaland', 'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu',
            'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'
        ];
    }
}
