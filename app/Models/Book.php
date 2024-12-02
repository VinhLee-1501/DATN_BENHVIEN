<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    protected $primaryKey = 'book_id';
    protected $keyType = 'string';

    use HasFactory, SoftDeletes;

    protected $fillable = ['book_id', 'day', 'name', 'phone', 'email', 'symptoms', 'hour', 'user_id'];

    public function scheduleForeignKey()
    {
        return $this->belongsTo(Schedule::class, 'shift_id', 'shift_id');
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'book_id', 'book_id');
    }
    public function orders()
    {
        return $this->hasOne(Order::class, 'book_id', 'book_id');
    }
}
