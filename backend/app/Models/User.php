<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * الحقول القابلة للتعبئة (mass assignable)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role', // جديد: لتحديد دور المستخدم
    ];

    /**
     * الحقول المخفية عند الإرجاع (serialization)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * نوع الحقول (casting)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * علاقة طلبات ترقية المستخدم (إذا أنشأت جدول UpgradeRequests)
     */
    public function upgradeRequests()
    {
        return $this->hasMany(UpgradeRequest::class);
    }

    /**
     * علاقة الطلبات (Orders) للمستخدم
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * تحقق إذا كان المستخدم Admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    /**
     * تحقق إذا كان المستخدم Organizer
     */
    public function isOrganizer(): bool
    {
        return $this->role === 'Organizer';
    }

    /**
     * تحقق إذا كان المستخدم Attendee
     */
    public function isAttendee(): bool
    {
        return $this->role === 'Attendee';
    }
}
