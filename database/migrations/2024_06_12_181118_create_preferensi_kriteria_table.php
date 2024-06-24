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
        Schema::create('preferensi_kriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->references('id')->on('kriteria_alternatif');
            $table->enum('tipe',['sepeda listrik','sepeda motor listrik'])->default('sepeda listrik');
            $table->integer('min_rating');
            $table->integer('max_rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferensi_kriteria');
    }
};
