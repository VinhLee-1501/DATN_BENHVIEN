<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'day', 'name', 'phone', 'email', 'symptoms'];

    public function scheduleForeignKey()
    {
        return $this->belongsTo(Schedule::class, 'shift_id', 'shift_id');
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'book_id', 'book_id');
    }
}
