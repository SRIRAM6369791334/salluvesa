<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'product_name', 'product_quantity', 'offer_price', 'mrp_price', 'product_description', 'product_image', 'product_specification', 'unit_value', 'product_value', 'subcategory_id', 'cate_name', 'subcate_name', 'brand_name', 'brand_material', 'brand_type', 'approval_days', 'prod_unique_name', 'size_chart_image', 'cate_name'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function Subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function productvari()
    {
        return $this->hasMany(ProductVerient::class);
    }
    public function childImages()
    {
        return $this->hasMany(ProductChildImage::class, 'product_id');
    }
}
