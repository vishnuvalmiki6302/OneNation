<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Citizen extends Model
{
    protected $fillable = [
        'user_id',
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pensionAssignments(): HasMany
    {
        return $this->hasMany(CitizenPension::class);
    }

    public function duplicateLogs(): HasMany
    {
        return $this->hasMany(DuplicateLog::class, 'original_citizen_id');
    }

    public function citizenApplications(): HasMany
    {
        return $this->hasMany(CitizenApplication::class);
    }

    // Accessors
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth?->diffInYears(now()) ?? 0;
    }
}
