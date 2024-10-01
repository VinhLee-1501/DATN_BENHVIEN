<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Schedule extends Model
{
    protected $primaryKey = 'shift_id';
    protected $keyType = 'string';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shift_id',
        'note',
        'status',
        'time',
        'day',
        'user_id'
    ];

    public function userForeignKey()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function book()
    {
        return $this->hasOne(Book::class, 'shift_id', 'shift_id');
    }
}
