<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use LoadsMockData;

    /**
     * SEEDER: Productos
     * 
     * Inserta los productos de PUD2 en la tabla products.
     * 
     * IMPORTANTE: Los productos deben insertarse DESPUÉS de categorías y ofertas
     * porque tienen claves foráneas que referencian esas tablas.
     * 
     * Orden correcto de seeding:
     * 1. Users (tabla independiente)
     * 2. Categories (tabla independiente)
     * 3. Offers (tabla independiente)
     * 4. Products (depende de categories y offers)
     * 5. Product-User (depende de products y users)
     */
    
    public function run(): void
    {
        // Cargar productos desde database/data/mock-products.php
        $products = $this->getProducts();

        // Insertar cada producto en la tabla products
        foreach ($products as $product) {
            /**
             * Product::create($product)
             * 
             * Inserta el producto con su category_id y offer_id.
             * Laravel automáticamente:
             * 1. Valida que la categoría exista (clave foránea)
             * 2. Valida que la oferta exista si offer_id !== null
             * 3. Inserta el registro en la tabla products
             * 
             * Ejemplo de datos mock:
             * [
             *     'id' => 1,
             *     'name' => 'Camiseta Básica Blanca',
             *     'description' => '...',
             *     'price' => 8.50,
             *     'category_id' => 1,     // Referencia a category con id=1
             *     'offer_id' => 1,        // Referencia a offer con id=1
             * ]
             */
            Product::create($product);
        }
    }
}
