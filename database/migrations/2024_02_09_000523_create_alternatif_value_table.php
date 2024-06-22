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
        Schema::create('alternatif_value', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->references('id')->on('kriteria_alternatif')->onDelete('cascade');
            $table->foreignId('alternatif_id')->references('id')->on('sepeda_listrik')->onDelete('cascade');
            $table->integer('value')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatif_value');
    }
};
