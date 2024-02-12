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
        Schema::create('perbandingan_kriteria', function (Blueprint $table) {
            $table->id();
            // $table->unsignedSmallInteger('kriteria_1');
            $table->foreignId('kriteria_1')->references('id')->on('kriteria_alternatif');
            // $table->unsignedSmallInteger('kriteria_2');
            $table->foreignId('kriteria_2')->references('id')->on('kriteria_alternatif');
            $table->float('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bobot_kriteria');
    }
};
