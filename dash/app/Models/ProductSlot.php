<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_date',
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'product_rate',
        'quantity',
        'product_total',
        'size_value',
        'color_value',
        'delivery_status',
        'order_delivered_time',
        'deliver_person_id',
        'is_cancelled',
        'cancel_reason',
        'design_id',
        'snapshot_path',
        'snapshot_json',
        'sample_variant_id',
        'created_at',
        'updated_at'
    ];


    public function productOrder()
    {
        return $this->belongsTo(ProductOrder::class, "order_id", "order_id");
    }

    public function order()
    {
        return $this->belongsTo(ProductOrder::class, "order_id", "order_id");
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function productVarient()
    {
        return $this->belongsTo(ProductVarient::class);
    }
    public function productorderAddress()
    {
        return $this->belongsTo(ProductOrderUserAddress::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
