<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceDirectory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['directory_id', 'name', 'status'];
    protected $primaryKey = 'row_id';

    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
