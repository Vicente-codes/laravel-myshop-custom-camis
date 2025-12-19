<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * MIGRACIÓN: Crear tabla OFFERS
     * 
     * Esta tabla almacena las ofertas especiales con descuentos.
     * Corresponde al archivo database/data/mock-offers.php de PUD2.
     * 
     * Estructura de la tabla:
     * - id: Identificador único de la oferta
     * - name: Nombre de la oferta (ej: "Descuento por Volumen")
     * - slug: URL-friendly (ej: "descuento-volumen")
     * - discount_percentage: Porcentaje de descuento (ej: 20 para 20%)
     * - description: Descripción de la oferta y condiciones
     * - timestamps: Fechas de creación y modificación
     */
    
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            // id: Identificador único
            $table->id();
            
            // name: Nombre de la oferta
            $table->string('name');
            
            // slug: Identificador amigable para URLs
            $table->string('slug')->unique();
            
            // discount_percentage: Porcentaje de descuento (ej: 20 para 20%)
            $table->integer('discount_percentage');
            
            // description: Descripción detallada de la oferta
            $table->text('description')->nullable();
            
            // timestamps: created_at y updated_at
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
