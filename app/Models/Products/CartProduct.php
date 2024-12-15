<?php

namespace App\Models\Products;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartProduct extends Model
{
    protected $primaryKey = 'cart_id';
    protected $keyType = 'integer';
    protected $table = 'cart_products';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cart_id',
        'name',
        'quantity',
        'total_price',
        'product_id',
        'user_id',
       
    ];

    public function orderProduct()
    {
        return $this->hasMany(Order::class, 'cart_id', 'cart_id');
    }


    public function productForeignKLey()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function userForeignKLey()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}