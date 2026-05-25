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
    ];

    protected $casts = [
        'monthly_benefit_amount' => 'decimal:2',
    ];

    // Relationships
    public function citizenPensions(): HasMany
    {
        return $this->hasMany(CitizenPension::class);
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
