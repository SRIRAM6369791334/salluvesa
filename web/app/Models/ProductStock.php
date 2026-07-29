<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table = 'productstocks';

    protected $fillable = [
        'productid',
        'availablestock',
        'salestock',
        'last_stockupdate_date',
    ];

    protected $casts = [
        'last_stockupdate_date' => 'datetime',
    ];
}
