<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderNotification extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'status',
        'message',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}