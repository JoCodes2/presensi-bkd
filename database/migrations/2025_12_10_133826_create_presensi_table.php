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
        Schema::create('presensi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->date('tanggal');

            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();

            $table->decimal('lokasi_masuk_lat', 10, 8)->nullable();
            $table->decimal('lokasi_masuk_long', 11, 8)->nullable();
            $table->decimal('lokasi_keluar_lat', 10, 8)->nullable();
            $table->decimal('lokasi_keluar_long', 11, 8)->nullable();

            $table->string('foto_masuk_path', 255)->nullable();
            $table->string('foto_keluar_path', 255)->nullable();

            $table->boolean('face_match_masuk')->nullable()->default(false);
            $table->boolean('face_match_keluar')->nullable()->default(false);

            $table->decimal('face_score_masuk', 5, 2)->nullable();
            $table->decimal('face_score_keluar', 5, 2)->nullable();

            $table->enum('status_masuk', ['tepat_waktu', 'terlambat', 'tidak_absen'])->default('tidak_absen');
            $table->enum('status_keluar', ['tepat_waktu', 'pulang_cepat', 'tidak_absen'])->default('tidak_absen');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'tanggal']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
