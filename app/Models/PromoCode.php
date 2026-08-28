<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'type',
        'value',
        'min_spend',
        'is_active',
    ];

    protected $casts = [
        'value' => 'float',
        'min_spend' => 'float',
        'is_active' => 'boolean',
    ];

    public function calculateDiscount(float $subtotal, float $deliveryFee): array
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'This promo code is no longer active.'];
        }

        if ($subtotal < $this->min_spend) {
            return ['valid' => false, 'message' => "Minimum order amount for this coupon is $" . number_format($this->min_spend, 2)];
        }

        $discount = 0;
        if ($this->type === 'percentage') {
            $discount = round(($subtotal * $this->value) / 100, 2);
        } elseif ($this->type === 'fixed') {
            $discount = min($this->value, $subtotal);
        } elseif ($this->type === 'free_delivery') {
            $discount = $deliveryFee;
        }

        return [
            'valid' => true,
            'discount' => $discount,
            'code' => $this->code,
            'type' => $this->type,
            'title' => $this->title,
            'message' => "Coupon '{$this->code}' applied successfully!"
        ];
    }
}
