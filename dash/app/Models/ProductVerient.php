<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVerient extends Model
{
    use HasFactory;
    protected $table = "product_varient";
    protected $fillable = ["product_id","varient","value","offer_price","mrp_price","product_qty","product_gst"];

}
