<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\View\View;

/**
 * CONTROLADOR: CategoryController
 * 
 * RESPONSABILIDAD:
 * Gestiona operaciones relacionadas con categorías de productos.
 * 
 * MÉTODOS:
 * - index: Listar todas las categorías
 * - show: Mostrar todos los productos de una categoría específica
 * 
 * RUTAS:
 * - GET /categories => CategoryController@index (lista de categorías)
 * - GET /categories/{id} => CategoryController@show (productos de categoría)
 */

class CategoryController extends Controller
{
    // Importamos el trait para acceso a métodos de datos mock
    use LoadsMockData;

    /**
     * MÉTODO: index()
     * 
     * DESCRIPCIÓN:
     * Muestra un listado de TODAS las categorías disponibles en la tienda.
     * Permite al usuario explorar y filtrar productos por categoría.
     * 
     * PASOS:
     * 1. Carga todas las categorías desde el mock
     * 2. Retorna la vista categories.index con todas las categorías
     * 
     * RETORNA: Vista categories/index.blade.php con:
     * - $categories: array con todas las categorías
     */
    public function index(): View
    {
        // PASO 1: Cargar todas las categorías
        $categories = $this->getCategories();

        // PASO 2: Retornar la vista con las categorías
        return view('categories.index', compact('categories'));
    }

    /**
     * MÉTODO: show()
     * 
     * DESCRIPCIÓN:
     * Muestra todos los PRODUCTOS pertenecientes a una categoría específica.
     * 
     * PASOS:
     * 1. Obtiene el ID de la categoría de la URL
     * 2. Valida que el ID sea un número válido
     * 3. Carga todas las categorías
     * 4. Busca la categoría con ese ID
     * 5. Valida que la categoría exista
     * 6. Carga todos los productos
     * 7. FILTRA: Mantiene solo los productos cuya category_id coincida
     * 8. Enriquece los productos filtrados con datos de ofertas
     * 9. Retorna la vista show con la categoría y sus productos
     * 
     * PARÁMETRO: $id - ID de la categoría (de la URL)
     * 
     * RETORNA: Vista categories/show.blade.php con:
     * - $category: array con datos de la categoría
     * - $categoryProducts: array con productos de esa categoría
     * 
     * O: Error 404 si la categoría no existe
     */
    public function show(string $id): View
    {
        // PASO 1: Validar que el ID sea un número
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de categoría inválido');
        }

        // PASO 2: Cargar todas las categorías
        $categories = $this->getCategories();

        // PASO 3: Buscar la categoría con ese ID
        $category = $categories[$id] ?? null;

        // PASO 4: Validar que la categoría exista
        if (!$category) {
            abort(404, 'Categoría no encontrada');
        }

        // PASO 5: Cargar todos los productos
        $products = $this->getProducts();

        // PASO 6: FILTRAR: Mantener solo productos de esta categoría
        // array_filter aplica una función a cada producto
        // Mantenemos solo los donde category_id == id de categoría
        $categoryProducts = array_filter($products, function ($product) use ($id) {
            return $product['category_id'] == $id;
        });

        // PASO 7: Enriquecer los productos filtrados
        $categoryProducts = $this->enrichProductsWithOffers($categoryProducts);

        // PASO 8: Retornar la vista con la categoría y sus productos
        return view('categories.show', compact('category', 'categoryProducts'));
    }
}