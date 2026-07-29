<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeChart extends Model
{
    use HasFactory;

    protected $table = 'size_charts';

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
}
