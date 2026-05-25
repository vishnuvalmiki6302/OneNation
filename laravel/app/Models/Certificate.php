<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'citizen_id',
        'document_name',
        'document_type',
        'file_path',
        'status',
    ];

    public function citizen()
    {
        return $this->belongsTo(Citizen::class);
    }
}
