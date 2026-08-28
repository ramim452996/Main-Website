<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_address',
        'notes',
        'payment_method',
        'status',
        'subtotal',
        'discount',
        'delivery_fee',
        'tax',
        'tip',
        'total',
        'promo_code',
        'items',
        'estimated_delivery_at',
    ];

    protected $casts = [
        'subtotal' => 'float',
        'discount' => 'float',
        'delivery_fee' => 'float',
        'tax' => 'float',
        'tip' => 'float',
        'total' => 'float',
        'items' => 'array',
        'estimated_delivery_at' => 'datetime',
    ];
}
