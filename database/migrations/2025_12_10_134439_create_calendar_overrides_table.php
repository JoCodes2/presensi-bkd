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
        Schema::create('calendar_overrides', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->date('tanggal');

            $table->enum('jenis_override', ['cuti', 'sakit', 'dinas']);
            $table->uuid('sumber_id');
            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'tanggal']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sumber_id')->references('id')->on('cuti_izin')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calender_overide');
    }
};
