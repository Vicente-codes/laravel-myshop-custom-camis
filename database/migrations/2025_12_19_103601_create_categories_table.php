<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * MIGRACIÓN: Crear tabla CATEGORIES
     * 
     * Esta tabla almacena las categorías de productos de la tienda.
     * Corresponde al archivo database/data/mock-categories.php de PUD2.
     * 
     * Estructura de la tabla:
     * - id: Identificador único (clave primaria, auto-incremental)
     * - name: Nombre de la categoría (ej: "Camisetas Básicas")
     * - slug: Identificador amigable para URLs (ej: "camisetas-basicas")
     * - description: Descripción breve de la categoría
     * - timestamps: created_at y updated_at (Laravel los crea automáticamente)
     */
    
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            // ID: Laravel le asigna una clave primaria y auto-incremental
            $table->id();
            
            // name: Nombre de la categoría (máximo 255 caracteres)
            $table->string('name');
            
            // slug: URL-friendly version del nombre (ej: camisetas-basicas)
            // unique() asegura que no haya dos categorías con el mismo slug
            $table->string('slug')->unique();
            
            // description: Texto largo para describir la categoría
            // nullable() permite que sea NULL si no se proporciona
            $table->text('description')->nullable();
            
            // timestamps: Crea created_at y updated_at automáticamente
            // Se usan para saber cuándo se creó y cuándo se modificó
            $table->timestamps();
        });
    }

    /**
     * ROLLBACK: Revertir la migración
     * 
     * Si ejecutas 'sail artisan migrate:rollback', esta función elimina la tabla
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
