<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'discountPrice',
        'discountAvailable',
        'newArrival',
        'description',
        'is_variation',
        'quantity',
        'brands_id',
        'category_id',
        'default_images'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brands_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors')->withPivot('quantity', 'images');
    }
}
