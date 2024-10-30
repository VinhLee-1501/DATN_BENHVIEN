<?php

namespace App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminComment extends Model
{
    protected $primaryKey = 'ad_comment_id';
    protected $keyType = 'integer';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ad_comment_id',
        'response_text',
        'product_id',
        'user_id' ,
    ];


    public function orderForeignKLey()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function userForeignKLey()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

}
