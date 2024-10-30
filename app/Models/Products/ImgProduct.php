<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImgProduct extends Model
{
    protected $primaryKey = 'img_id';
    protected $keyType = 'integer';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'img_id',
        'img',
        'time_start',
        'time_end',
        'product_id' //Khóa ngoại
    ];


    public function productForeignKLey()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
