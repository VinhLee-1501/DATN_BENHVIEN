<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentService extends Model
{
    use HasFactory;
    protected $fillable = ['treatment_id', 'service_id'];

    public function medicineForeignKey()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function treatmentDetailForeignKey()
    {
        return $this->belongsTo(TreatmentDetail::class, 'service_id');
    }
}