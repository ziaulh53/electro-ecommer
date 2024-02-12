<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'items' => 'json',
        'shippingAddress' => 'json',
        'billingAddress' => 'json',
        'payment' => 'json',
        'logistics' => 'json',
    ];
    protected $fillable = [
        'user_id', 'orderId', 'items', 'shippingAddress', 'billingAddress',
        'payment', 'status', 'totalPrice','logistics', 'cancelNote'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
