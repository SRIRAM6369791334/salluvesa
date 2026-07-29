<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_holder_name',
        'bank_name',
        'account_number',
        'account_type',
        'ifsc_code',
        'swift_code',
        'bank_branch_name',
        'bank_branch_address',
        'payment_method',
        'routing_number',
        'beneficiary_address',
        'bank_country',
        'currency_accepted',
        'business_name',
        'business_address',
        'business_email',
        'business_contact_number',
        'gst_number',
        'payment_confirmation_time',
        'description',
    ];
}
