<?php

namespace App\Models;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'coverImage',
    ];

    /**
     * Get the brands associated with the category.
     */
    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_category');
    }
}
