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
 

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
