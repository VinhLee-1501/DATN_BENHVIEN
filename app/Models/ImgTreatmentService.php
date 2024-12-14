<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImgTreatmentService extends Model
{
    use HasFactory;
    protected $fillable = ['treatment_id', 'img', 'img_id', 'service_id'];

    protected $primaryKey = 'img_id';

    protected $table = 'img_treatment_service';

    public function treatmentService()
    {
        return $this->belongsTo(TreatmentService::class, 'treatment_id');
    }
}
