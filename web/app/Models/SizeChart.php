<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeChart extends Model
{
    protected $fillable = [
        'serial_no',
        'usa_uk',
        'eu',
        'japan',
        'korea',
        'chest_cm',
        'chest_inches',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
