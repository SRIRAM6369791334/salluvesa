<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductColorImage extends Model
{
    protected $fillable = [
        'product_color_id',
        'view_type',
        'image_path',
    ];

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) return null;
        $fullUrl = env('MAIN_URL') . ltrim($this->image_path, '/');
        return url('/proxy-image') . '?url=' . urlencode($fullUrl);
    }
}
