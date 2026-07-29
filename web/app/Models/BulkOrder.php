<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BulkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        'email',
        'user_type',
        'quantity',
        'product_type',
        'product_id',
        'custom_image',
        'notes',
    ];
}
