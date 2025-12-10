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
        Schema::create('cuti_izin', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');

            $table->enum('jenis', ['cuti', 'sakit', 'dinas']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('alasan');
            $table->string('bukti', 255)->nullable();

            $table->uuid('disetujui_oleh')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected']);

            $table->timestamps();

            $table->index(['user_id', 'tanggal_mulai', 'tanggal_selesai']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('disetujui_oleh')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti_izin');
    }
};
