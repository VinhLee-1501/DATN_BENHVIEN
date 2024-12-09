<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderMedicine extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'row_id';
    protected $fillable = [
        'user_id',
        'treament_id',
        'order_medicine_id',
        'price_service',
        'status',
        'total_price',
        'cash_received',
        'change',
     
    ];

    public function TrearmentDetailForeignKLey()
    {
        return $this->belongsTo(TreatmentDetail::class, 'treatment_id', 'treatment_id');
    }

    public function UserForeignKLey()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
   
}