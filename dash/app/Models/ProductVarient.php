<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVarient extends Model {
    use HasFactory;

    protected $table = 'product_varient';

    protected $fillable = [ 'categoryid', 'subcategoryid', 'product_id', 'varient', 'value', 'offer_price', 'mrp_price', 'product_qty', 'low_stock', 'hot_deals', 'product_gst', 'subcatename', 'varient_img', 'varient_name', 'size_value', 'color_value' ];

    public function category() {
        return $this->belongsTo( Category::class );
    }
}