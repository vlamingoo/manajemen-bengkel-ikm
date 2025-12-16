<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_sparepart',
        'nama_sparepart',
        'stok',
        'harga',
        'satuan',
        'keterangan'
    ];

    // Format harga untuk tampilan
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}