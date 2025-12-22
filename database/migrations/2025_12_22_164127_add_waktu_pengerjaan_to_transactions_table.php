<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('jenis_servis_id')->nullable()->after('biaya_jasa'); // ringan/berat
            $table->decimal('waktu_pengerjaan', 8, 2)->nullable()->after('jenis_servis_id'); // Support desimal
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['jenis_servis_id', 'waktu_pengerjaan']);
        });
    }
};