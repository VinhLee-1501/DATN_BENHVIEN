<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sclinic extends Model
{
    use HasFactory;
    protected $table = 'sclinics';
    protected $primaryKey = 'sclinic_id';
    protected $keyType = 'string';

    protected $fillable = ['sclinic_id', 'name', 'description', 'status'];
    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function specialtyForgikey(){
        return $this->belongsTo(Specialty::class,'specialty_id','specialty_id');
    }
}