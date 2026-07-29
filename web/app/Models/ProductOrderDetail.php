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
        'customization_type',
        'customization_method',
        'customization_position',
        'custom_text',
        'custom_text_color',
        'custom_logo_url',
        'embroidery_icon_id',
        'custom_instructions',
        'customization_price',
        'preview_screenshot_url',
        'mockup_url',
    ];

    protected $casts = [
        'product_rate' => 'decimal:2',
        'product_total' => 'decimal:2',
    ];
}
