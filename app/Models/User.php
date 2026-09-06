<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'is_active',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is owner / pemilik warung
     */
    public function isOwner()
{
    return in_array($this->role, ['pemilik_warung', 'owner']);
}

    /**
     * Check if user can access admin area (Admin or Pemilik Warung)
     */
    public function isAdminOrOwner()
{
    return in_array($this->role, ['admin', 'pemilik_warung', 'owner', 'kasir']);
}

    /**
     * Get the transaksi for the user
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }
}
