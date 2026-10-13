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
        'sizes',
        'cloth_types',
        'gsm',
        'colors',
        'features',
        'badge',
        'badge_type',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'printable_rect' => 'array',
        'is_two_sided' => 'boolean',
        'available_sizes' => 'array',
        'canvas_config' => 'array',
        'sizes' => 'array',
        'gsm' => 'array',
        'colors' => 'array',
        'features' => 'array',
        'is_active' => 'integer',
        'sort_order' => 'integer',
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
