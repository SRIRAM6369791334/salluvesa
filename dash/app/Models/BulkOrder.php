<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'user_type',
        'quantity',
        'product_type',
        'product_id',
        'custom_image',
        'notes',
        'status',
        'admin_notes',
    ];

    /**
     * Get the product associated with the bulk order if product_type is own_design.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
