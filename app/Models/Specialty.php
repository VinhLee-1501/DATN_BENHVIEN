<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialty extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'specialty_id';
    protected $keyType = 'string';



    protected $fillable = ['specialty_id', 'name', 'status'];

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function books()
    {
        return $this->hasMany(Book::class, 'specialty_id'); // Mối quan hệ 1-n với bảng 'books'
    }
}
