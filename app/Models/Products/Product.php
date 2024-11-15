<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $keyType = 'integer';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'code_product',
        'unit_of_measurement',
        'actice_ingredient',
        'used',
        'description',
        'price',
        'brand',
        'manufacture',
        'registration_number',
        'status',
        'category_id',
    ];

    public function saleProduct()
    {
        return $this->hasMany(SaleProduct::class, 'product_id', 'product_id');
    }

    public function imgProduct()
    {
        return $this->hasMany(ImgProduct::class, 'product_id', 'product_id');
    }

    public function cartProduct()
    {
        return $this->hasMany(CartProduct::class, 'product_id', 'product_id');
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class, 'product_id', 'product_id');
    }

    public function reviewProduct()
    {
        return $this->hasMany(ReviewProduct::class, 'product_id', 'product_id');
    }

    public function categoryForeignKLey()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function productSale()
    {
        return $this->hasMany(ProductSale::class, 'product_id', 'product_id');
    }
   
}
