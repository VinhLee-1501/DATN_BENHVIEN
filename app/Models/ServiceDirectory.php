<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDirectory extends Model
{
    use HasFactory;

    protected $fillable = ['directory_id', 'name', 'status'];

    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
