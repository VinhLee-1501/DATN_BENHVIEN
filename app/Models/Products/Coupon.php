<?php

namespace App\Models\Products;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    protected $primaryKey = 'coupon_id';
    protected $keyType = 'integer';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'coupon_id',
        'discount',
        'time_end',
        'discount',
       
    ];


    public function order()
    {
        return $this->hasMany(Order::class, 'coupon_id', 'coupon_id');
    }
}
