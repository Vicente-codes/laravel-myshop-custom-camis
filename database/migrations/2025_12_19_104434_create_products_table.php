<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * MIGRACIÓN: Crear tabla PRODUCTS
     * 
     * Esta tabla es el corazón de la tienda. Almacena todos los productos
     * con sus detalles, categoría y oferta aplicada.
     * Corresponde al archivo database/data/mock-products.php de PUD2.
     * 
     * Estructura de la tabla:
     * - id: Identificador único del producto
     * - name: Nombre del producto
     * - description: Descripción detallada
     * - price: Precio en euros (decimal)
     * - category_id: Clave foránea a la tabla categories
     * - offer_id: Clave foránea a la tabla offers (puede ser NULL)
     * - timestamps: Fechas de creación y modificación
     * 
     * RELACIONES:
     * - Un producto pertenece a UNA categoría (BelongsTo)
     * - Un producto puede tener UNA oferta o NINGUNA (BelongsTo nullable)
     * - Una categoría puede tener MUCHOS productos (HasMany)
     * - Una oferta puede aplicarse a MUCHOS productos (HasMany)
     */
    
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            // id: Identificador único
            $table->id();
            
            // name: Nombre del producto
            $table->string('name');
            
            // description: Descripción completa del producto
            $table->text('description');
            
            // price: Precio en euros (DECIMAL con 2 decimales)
            // DECIMAL(8,2) permite valores hasta 999999.99
            $table->decimal('price', 8, 2);
            
            /**
             * CLAVE FORÁNEA: category_id
             * 
             * Esto significa:
             * 1. Crea un campo category_id de tipo BIGINT UNSIGNED
             * 2. Este campo referencia la tabla 'categories'
             * 3. constrained() crea automáticamente la restricción de clave foránea
             * 4. onDelete('cascade') = Si se elimina la categoría, se eliminan todos sus productos
             * 
             * Ejemplo:
             * - Un producto con category_id = 1 pertenece a la categoría con id = 1
             * - Si eliminamos la categoría 1, todos los productos con category_id = 1 se eliminan
             */
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            /**
             * CLAVE FORÁNEA: offer_id (NULLABLE)
             * 
             * Esto significa:
             * 1. Crea un campo offer_id de tipo BIGINT UNSIGNED
             * 2. Este campo referencia la tabla 'offers'
             * 3. nullable() permite que sea NULL (producto sin oferta)
             * 4. onDelete('set null') = Si se elimina la oferta, el producto queda sin oferta (NULL)
             * 
             * Ejemplo:
             * - Un producto con offer_id = 1 tiene aplicada la oferta 1
             * - Un producto con offer_id = NULL no tiene oferta
             * - Si eliminamos la oferta 1, los productos quedan con offer_id = NULL
             */
            $table->foreignId('offer_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');
            
            // timestamps: created_at y updated_at
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};