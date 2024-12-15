<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartDetail extends Model
{
    protected $primaryKey = 'cart_detail_id';
    protected $keyType = 'integer';
    protected $table = 'cart_details';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    public function cartForeignKLey()
    {
        return $this->hasMany(CartProduct::class, 'cart_id', 'cart_id');
    }
    

    public function productForeignKLey()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}