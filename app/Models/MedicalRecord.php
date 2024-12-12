<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'medical_id';
    protected $keyType = 'string';
    public $incrementing = false;
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
        'patient_id', //Khóa ngoại
        'book_id', //Khóa ngoại
        'user_id' //Khóa ngoại
    ];

    public function bookForeignKey()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

    public function patientForeignKey()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function userForeignKey()
    {
        return $this->belongsTo(Patient::class, 'user_id', 'user_id');
    } // In Patient model
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id', 'patient_id');
    }
}
