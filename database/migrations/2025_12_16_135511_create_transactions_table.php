<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_servis');
            $table->text('keluhan');
            $table->text('tindakan')->nullable();
            $table->decimal('biaya_jasa', 15, 2)->default(0);
            $table->decimal('total_biaya', 15, 2)->default(0);
            $table->enum('status', ['proses', 'selesai', 'diambil'])->default('proses');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};