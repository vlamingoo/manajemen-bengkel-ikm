<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'sparepart_id',
        'qty',
        'harga',
        'subtotal'
    ];

    // Relasi ke Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi ke Sparepart
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}