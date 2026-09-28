<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [

        'user_id',

        'name',
        'email',
        'mobile',

        'pincode',
        'address',
        'city',
        'state',

        'payment_method',

        // ====================================================
        // ORDER CALCULATION FIELDS
        // ====================================================

        'subtotal',

        'shipping_amount',

        'discount_amount',

        'total_amount',

        'status',
    ];


    // ====================================================
    // ORDER ITEMS
    // ====================================================

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


    // ====================================================
    // ORDER USER
    // ====================================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}