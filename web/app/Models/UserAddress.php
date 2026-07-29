<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
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
        'is_default', // inferred
    ];

    protected $appends = ['address_type_name'];

    public function getAddressTypeNameAttribute()
    {
        return match($this->address_type_id) {
            1 => 'Home',
            2 => 'Work',
            3 => 'Other',
            default => 'Unknown',
        };
    }
}
