<?php

namespace App\Models;

use App\Models\Products\AdminComment;
use App\Models\Products\CartProduct;
use App\Models\Products\ReviewProduct;
use App\Models\ProfileDoctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'row_id'; // Khóa chính

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
    ];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'user_id', 'user_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'user_id', 'user_id');
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'phone', 'phone');
    }

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Phương thức đặt lại mật khẩu
    public static function resetUserPassword($email, $newPassword)
    {
        $user = self::where('email', $email)->first();
        if ($user) {
            $user->password = Hash::make($newPassword);
            return $user->save();
        }
        return false;
    }

    public function cart()
    {
        return $this->hasMany(CartProduct::class, 'user_id', 'user_id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }

    public function review()
    {
        return $this->hasMany(ReviewProduct::class, 'user_id', 'user_id');
    }

    public function reviewAd()
    {
        return $this->hasMany(AdminComment::class, 'user_id', 'user_id');
    }

    public function profileDoctor()
{
    return $this->hasOne(ProfileDoctor::class, 'user_id', 'user_id');
}
}
