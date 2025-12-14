<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jam_kerja', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_shift', 100);
            $table->time('jam_masuk');
            $table->time('jam_keluar');
            $table->time('batas_terlambat')->nullable();
            $table->boolean('senin_kerja');
            $table->boolean('selasa_kerja');
            $table->boolean('rabu_kerja');
            $table->boolean('kamis_kerja');
            $table->boolean('jumat_kerja');
            $table->boolean('sabtu_kerja');
            $table->boolean('minggu_kerja');

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_kerja');
    }
};
