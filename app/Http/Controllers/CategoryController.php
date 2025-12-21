<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use App\Models\Product; // ← Añadido según la práctica 3 
use Illuminate\Http\Request; // ← Añadido según la práctica 3

class CategoryController extends Controller
{
    /**
     * CONTROLADOR: CategoryController
     * 
     * Gestiona operaciones relacionadas con categorías de productos.
     * 
     * CAMBIOS vs PUD2:
     * - ❌ Eliminado: use App\Traits\LoadsMockData
     * - ✅ Añadido: use App\Models\Category
     * - ✅ Reemplazado: $this->getCategories() → Category::all()
     */

    /**
     * INDEX: Listar todas las categorías
     * 
     * Ruta: GET /categories
     * Vista: resources/views/categories/index.blade.php
     */
    public function index(): View
    {
        // Obtener todas las categorías de la base de datos
        $categories = Category::all();

        // Pasar las categorías a la vista
        return view('categories.index', compact('categories'));
    }

    /**
     * SHOW: Mostrar productos de una categoría específica
     * 
     * Ruta: GET /categories/{id}
     * Parámetro: id de la categoría
     * 
     * PASOS:
     * 1. Validar ID
     * 2. Obtener la categoría
     * 3. Obtener productos de esa categoría
     * 4. Pasar datos a la vista
     */
    public function show(string $id): View
    {
        // Validar que el ID sea un número
        if (!is_numeric($id)) {
            abort(404, 'ID de categoría inválido');
        }

        // Obtener la categoría
        $category = Category::find($id);

        // Validar que existe
        if (!$category) {
            abort(404, 'Categoría no encontrada');
        }

        /**
         * OBTENER PRODUCTOS DE LA CATEGORÍA
         * 
         * $category->products utiliza la relación definida en el modelo Category:
         * public function products() { return $this->hasMany(Product::class); }
         * 
         * Con eager loading 'with' para cargar ofertas sin problema N+1
         */
        $categoryProducts = $category->products()->with('offer')->get();

        // Pasar datos a la vista
        return view('categories.show', compact('category', 'categoryProducts'));
    }
}