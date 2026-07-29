<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;

    protected $table = 'samples';

    protected $fillable = [
        'title',
        'category',
        'description',
        'image',
        'badge',
        'badge_type',
        'price',
        'sizes',
        'features',
        'is_active',
        'sort_order',
        'stocks',
        'cloth_types',
        'gsm',
        'colors'
    ];

    protected $casts = [
        'sizes' => 'array',
        'features' => 'array',
        'is_active' => 'integer',
        'sort_order' => 'integer',
        'stocks' => 'integer',
        'gsm' => 'array',
        'colors' => 'array',
    ];
}
