<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomproductDesign extends Model
{
    protected $fillable = [
        'customproduct_id',
        'user_id',
        'session_id',
        'canvas_width',
        'canvas_height',
        'product_color',
        'product_size',
        'product_color_id',
        'preview_image_front',
        'preview_image_back',
        'preview_image_chest',
        'preview_image_shoulder',
        'preview_image_right_shoulder',
        'preview_image_left_shoulder',
        'design_json_front',
        'design_json_back',
        'design_json_chest',
        'design_json_shoulder',
        'design_json_right_shoulder',
        'design_json_left_shoulder',
        'status',
        'design_name',
        'thumbnail_path',
    ];

    protected $casts = [
        'design_json_front' => 'array',
        'design_json_back' => 'array',
        'design_json_chest' => 'array',
        'design_json_shoulder' => 'array',
        'design_json_right_shoulder' => 'array',
        'design_json_left_shoulder' => 'array',
    ];

    /**
     * Get the custom product this design belongs to
     */
    public function customproduct()
    {
        return $this->belongsTo(Customproduct::class, 'customproduct_id');
    }

    /**
     * Get the color of this design
     */
    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    /**
     * Get all layers for this design
     */
    public function layers()
    {
        return $this->hasMany(DesignLayer::class, 'design_id');
    }

    /**
     * Get the user who created this design (if authenticated)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get cart items using this design
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'design_id');
    }

    /**
     * Get layers for front side
     */
    public function frontLayers()
    {
        return $this->layers()->where('print_position', 'front')->orWhere('print_position', 'like', 'chest%');
    }

    /**
     * Get layers for back side
     */
    public function backLayers()
    {
        return $this->layers()->where('print_position', 'back');
    }

    /**
     * Get layers for chest side
     */
    public function chestLayers()
    {
        return $this->layers()->where('print_position', 'chest');
    }

    /**
     * Get layers for shoulder side
     */
    public function shoulderLayers()
    {
        return $this->layers()->where('print_position', 'shoulder');
    }
}
