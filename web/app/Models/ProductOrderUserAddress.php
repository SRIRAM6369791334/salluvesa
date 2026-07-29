<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrderUserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'address_username',
        'address_line_one',
        'address_line_two',
        'landmark',
        'city',
        'state',
        'pincode',
        'country',
        'address_phone_number',
        'address_type_id',
        'address_type_name',
    ];
}
