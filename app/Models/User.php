<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 👈 PASTIKAN INI ADA
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 👇 TAMBAHKAN METHOD INI
    public function adminlte_desc()
    {
        return strtoupper($this->role);
    }

    // Method untuk cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKaryawan()
    {
        return $this->role === 'karyawan';
    }

    public function isOwner()
    {
        return $this->role === 'owner';
    }
}

// user.php baru