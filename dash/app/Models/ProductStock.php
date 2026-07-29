<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model {
    use HasFactory;

    protected $fillable = [ 'productid', 'category_id', 'subcategory_id', 'pro_ver_id', 'productname', 'overallstock', 'availablestock', 'salestock', 'low_stocks' ];

    protected $table = 'productstocks';

    public function category() {
        return $this->belongsTo( Category::class, 'category_id' );
    }

    public function Productvarient() {
        return $this->belongsTo( ProductVarient::class, 'id' );
    }
}