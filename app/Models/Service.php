<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'services';
    protected $fillable = ['service_id',
        'name', 'price', 'directory_id', 'status' //Khóa ngoaị
    ];
    protected $primaryKey = 'row_id';
    public function treatmentDetail()
    {
        return $this->hasMany(TreatmentDetail::class);
    }

    public function serviceDirectoryForeignKey()
    {
        return $this->belongsTo(ServiceDirectory::class, 'directory_id', 'directory_id');
    }
}