<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $primaryKey = 'row_id'; // Khóa chính

    protected $fillable = [
        'patient_id',
        'first_name',
        'last_name',
        'gender',
        'birthday',
        'address',
        'cccd',
        'insurance_number',
        'emergency_contact',
        'occupation',
        'national',
        'phone' //Khóa ngoại
    ];

    // Quan hệ với model MedicalRecord (1 bệnh nhân có nhiều bệnh án)
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id', 'patient_id');
    }

    // Quan hệ với model User
    public function userForeignKey()
    {
        return $this->belongsTo(User::class);
    }
}
