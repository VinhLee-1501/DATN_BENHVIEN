<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'treatment_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
      'treatment_id',
      'quantity',
        'usage',
        'treatment_id',
        'medical_id', //Khóa ngoại
        'service_id' //Khóa ngoại
    ];

    public function serviceForeignKey()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    public function MedicalRecordForeignKey()
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_id', 'medical_id');
    }
    
}