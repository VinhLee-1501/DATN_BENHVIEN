<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'row_id';
    protected $fillable = [
        'order_id',
        'status',
        'payment',
        'cashier',
        'cash_received',
        'change_amount',
        'total_amount',
        'treatment_id',
        'total_price',
        'created_at',
        'updated_at',
        'deleted_at',
        'book_id'
    ];

    public function TrearmentDetailForeignKLey()
    {
        return $this->belongsTo(TreatmentDetail::class, 'treatment_id', 'treatment_id');
    }
    public function bookForeignKey(){
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }
}
