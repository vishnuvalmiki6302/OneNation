<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitizenApplication extends Model
{
    protected $fillable = [
        'citizen_id',
        'pension_scheme_id',
        'status',
        'application_number',
        'marital_status',
        'religion',
        'spouse_name',
        'spouse_aadhaar',
        'number_of_dependents',
        'financial_dependents',
        'pan_number',
        'voter_id',
        'employment_status',
        'occupation_type',
        'organization_name',
        'monthly_income',
        'income_source',
        'total_assets',
        'caste_category',
        'bpl_status',
        'health_status',
        'disability_status',
        'chronic_diseases',
        'health_insurance_status',
        'education_level',
        'currently_studying',
        'aadhaar_file',
        'address_proof_file',
        'disability_certificate_file',
        'income_certificate_file',
        'annual_income_tax_return',
        'bank_statement_file',
        'caste_certificate_file',
        'ews_certificate_file',
        'medical_certificate_file',
        'education_proof_file',
        'consent',
        'data_verification'
    ];

    protected $casts = [
        'income_source' => 'array',
        'chronic_diseases' => 'array',
        'consent' => 'boolean',
        'data_verification' => 'boolean',
    ];

    public function citizen()
    {
        return $this->belongsTo(Citizen::class);
    }

    public function pensionScheme()
    {
        return $this->belongsTo(PensionScheme::class);
    }
}
