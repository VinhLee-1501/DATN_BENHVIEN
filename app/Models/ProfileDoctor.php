<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileDoctor extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'row_id'; // Khóa chính

    protected $fillable = [
        'description',
        'work_experience',
        'degree',
        'user_id' // Khóa ngoại
    ];
}
