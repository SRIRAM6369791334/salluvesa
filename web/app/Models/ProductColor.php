<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $fillable = [
        'customproduct_id',
        'color_name',
        'color_code',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Customproduct::class, 'customproduct_id');
    }

    public function images()
    {
        return $this->hasMany(ProductColorImage::class, 'product_color_id');
    }

    public function designs()
    {
        return $this->hasMany(CustomproductDesign::class, 'product_color_id');
    }

    /**
     * Scope to get only active colors
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
