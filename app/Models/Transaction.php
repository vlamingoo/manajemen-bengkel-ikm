<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'customer_id',
        'vehicle_id',
        'tanggal_servis',
        'keluhan',
        'tindakan',
        'biaya_jasa',
        'total_biaya',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_servis' => 'date',
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Relasi ke Transaction Details
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Format total biaya
    public function getFormattedTotalBiayaAttribute()
    {
        return 'Rp ' . number_format($this->total_biaya, 0, ',', '.');
    }

    // Auto generate kode transaksi
    public static function generateKode()
    {
        $lastTransaction = self::latest()->first();
        if (!$lastTransaction) {
            return 'TRX-' . date('Ymd') . '-0001';
        }
        
        $lastNumber = (int) substr($lastTransaction->kode_transaksi, -4);
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        
        return 'TRX-' . date('Ymd') . '-' . $newNumber;
    }
}