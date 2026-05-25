<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CitizenPension extends Model
{
    protected $table = 'citizen_pensions';

    protected $fillable = [
        'citizen_id',
        'pension_scheme_id',
        'enrollment_number',
        'pension_start_date',
        'monthly_benefit_amount',
        'pension_status',
        'notes',
    ];

    protected $casts = [
        'pension_start_date' => 'date',
        'monthly_benefit_amount' => 'decimal:2',
    ];

    // Relationships
    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class);
    }

    public function pensionScheme(): BelongsTo
    {
        return $this->belongsTo(PensionScheme::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('pension_status', 'Active');
    }

    public function scopePending($query)
    {
        return $query->where('pension_status', 'Pending');
    }

    // Accessors
    public function getAnnualBenefitAttribute(): float
    {
        return $this->monthly_benefit_amount * 12;
    }
}
