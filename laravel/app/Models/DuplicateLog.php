<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DuplicateLog extends Model
{
    protected $table = 'duplicate_logs';

    protected $fillable = [
        'original_citizen_id',
        'duplicate_citizen_id',
        'match_percentage',
        'match_reason',
        'status',
        'reviewed_by',
        'reviewed_at',
        'notes',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'match_percentage' => 'decimal:2',
    ];

    // Relationships
    public function originalCitizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class, 'original_citizen_id');
    }

    public function duplicateCitizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class, 'duplicate_citizen_id');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
