<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $primaryKey = 'row_id'; // Khóa chính

    protected $fillable = [
        'patien_id',
        'first_name',
        'last_name',
        'gender',
        'birthday',
        'address',
        'Insurance_number',
        'emergency_contact',
        'occupation',
        'national',
        'phone' //Khóa ngoại
    ];

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'patient_id', 'patient_id');
    }

    public function userForeignKey()
    {
        return $this->belongsTo(User::class,);
    }
}
