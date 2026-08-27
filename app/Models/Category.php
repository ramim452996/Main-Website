<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'tagline',
        'display_order',
    ];

    public function foodItems(): HasMany
    {
        return $this->hasMany(FoodItem::class)->orderBy('is_featured', 'desc');
    }
}
