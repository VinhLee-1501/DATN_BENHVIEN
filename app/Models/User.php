<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'row_id';
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'phone',
        'email',
        'password',
        'avatar',
        'expertise',
        'role',
        'status',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Dùng hashed để mã hóa mật khẩu
    ];

    public function specialtyForeignKey()
    {
        return $this->belongsTo(Specialty::class, 'user_id', 'user_id');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'user_id', 'user_id');
    }
}
