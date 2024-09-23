<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
      'medical_id',
      'date',
        'diaginsis',
        're_examination_date',
        'symptom',
        'status',
        'advice',
        'blood_pressure',
        'respiratory_rate',
        'weight',
        'height',
        'patien_id', //Khóa ngoại
        'book_id' //Khóa ngoại
    ];

    public function bookForeignKey()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

    public function patientForeignKey()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }
}