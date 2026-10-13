<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'product_id', 
        'product_quantity',
        'gsm',
        'cloth_type',
        'customization_type',
        'customization_method',
        'customization_position',
        'custom_text',
        'custom_text_color',
        'custom_logo_url',
        'embroidery_icon_id',
        'custom_instructions',
        'customization_price',
        'preview_screenshot_url'
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
