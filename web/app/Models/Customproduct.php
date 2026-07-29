<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customproduct extends Model
{
    protected $fillable = [
        'name',
        'description',
        'base_price',
        'product_type',
        'status',
        'front_mockup',
        'back_mockup',
        'right_shoulder_mockup',
        'left_shoulder_mockup',
        'printable_rect',
        'is_two_sided',
        'available_sizes',
        'canvas_config',
        'extra_element_price',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'printable_rect' => 'array',
        'is_two_sided' => 'boolean',
        'available_sizes' => 'array',
        'canvas_config' => 'array',
    ];

    /**
     * Get all designs for this custom product
     */
    public function designs()
    {
        return $this->hasMany(CustomproductDesign::class, 'customproduct_id');
    }

    /**
     * Get all color variants for this product
     */
    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'customproduct_id');
    }

    /**
     * Scope to get only active products
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
