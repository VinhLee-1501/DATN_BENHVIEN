<?php

namespace App\Models\Products;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewProduct extends Model
{
    protected $primaryKey = 'review_id';
    protected $keyType = 'integer';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'review_id',
        'rating',
        'product_id',
        'order_id',
        'user_id' //Khóa ngoại
    ];


    public function adminCommentProduct()
    {
        return $this->hasMany(AdminComment::class, 'review_id', 'review_id');
    }


    public function productForeignKLey()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function orderForeignKLey()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function userForeignKLey()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

   
}
