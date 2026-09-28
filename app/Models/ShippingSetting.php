<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingSetting extends Model
{
    protected $table = 'shipping_settings';

    protected $fillable = [
        'shipping_charge',
        'free_shipping_amount',
    ];

    protected $casts = [
        'shipping_charge' => 'decimal:2',
        'free_shipping_amount' => 'decimal:2',
    ];
}