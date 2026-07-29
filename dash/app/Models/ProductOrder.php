<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductOrder extends Model
{
    use HasFactory;

    // protected $fillable =  [ 'order_id', 'date_ordered_on', 'delivery_person_id', 'is_delivery_assigned', 'user_id', 'payment_status', 'delivery_status', 'current_status', 'is_cancelled', 'approve_staus', 'cancel_reason', 'reason_for_cancel', 'created_at', 'updated_at' ];

    protected $guarded = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function area()
    {
        return $this->customer->area();
    }

    public function transactionLog()
    {
        return $this->hasOne(ProductTransactionLog::class, 'order_id', 'order_id');
    }

    public function getDateOrderedOnAttribute($value)
    {

        return Carbon::parse($value)->format('d-M-Y');
    }

    public function orderAddress(): HasOne
    {
        return $this->hasOne(ProductOrderUserAddress::class, 'order_id', 'order_id');
    }
    public function useraddress(): HasOne
    {
        return $this->hasOne(UserAddress::class, 'user_id', 'user_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function getTotalItemsAttribute()
    {
        return ProductSlot::where('order_id', $this->order_id)
            ->orWhere('order_id', (string)$this->id)
            ->count();
    }

    public function getTotalQuantityAttribute()
    {
        return ProductSlot::where('order_id', $this->order_id)
            ->orWhere('order_id', (string)$this->id)
            ->sum('quantity');
    }
}
