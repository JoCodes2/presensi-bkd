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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->enum('jenis', [
                'terlambat',
                'alpha',
                'lupa_absen_pulang', // Tambahkan ini
                'tidak_hadir',       // Tambahkan ini (opsional jika ingin beda dengan alpha)
                'pelanggaran_izin',
                'pelanggaran_cuti',
                'verifikasi_akun',
                'pengajuan_cuti',
                'sistem',
                'face_recognition'
            ]);
            $table->text('pesan');
            $table->boolean('is_dibaca')->default(false);
            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
