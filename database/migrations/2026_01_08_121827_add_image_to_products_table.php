<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * MIGRACIÓN: Añadir campo de imagen a productos
     * 
     * Esta migración añade la columna 'image' a la tabla 'products'
     * para almacenar la ruta de las imágenes de productos en Custom Camis.
     * 
     * Contexto:
     * - Las imágenes se almacenan en storage/app/public
     * - Son accesibles en la web como /storage/nombre-imagen.jpg
     * - El campo es nullable para productos sin imagen
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Campo image: almacena la ruta de la imagen
            // nullable: permite que productos sin imagen no generen errores
            // afterDescription: coloca la columna después de description
            $table->string('image')->nullable()->after('description');
        });
    }

    /**
     * Revertir la migración
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
