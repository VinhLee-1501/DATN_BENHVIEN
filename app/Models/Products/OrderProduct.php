<?php

namespace App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    protected $primaryKey = 'order_id';
    protected $keyType = 'integer';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'quantity',
        'price_old',
        'price_sale',
        'order_status',
        'order_username',
        'order_phone',
        'order_address',
        'note',
        'cart_id',
        'product_id',
        'coupon_id',
        'user_id',
       
    ];

    public function paymentProduct()
    {
        return $this->hasMany(PaymentProduct::class, 'order_id', 'order_id');
    }

    public function reviewProduct()
    {
        return $this->hasMany(ReviewProduct::class, 'order_id', 'order_id');
    }

    public function productForeignKLey()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function cartForeignKLey()
    {
        return $this->belongsTo(CartProduct::class, 'cart_id', 'cart_id');
    }

    public function userForeignKLey()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function couponForeignKLey()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'coupon_id');
    } 

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id', 'product_id');
    }
}
