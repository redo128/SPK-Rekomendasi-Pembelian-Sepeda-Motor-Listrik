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
        Schema::create('sepeda_listrik', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sepeda', 100);
            $table->enum('tipe',['sepeda listrik','sepeda motor listrik'])->default('sepeda listrik');
            $table->foreignId('toko_id')->references('id')->on('toko');
            $table->foreignId('brand_id')->references('id')->on('brand');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sepeda_listrik');
    }
};
