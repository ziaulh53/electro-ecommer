<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName', 'lastName', 'phone', 'apartment', 'address', 'city', 'zipCode', 'state', 'country', 'user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
