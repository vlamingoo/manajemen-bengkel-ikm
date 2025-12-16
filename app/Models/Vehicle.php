<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'merk',
        'model',
        'no_plat',
        'tahun',
        'warna'
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}