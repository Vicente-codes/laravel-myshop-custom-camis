<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * MODELO: Category
     * 
     * Representa una categoría de productos en la tienda.
     * Corresponde a la tabla 'categories' en la base de datos.
     * Migración relacionada: database/migrations/*_create_categories_table.php
     */

    /**
     * CAMPOS ASIGNABLES
     * 
     * fillable define qué campos pueden ser asignados masivamente.
     * Importante para seguridad: evita asignación masiva de campos peligrosos.
     * 
     * Uso:
     * - Category::create(['name' => 'Camisetas', 'slug' => 'camisetas', ...])
     * 
     * Campos permitidos:
     * - name: Nombre de la categoría
     * - slug: URL-friendly version
     * - description: Descripción de la categoría
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * RELACIÓN: Una categoría tiene MUCHOS productos
     * 
     * Tipo de relación: HasMany (1:N)
     * 
     * Métodos disponibles:
     * - $category->products = Obtiene todos los productos de la categoría
     * - $category->products()->count() = Cantidad de productos
     * - $category->products()->where('offer_id', '!=', null)->get() = Filtrar productos
     * 
     * En la tabla products hay un campo category_id que referencia esta categoría
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
