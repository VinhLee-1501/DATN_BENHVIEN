<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleProduct extends Model
{
    protected $primaryKey = 'sale_id';
    protected $keyType = 'integer';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sale_id',
        'sale_code',
        'time_start',
        'time_end',
        'discount',
        'status',
        'product_id' //Khóa ngoại
    ];


    public function medicineTypeForeignKLey()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
