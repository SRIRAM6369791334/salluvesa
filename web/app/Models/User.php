<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'user_id',
        'is_guest_user',
        'otp',
        'otp_expiry',
        'user_default_address_id',
        'from_app',
        'user_type',
        'gst_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'otp_expiry' => 'datetime',
        'is_guest_user' => 'boolean',
    ];

    /**
     * Get the addresses for the user.
     */
    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'user_id');
    }

    /**
     * Get the cart items for the user.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'user_id', 'user_id');
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(ProductOrder::class, 'user_id', 'user_id');
    }

    /**
     * Get the designs for the user.
     */
    public function designs()
    {
        return $this->hasMany(CustomproductDesign::class, 'user_id', 'user_id');
    }

    /**
     * Check if the user has purchased a sample.
     *
     * @return bool
     */
    public function hasPurchasedSample()
    {
        // order_type 1 is Sample
        // 1 = Paid, 2 = COD, 3 = Bank Transfer Pending
        return $this->orders()
            ->where('order_type', 1)
            ->whereIn('payment_status', [1, 2, 3])
            ->exists();
    }
}
