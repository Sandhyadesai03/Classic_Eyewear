<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'start_date',
        'expiry_date',
        'usage_limit',
        'used_count',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'expiry_date' => 'datetime',
        'discount_value' => 'decimal:2',
        'status' => 'boolean',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
    ];
}