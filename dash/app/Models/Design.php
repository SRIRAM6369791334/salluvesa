<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model {
    use HasFactory;

    protected $table = 'designs';

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
        'is_active'
    ];

    protected $casts = [
        'gsm' => 'array',
        'colors' => 'array',
        'features' => 'array',
        'is_active' => 'integer',
        'sort_order' => 'integer',
    ];
}
