<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'user_type',
        'product_type',
        'min_quantity',
        'max_quantity',
    ];
}
