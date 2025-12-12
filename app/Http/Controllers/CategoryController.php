<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CONTROLADOR: CategoryController
 * 
 * RESPONSABILIDAD: Gestionar la navegación y visualización de categorías
 * 
 * MÉTODOS:
 *   - index(): Listar todas las categorías
 *   - show(): Mostrar productos de una categoría específica
 */
class CategoryController extends Controller
{
    use LoadsMockData;

    /**
     * MÉTODO: index()
     * 
     * PROPÓSITO: Mostrar TODAS las categorías disponibles
     * 
     * RUTA: GET /categories
     * NOMBRE DE RUTA: categories.index
     * 
     * LÓGICA:
     *   1. Cargar todas las categorías
     *   2. Enviar a la vista para mostrarlas en grid
     * 
     * RETORNA: Vista con listado de categorías
     */
    public function index(): View
    {
        // Obtener todas las categorías
        $categories = $this->getCategories();

        // Enviar a la vista 'categories.index'
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * MÉTODO: show()
     * 
     * PROPÓSITO: Mostrar todos los productos de una categoría específica
     * 
     * RUTA: GET /categories/{id}
     * NOMBRE DE RUTA: categories.show
     * 
     * PARÁMETROS:
     *   @param string $id El ID de la categoría
     * 
     * LÓGICA:
     *   1. Validar que el ID sea válido
     *   2. Cargar la categoría por su ID
     *   3. Si no existe, mostrar error 404
     *   4. Cargar todos los productos
     *   5. Filtrar solo los que pertenecen a esta categoría
     *   6. Enriquecer productos con ofertas
     *   7. Enviar a la vista
     * 
     * RETORNA: Vista con productos de la categoría o error 404
     */
    public function show(string $id): View
    {
        /**
         * Validación del ID
         * Verificamos que sea un número válido (> 0)
         */
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de categoría inválido');
        }

        // Cargar todas las categorías
        $categories = $this->getCategories();

        /**
         * Buscar la categoría específica
         */
        $category = $categories[$id] ?? null;

        // Si no existe, mostrar error 404
        if (!$category) {
            abort(404, 'Categoría no encontrada');
        }

        /**
         * Cargar todos los productos
         */
        $products = $this->getProducts();

        /**
         * Filtrar productos por categoría
         * 
         * array_filter() mantiene solo los productos cuyo 'category_id'
         * coincide con el ID de la categoría que estamos viendo
         * 
         * use($id) importa el ID dentro de la función anónima
         */
        $categoryProducts = array_filter($products, function($product) use ($id) {
            return $product['category_id'] == $id;
        });

        /**
         * Enriquecer los productos con datos de ofertas
         */
        $categoryProducts = $this->enrichProductsWithOffers($categoryProducts);

        // Enviar la categoría y sus productos a la vista
        return view('categories.show', compact('category', 'categoryProducts'));
    }
}