<?php

namespace Database\Seeders;

use App\Models\User;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class ProductUserSeeder extends Seeder
{
    use LoadsMockData;

    /**
     * SEEDER: Carrito (Tabla Pivot Product-User)
     * 
     * Inserta los items del carrito usando la relación Many-to-Many.
     * 
     * IMPORTANTE: Este seeder debe ejecutarse ÚLTIMO
     * porque depende de:
     * 1. Tabla users (creada en UserSeeder)
     * 2. Tabla products (creada en ProductSeeder)
     * 3. Tabla product_user (tabla pivot)
     * 
     * Método attach() de Eloquent:
     * Permite añadir registros a una tabla pivot.
     * Sintaxis: $user->products()->attach($productId, ['quantity' => $qty]);
     * 
     * Significa: "Añade el producto al carrito del usuario con esa cantidad"
     */
    
    public function run(): void
    {
        /**
         * CARGAR ITEMS DEL CARRITO
         * 
         * $this->getCart() carga el archivo database/data/mock-cart.php
         * que contiene los items del carrito del usuario demo
         * 
         * Estructura de datos mock:
         * [
         *     1 => ['id' => 1, 'product_id' => 1, 'quantity' => 2, 'added_at' => '...'],
         *     2 => ['id' => 2, 'product_id' => 10, 'quantity' => 1, 'added_at' => '...'],
         *     ...
         * ]
         */
        $cartItems = $this->getCart();

        /**
         * OBTENER EL USUARIO DEMO
         * 
         * En UserSeeder creamos un usuario con email 'demo@example.com'
         * Obtenemos su instancia del modelo para asociarle los productos
         */
        $user = User::first();

        /**
         * INSERTAR ITEMS EN EL CARRITO
         * 
         * Itera sobre cada item del carrito y lo añade al usuario
         */
        foreach ($cartItems as $item) {
            /**
             * MÉTODO attach() de Eloquent
             * 
             * Sintaxis: $user->products()->attach($productId, $pivotData);
             * 
             * Parámetro 1: $item['product_id']
             *   - El ID del producto a añadir
             *   - Ejemplo: 1, 10, 5
             * 
             * Parámetro 2: ['quantity' => $item['quantity']]
             *   - Datos adicionales para la tabla pivot
             *   - 'quantity' es el campo adicional en product_user
             *   - Ejemplo: ['quantity' => 2]
             * 
             * Resultado: Inserta una fila en la tabla product_user
             * INSERT INTO product_user (product_id, user_id, quantity, created_at, updated_at)
             * VALUES ($productId, $userId, $quantity, NOW(), NOW());
             * 
             * Ejemplo:
             * INSERT INTO product_user (product_id, user_id, quantity, created_at, updated_at)
             * VALUES (1, 1, 2, 2025-01-15 10:30:00, 2025-01-15 10:30:00);
             * 
             * Significado: Usuario 1 (demo) tiene 2 unidades del producto 1 en su carrito
             */
            $user->products()->attach($item['product_id'], [
                'quantity' => $item['quantity'],
            ]);
        }
    }
}
