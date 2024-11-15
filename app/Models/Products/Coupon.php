<?php

namespace App\Models\Products;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    protected $table = 'coupons';
    protected $primaryKey = 'coupon_id';
    protected $keyType = 'integer';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'discount_code',
        'type',
        'percent',
        'use_limit',
        'min_purchase',
        'product_id',
        'category_id',
        'time_end',
        'time_start',
        'note'
       
    ];


    public function order()
    {
        return $this->hasMany(Order::class, 'coupon_id', 'coupon_id');
    }
    
    public function CategorySale()
    {
        return $this->belongsTo(CategorySale::class, 'category_id', 'category_id');
    }
    
    public function ProductSale()
    {
        return $this->belongsTo(ProductSale::class, 'product_id', 'product_id');
    }

    
}
