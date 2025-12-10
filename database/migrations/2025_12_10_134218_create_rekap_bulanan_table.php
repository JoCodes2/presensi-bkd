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
        Schema::create('rekap_bulanan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->integer('bulan');
            $table->integer('tahun');

            $table->integer('total_hadir')->default(0);
            $table->integer('total_terlambat')->default(0);
            $table->integer('total_alpha')->default(0);
            $table->integer('total_cuti')->default(0);
            $table->integer('total_sakit')->default(0);
            $table->integer('total_dinas')->default(0);
            $table->integer('total_menit_terlambat')->default(0);

            $table->timestamps();

            $table->unique(['user_id', 'bulan', 'tahun']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_bulanan');
    }
};
