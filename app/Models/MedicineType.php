<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineType extends Model
{
    protected $primaryKey = 'medicine_type_id';
    protected $keyType = 'string';
    use HasFactory;

    protected $fillable = ['medicine_type_id', 'name', 'status'];

    public function medicine()
    {
        return $this->hasMany(Medicine::class);
    }
}