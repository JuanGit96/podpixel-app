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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            // Nombre de la ciudad
            $table->string('name');
            // Latitud con precisión suficiente
            $table->decimal('latitude', 10, 8);
            // Longitud con precisión suficiente
            $table->decimal('longitude', 11, 8);
            // Ruta de la imagen almacenada
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
