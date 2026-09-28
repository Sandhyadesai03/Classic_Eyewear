<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'subject',
        'message',
        'reply',
        'status',
        'admin_read',
        'user_read',
        'replied_at',
    ];

    protected $casts = [
        'admin_read' => 'boolean',
        'user_read' => 'boolean',
        'replied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}