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
        Schema::create('dinamis_perbandingan_kriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('kriteria_1')->references('id')->on('kriteria_alternatif');
            $table->foreignId('kriteria_2')->references('id')->on('kriteria_alternatif');
            $table->float('rating')->default(0);
            $table->enum('status',['dipilih','tidak dipilih'])->default('dipilih');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dinamis_perbandingan_kriteria');
    }
};
