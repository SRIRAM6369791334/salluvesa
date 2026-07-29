<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColorImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_color_id',
        'view_type', // front, back, chest, shoulder
        'image_path',
    ];

    public function productColor()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }
}
