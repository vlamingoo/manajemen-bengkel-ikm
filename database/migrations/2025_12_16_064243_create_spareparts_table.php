<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sparepart')->unique();
            $table->string('nama_sparepart');
            $table->integer('stok');
            $table->decimal('harga', 10, 2);
            $table->string('satuan')->default('pcs'); // pcs, set, unit
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spareparts');
    }
};