<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'citizen_id',
        'pension_scheme_id',
        'transaction_reference',
        'amount',
        'status',
        'description',
        'transaction_date',
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
