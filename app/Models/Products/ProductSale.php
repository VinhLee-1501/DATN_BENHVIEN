<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSale extends Model
{

    use HasFactory, SoftDeletes;
    protected $table = 'product_sale';
    protected $primaryKey = 'row_id';
    protected $keyType = 'integer';

    protected $fillable = [
        'product_id',
        'coupon_id',
        'row_id'
    ];

    public function Coupon()
    {
        return $this->hasMany(Coupon::class, 'coupon_id', 'coupon_id');
    }

    public function Product()
    {
        return $this->belongsTo(ProductSale::class, 'product_id', 'product_id');
    }
}
