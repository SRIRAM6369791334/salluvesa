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
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
