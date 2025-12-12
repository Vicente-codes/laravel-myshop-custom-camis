<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CONTROLADOR: WelcomeController
 * 
 * RESPONSABILIDAD: Gestionar la página de inicio (/) de la tienda
 * 
 * FUNCIONALIDAD:
 *   - Mostrar productos destacados (los primeros 3)
 *   - Mostrar categorías destacadas (las primeras 4)
 *   - Presentar el contenido principal de bienvenida
 * 
 * MÉTODOS:
 *   - index(): Muestra la página de inicio
 */
class WelcomeController extends Controller
{
    /**
     * IMPORTANTE: Usamos el trait LoadsMockData para acceder a los datos
     * Esto nos permite usar los métodos:
     *   - $this->getProducts()
     *   - $this->getCategories()
     *   - $this->enrichProductsWithOffers()
     */
    use LoadsMockData;

    /**
     * MÉTODO: index()
     * 
     * PROPÓSITO: Mostrar la página de inicio
     * 
     * LÓGICA:
     *   1. Cargar todos los productos desde mock
     *   2. Cargar todas las categorías desde mock
     *   3. Enriquecer productos con datos de ofertas y precios finales
     *   4. Extraer los 3 primeros productos como "destacados"
     *   5. Extraer las 4 primeras categorías como "destacadas"
     *   6. Enviar los datos a la vista 'welcome'
     * 
     * RETORNA: Vista compilada con los datos
     */
    public function index(): View
    {
        // Paso 1: Obtener todos los productos sin procesar
        $products = $this->getProducts();
        
        // Paso 2: Obtener todas las categorías
        $categories = $this->getCategories();

        /**
         * Paso 3: Enriquecer productos
         * 
         * Esto añade a cada producto:
         *   - offer: Datos completos de la oferta (si tiene)
         *   - final_price: Precio con descuento aplicado
         */
        $enrichedProducts = $this->enrichProductsWithOffers($products);

        /**
         * Paso 4: Extraer productos destacados
         * 
         * array_slice(array, offset, length, preserve_keys)
         *   - array: el array a procesar
         *   - offset: 0 (empezamos desde el inicio)
         *   - length: 3 (queremos 3 elementos)
         *   - preserve_keys: true (mantener los IDs originales)
         * 
         * Resultado: Array con los 3 primeros productos
         */
        $featuredProducts = array_slice($enrichedProducts, 0, 3, true);

        /**
         * Paso 5: Extraer categorías destacadas
         * 
         * Mismo proceso pero con categorías y extrayendo 4
         */
        $featuredCategories = array_slice($categories, 0, 4, true);

        /**
         * Paso 6: Enviar datos a la vista
         * 
         * compact() crea un array asociativo:
         *   ['featuredProducts' => $featuredProducts, 'featuredCategories' => $featuredCategories]
         * 
         * La vista 'welcome' tiene acceso a estas variables
         */
        return view('welcome', compact('featuredProducts', 'featuredCategories'));
    }
}