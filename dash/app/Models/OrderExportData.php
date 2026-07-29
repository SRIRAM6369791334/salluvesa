<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderExportData extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'form_data'];

    protected $casts = [
        'form_data' => 'array',
    ];
}
