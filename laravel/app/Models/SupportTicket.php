<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'user_id',
        'ticket_number',
        'subject',
        'description',
        'image_path',
        'status',
        'admin_reply',
        'resolved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
