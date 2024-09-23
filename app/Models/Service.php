<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['service_id',
        'name', 'price', 'directory_id' //Khóa ngoaị
    ];

    public function treatmentDetail()
    {
        return $this->hasMany(TreatmentDetail::class);
    }

    public function serviceDirectoryForeignKey()
    {
        return $this->belongsTo(ServiceDirectory::class, 'directory_id', 'directory_id');
    }
}
