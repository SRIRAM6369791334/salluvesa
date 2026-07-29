<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductChildImage extends Model
{
    use HasFactory;

    protected $table = 'product_child_images';

    protected $fillable = [
        'product_id',
        'product_child_image',
        'variant_id',
    ];

    /**
     * Relation to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relation to Variant (optional if applicable)
     */
    public function variant()
    {
        return $this->belongsTo(ProductVarient::class, 'variant_id');
    }
}