<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\View\View;

/**
 * CONTROLADOR: WelcomeController
 * 
 * RESPONSABILIDAD:
 * Este controlador gestiona la página de inicio (bienvenida) de la tienda.
 * Su tarea es:
 * 1. Cargar los datos de productos y categorías
 * 2. Procesar/enriquecer los datos (aplicar ofertas, etc)
 * 3. Seleccionar los datos destacados
 * 4. Pasar esos datos a la vista welcome.blade.php
 * 
 * RUTAS:
 * - GET / => WelcomeController@index (página de inicio)
 */

class WelcomeController extends Controller
{
    // Importamos el trait para acceso a métodos de datos mock
    use LoadsMockData;

    /**
     * MÉTODO: index()
     * 
     * DESCRIPCIÓN:
     * Muestra la página de inicio con contenido destacado.
     * 
     * PASOS QUE REALIZA:
     * 1. Carga todos los productos desde el mock
     * 2. Enriquece los productos con datos de ofertas y precios finales
     * 3. Selecciona los primeros 3 productos para destacar
     * 4. Carga todas las categorías
     * 5. Selecciona las primeras 4 categorías para destacar
     * 6. Retorna la vista welcome con los datos destacados
     * 
     * RETORNA: Vista welcome.blade.php con datos de:
     * - $featuredProducts: array con los 3 primeros productos
     * - $featuredCategories: array con las 4 primeras categorías
     */
    public function index(): View
    {
        // PASO 1: Cargar todos los productos
        $products = $this->getProducts();

        // PASO 2: Enriquecer productos con ofertas y precios finales
        // Esto añade a cada producto: 'offer' y 'final_price'
        $enrichedProducts = $this->enrichProductsWithOffers($products);

        // PASO 3: Seleccionar los primeros 3 productos para destacar
        // array_slice(array, offset, length, preserve_keys)
        // offset=0: empezar desde el inicio
        // length=3: tomar 3 elementos
        // true: mantener las claves numéricas
        $featuredProducts = array_slice($enrichedProducts, 0, 3, true);

        // PASO 4: Cargar todas las categorías
        $categories = $this->getCategories();

        // PASO 5: Seleccionar las primeras 4 categorías
        $featuredCategories = array_slice($categories, 0, 4, true);

        // PASO 6: Retornar la vista welcome con los datos
        return view('welcome', compact('featuredProducts', 'featuredCategories'));
    }
}