<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'product_type',
        'product_name',
        'product_image',
        'price',
        'product_quantity',
        'product_size',
        'product_color',
        'design_id',
        'session_id',
        'roster_data',
        'extra_price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'extra_price' => 'decimal:2',
        'roster_data' => 'array',
    ];

    /**
     * Get the custom design associated with this cart item
     */
    public function design()
    {
        return $this->belongsTo(CustomproductDesign::class, 'design_id');
    }
}
