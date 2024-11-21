<?php

namespace App\Models\Products;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentProduct extends Model
{
    protected $primaryKey = 'payment_id';
    protected $keyType = 'integer';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_id',
        'payment_method',
        'payment_status',
        'txn_ref',
        'order_id',
    ];


    public function orderForeignKLey()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

   
}