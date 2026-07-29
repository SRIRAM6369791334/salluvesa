<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    use HasFactory;

    protected $table = 'bank_details';

    protected $fillable = [
        'account_holder_name',
        'bank_name',
        'account_number',
        'account_type',
        'routing_number',
        'ifsc_code',
        'swift_code',
        'bank_branch_name',
        'bank_branch_address',
        'beneficiary_address',
        'bank_country',
        'description',
        'currency_accepted',
        'business_name',
        'business_address',
        'business_email',
        'business_contact_number',
        'gst_number',
        'payment_method',
        'payment_confirmation_time',
    ];
}
