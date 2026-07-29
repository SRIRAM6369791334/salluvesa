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
        'cloth_types'
    ];
}
