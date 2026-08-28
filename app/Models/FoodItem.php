<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'rating',
        'reviews_count',
        'prep_time',
        'calories',
        'image',
        'is_featured',
        'is_popular',
        'is_chef_special',
        'is_vegetarian',
        'is_spicy',
        'spice_level',
        'tags',
        'customization_options',
    ];

    protected $casts = [
        'price' => 'float',
        'original_price' => 'float',
        'rating' => 'float',
        'reviews_count' => 'integer',
        'calories' => 'integer',
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
        'is_chef_special' => 'boolean',
        'is_vegetarian' => 'boolean',
        'is_spicy' => 'boolean',
        'spice_level' => 'integer',
        'tags' => 'array',
        'customization_options' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
