<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

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
