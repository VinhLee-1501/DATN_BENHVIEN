<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'name',
        'active_ingredient',
        'unit_of_measurement',
        'status',
        'medicine_type_id' //Khóa ngoại
    ];

    public function treatmentMedication()
    {
        return $this->hasMany(TreatmentMedication::class);
    }

    public function medicineTypeForeignKLey()
    {
        return $this->belongsTo(MedicineType::class, 'medicine_type_id', 'medicine_type_id');
    }
}
