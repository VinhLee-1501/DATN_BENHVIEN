<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TableShift extends Model
{
    protected $primaryKey = 'row_id';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shift_id',
        'name',
        'status'
    ];

    public function shiftForeignKey()
    {
        return $this->belongsTo(Schedule::class, 'shift_id', 'shift_id');
    }
}
