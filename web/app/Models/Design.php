<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
        'image',
        'title',
        'tag',
        'type',
        'price',
        'description',
        'stocks',
        'size',
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
        'price' => 'decimal:2',
        'gsm' => 'array',
        'colors' => 'array',
        'features' => 'array',
        'is_active' => 'integer',
        'sort_order' => 'integer',
    ];
}
