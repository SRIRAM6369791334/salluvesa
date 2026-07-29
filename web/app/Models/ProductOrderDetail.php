<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrderDetail extends Model
{
    protected $table = 'product_slots';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'product_rate',
        'quantity',
        'product_total',
        'size_value',
        'color_value',
        'delivery_status',
        'approve_staus',
        'design_id',
        'snapshot_path',
        'snapshot_json',
    ];

    protected $casts = [
        'product_rate' => 'decimal:2',
        'product_total' => 'decimal:2',
    ];
}
