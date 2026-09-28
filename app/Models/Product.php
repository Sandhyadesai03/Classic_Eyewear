<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use App\Models\Review;
class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'image',
        'description',
    ];

    // Cart relationship
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Product Images relationship
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}
}