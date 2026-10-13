<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomProduct extends Model
{
    use HasFactory;

    protected $table = 'customproducts';

    protected $fillable = [
        'name',
        'description',
        'base_price',
        'product_type',
        'front_mockup',
        'back_mockup',
        'right_shoulder_mockup',
        'left_shoulder_mockup',
        'printable_rect',
        'is_two_sided',
        'available_sizes',
        'canvas_config',
        'status',
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
        'printable_rect' => 'array',
        'available_sizes' => 'array',
        'canvas_config' => 'array',
        'is_two_sided' => 'boolean',
        'sizes' => 'array',
        'gsm' => 'array',
        'colors' => 'array',
        'features' => 'array',
        'is_active' => 'integer',
        'sort_order' => 'integer',
    ];
    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'customproduct_id');
    }
}
