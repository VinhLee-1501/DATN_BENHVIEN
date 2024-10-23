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
    protected $primaryKey = 'row_id'; // Đặt primary key nếu không phải là 'id'

    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'phone',
        'email',
        'password',
        'avatar',
        'birthday',
        'address',
        'expertise',
        'role',
        'status',
        'google_id',
        'zalo_id',
        'facebook_id',
        'email_verified_at',
        'specialty_id',
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
        'birthday' => 'date',
        'password' => 'hashed',
    ];

    /**
     * Một người dùng có thể có một chuyên khoa
     */
    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'user_id', 'user_id');
    }

    /**
     * Một người dùng có thể có nhiều lịch
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'user_id', 'user_id');
    }

    /**
     * Một người dùng có thể có một bệnh nhân
     */
    public function patient()
    {
        return $this->hasOne(Patient::class, 'phone', 'phone');
    }
}
