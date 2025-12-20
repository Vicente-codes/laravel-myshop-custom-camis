<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use LoadsMockData;

    /**
     * SEEDER: Categorías
     * 
     * Este seeder reutiliza los datos mock de PUD2 para poblar la tabla categories.
     * 
     * Flujo:
     * 1. Carga los datos desde database/data/mock-categories.php (PUD2)
     * 2. Itera sobre cada categoría
     * 3. Inserta cada una en la tabla categories
     * 
     * LoadsMockData: Trait creado en PUD2 que proporciona métodos para cargar archivos mock
     */
    
    public function run(): void
    {
        /**
         * CARGAR DATOS MOCK
         * 
         * $this->getCategories() es un método del trait LoadsMockData
         * Carga el archivo database/data/mock-categories.php y retorna un array
         * 
         * Ejemplo de datos mock:
         * [
         *     1 => ['id' => 1, 'name' => 'Camisetas Básicas', 'slug' => 'camisetas-basicas', ...],
         *     2 => ['id' => 2, 'name' => 'Camisetas Personalizadas', ...],
         *     ...
         * ]
         */
        $categories = $this->getCategories();

        /**
         * INSERTAR DATOS EN LA BD
         * 
         * Itera sobre cada categoría del array mock
         * Category::create() inserta cada una en la tabla categories
         * El parámetro se expande (spread operator) para descomponer el array
         */
        foreach ($categories as $category) {
            /**
             * Category::create($category)
             * 
             * Crea una nueva fila en la tabla categories con los datos del array
             * Solo inserta los campos definidos en $fillable del modelo
             * 
             * Ejemplo:
             * Category::create([
             *     'id' => 1,
             *     'name' => 'Camisetas Básicas',
             *     'slug' => 'camisetas-basicas',
             *     'description' => '...'
             * ])
             * 
             * IMPORTANTE: El campo 'id' NO se inserta automaticamente en Laravel.
             * Para preservar los IDs de los datos mock, debemos desactivar
             * la validación de claves foráneas durante el seeding:
             * 
             * En DatabaseSeeder:
             * Schema::disableForeignKeyConstraints();
             * $this->call(...);
             * Schema::enableForeignKeyConstraints();
             */
            Category::create($category);
        }

        /**
         * RESULTADO FINAL
         * 
         * Se insertan todas las categorías de database/data/mock-categories.php
         * en la tabla categories con los mismos IDs y datos.
         * 
         * Ejemplo:
         * INSERT INTO categories (id, name, slug, description, created_at, updated_at)
         * VALUES (1, 'Camisetas Básicas', 'camisetas-basicas', '...', NOW(), NOW());
         */
    }
}
