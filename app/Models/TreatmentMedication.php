<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentMedication extends Model
{
    use HasFactory;

    protected $fillable = ['treatment_id', 'medicine_id'];

    public function medicineForeignKey()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }

    public function treatmentDetailForeignKey()
    {
        return $this->belongsTo(TreatmentDetail::class, 'treatment_id');
    }
}
