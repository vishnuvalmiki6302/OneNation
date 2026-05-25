<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PensionScheme extends Model
{
    protected $fillable = [
        'scheme_name',
        'scheme_code',
        'scheme_type',
        'provider_type',
        'eligibility_criteria',
        'monthly_benefit_amount',
        'status',
        'description',
        'min_age',
        'max_age',
        'max_income',
        'required_marital_status',
        'requires_disability',
        'required_category',
        'required_employment_status',
        'state_specific',
        'applicable_states',
        'max_assets',
        'required_documents',
        'base_benefit_amount',
        'dependent_allowance',
        'minimum_benefit_amount',
    ];

    protected $casts = [
        'monthly_benefit_amount' => 'decimal:2',
        'max_income' => 'decimal:2',
        'max_assets' => 'decimal:2',
        'base_benefit_amount' => 'decimal:2',
        'dependent_allowance' => 'decimal:2',
        'minimum_benefit_amount' => 'decimal:2',
        'requires_disability' => 'boolean',
        'state_specific' => 'boolean',
        'required_category' => 'array',
        'applicable_states' => 'array',
        'required_documents' => 'array',
    ];

    // Relationships
    public function citizenPensions(): HasMany
    {
        return $this->hasMany(CitizenPension::class);
    }

    public function citizenApplications(): HasMany
    {
        return $this->hasMany(CitizenApplication::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('scheme_type', $type);
    }

    public function getEnrolledCitizensCount(): int
    {
        return $this->citizenPensions()
            ->where('pension_status', 'Active')
            ->count();
    }
}
