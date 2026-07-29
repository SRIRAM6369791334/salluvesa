<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'total_amount',
        'grand_total_amount',
        'payment_method',
        'payment_status',
        'delivery_status',
        'payment_proof',
        'paypal_payment_id',
        'paypal_payer_id',
        'order_type',
        'date_ordered_on',
        'gst_amount',
        'discount_amount',
        'delivery_charge',
        'is_cancelled',
        'approve_staus',
        'base_currency',
        'base_amount',
        'selected_currency',
        'converted_amount',
        'exchange_rate',
        'printing_method',
        'bank_country',
    ];

    protected $casts = [
        'date_ordered_on' => 'datetime',
        'total_amount' => 'decimal:2',
        'grand_total_amount' => 'decimal:2',
    ];

    protected $appends = [
        'delivery_status_text',
        'status_color',
        'payment_status_text',
        'payment_method_text',
        'order_type_text',
    ];

    public function items()
    {
        return $this->hasMany(ProductOrderDetail::class, 'order_id', 'order_id');
    }

    public function shippingAddress()
    {
        return $this->hasOne(ProductOrderUserAddress::class, 'order_id', 'order_id');
    }

    public function getDeliveryStatusTextAttribute()
    {
        return match($this->delivery_status) {
            0 => 'Pending',
            1 => 'Packed',
            2 => 'Dispatched',
            3 => 'Out for delivery',
            4 => 'Delivered',
            default => 'pending',
        };
    }

    public function getStatusColorAttribute()
    {
         return match($this->delivery_status) {
            0 => 'warning', // Pending
            1 => 'info',    // Processing
            2 => 'primary', // Shipped
            3 => 'success', // Delivered
            4 => 'danger',  // Cancelled
            default => 'secondary',
        };
    }

    public function getPaymentStatusTextAttribute()
    {
        return match($this->payment_status) {
            0 => 'paid',
            1 => 'paid',
            2 => 'COD',
            3 => 'Bank Transfer Pending',
            default => 'paid',
        };
    }

    public function getPaymentMethodTextAttribute()
    {
        if ($this->payment_method === 'mp') {
            return 'Bank Transfer';
        }
        return strtoupper($this->payment_method);
    }

    public function getOrderTypeTextAttribute()
    {
        return match($this->order_type) {
            1 => 'Sample',
            2 => 'Own Design',
            default => 'Standard',
        };
    }
}
