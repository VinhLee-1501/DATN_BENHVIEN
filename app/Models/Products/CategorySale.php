<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Products\Category;
class CategorySale extends Model
{

    use HasFactory, SoftDeletes;
    protected $table = 'category_sale';
    protected $primaryKey = 'row_id';
    protected $keyType = 'integer';

    protected $fillable = [
        'category_id',
        'coupon_id',
        'row_id'
    ];

    public function Coupon()
    {
        return $this->hasMany(Coupon::class, 'coupon_id', 'coupon_id');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
