<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Citizen extends Model
{
    protected $fillable = [
        'full_name',
        'aadhaar_number',
        'mobile_number',
        'email_address',
        'gender',
        'date_of_birth',
        'state',
        'district',
        'full_address',
        'pension_status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    // Relationships
    public function pensionAssignments(): HasMany
    {
        return $this->hasMany(CitizenPension::class);
    }

    public function duplicateLogs(): HasMany
    {
        return $this->hasMany(DuplicateLog::class, 'original_citizen_id');
    }

    // Accessors
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth?->diffInYears(now()) ?? 0;
    }
}
