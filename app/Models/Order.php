<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['order_id', 'status', 'role', 'treatment_id', 'total_price', 'created_at', 'updated_at', 'deleted_at'];

    public function TrearmentDetailForeignKLey()
    {
        return $this->belongsTo(TreatmentDetail::class, 'treatment_id', 'treatment_id');
    }
}
