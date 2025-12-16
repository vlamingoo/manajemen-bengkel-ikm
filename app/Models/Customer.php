<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'no_telp',
        'alamat',
        'email'
    ];

    // Relasi ke Vehicle
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}