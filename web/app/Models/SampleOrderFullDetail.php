<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampleOrderFullDetail extends Model
{
    protected $fillable = [
        'order_primary_id',
        'order_id',
        'user_id',
        'user_name',
        'user_email',
        'user_phone',
        'address_username',
        'address_phone_number',
        'address_line_one',
        'address_line_two',
        'landmark',
        'city',
        'state',
        'pincode',
        'country',
        'address_type_name',
        'total_amount',
        'grand_total_amount',
        'payment_method',
        'paypal_payment_id',
        'paypal_payer_id',
        'payment_status_text',
        'order_items',
        'printing_method',
        'bank_country',
    ];

    protected $casts = [
        'order_items' => 'array',
        'total_amount' => 'decimal:2',
        'grand_total_amount' => 'decimal:2',
    ];
}
