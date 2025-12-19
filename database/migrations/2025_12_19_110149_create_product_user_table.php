<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * MIGRACIÓN: Crear tabla PRODUCT_USER (Tabla Pivot)
     * 
     * Esta tabla implementa la relación Many-to-Many (N:M) entre productos y usuarios.
     * Corresponde al archivo database/data/mock-cart.php de PUD2.
     * 
     * ¿Qué es una tabla pivot?
     * Una tabla pivot conecta dos tablas y permite relaciones muchos-a-muchos:
     * - Un producto puede estar en MUCHOS carritos (de diferentes usuarios)
     * - Un usuario puede tener MUCHOS productos en su carrito
     * 
     * Estructura de la tabla:
     * - product_id: Clave foránea a la tabla products
     * - user_id: Clave foránea a la tabla users
     * - quantity: Cantidad de ese producto en el carrito de ese usuario (campo adicional)
     * - timestamps: created_at y updated_at (cuándo se añadió al carrito)
     * 
     * Relación:
     * usuario1 --[producto1, cantidad 2]-- carrito
     * usuario1 --[producto5, cantidad 1]-- carrito
     * usuario2 --[producto1, cantidad 3]-- carrito
     * 
     * Convención de Laravel:
     * - Las tablas pivot se nombran en singular alfabético: product_user
     * - No userproduct (que sería el orden alfabético invertido)
     */
    
    public function up(): void
    {
        Schema::create('product_user', function (Blueprint $table) {
            /**
             * CLAVE FORÁNEA: product_id
             * 
             * Referencia a la tabla products
             * Si eliminamos un producto, se eliminan sus entradas en el carrito
             */
            $table->foreignId('product_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            /**
             * CLAVE FORÁNEA: user_id
             * 
             * Referencia a la tabla users (tabla nativa de Laravel)
             * Si eliminamos un usuario, se eliminan sus items del carrito
             */
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            /**
             * CAMPO ADICIONAL: quantity
             * 
             * Cantidad de ese producto en el carrito del usuario
             * Ejemplo: usuario1 tiene 2 unidades del producto1 en su carrito
             * default(1) = Si no se especifica, por defecto 1 unidad
             */
            $table->integer('quantity')->default(1);
            
            /**
             * TIMESTAMPS DE LA TABLA PIVOT
             * 
             * Registran cuándo se añadió el producto al carrito
             * useCurrent() = La fecha/hora actual es el valor por defecto
             * 
             * Ejemplo:
             * - created_at: 2025-01-15 10:30:00 (cuando se añadió al carrito)
             * - updated_at: 2025-01-15 11:45:00 (cuando se modificó la cantidad)
             */
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            
            /**
             * CLAVE PRIMARIA COMPUESTA
             * 
             * En una tabla pivot, la clave primaria es la combinación de ambas claves foráneas
             * Garantiza que NO HAYA DUPLICADOS:
             * - NO puedes tener el mismo producto dos veces en el carrito del mismo usuario
             * - Pero SÍ puedes tener el mismo producto en carritos de diferentes usuarios
             */
            $table->primary(['product_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_user');
    }
};
