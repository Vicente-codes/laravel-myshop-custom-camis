<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request; // ← Añadido según la práctica 3

class WelcomeController extends Controller
{
    /**
     * CONTROLADOR: WelcomeController
     * 
     * Gestiona la página de inicio (welcome) de la tienda.
     * Muestra productos y categorías destacadas.
     * 
     * CAMBIOS vs PUD2:
     * - ❌ Eliminado: use App\Traits\LoadsMockData
     * - ✅ Añadido: use App\Models\Product, use App\Models\Category
     * - ✅ Reemplazado: $this->getProducts() → Product::with(...)->get()
     * - ✅ Eliminado: $this->enrichProductsWithOffers() (Eloquent lo hace)
     */

    /**
     * INDEX: Página de inicio con contenido destacado
     * 
     * Ruta: GET /
     * Vista: resources/views/welcome.blade.php
     * 
     * OBJETIVO:
     * Mostrar en la página principal:
     * - Primeros 3 productos con oferta activa (para destacar)
     * - Primeras 4 categorías (para navegar)
     * 
     * PASOS:
     * 1. Obtener primeros 3 productos con oferta
     * 2. Obtener primeras 4 categorías
     * 3. Pasar ambos a la vista
     */
    public function index(): View
    {
        /**
         * PRODUCTOS DESTACADOS
         * 
         * whereNotNull('offer_id') → Solo productos con oferta
         * take(3) → Tomar solo los primeros 3
         * get() → Ejecutar la consulta y retornar colección
         * 
         * Consulta SQL generada:
         * SELECT * FROM products
         * WHERE offer_id IS NOT NULL
         * LIMIT 3;
         * 
         * Con eager loading:
         * - with('category', 'offer') carga relaciones sin problema N+1
         */
        $featuredProducts = Product::with(['category', 'offer'])
                                   ->whereNotNull('offer_id')
                                   ->take(3)
                                   ->get();

        /**
         * CATEGORÍAS DESTACADAS
         * 
         * take(4) → Tomar solo las primeras 4 categorías
         * get() → Ejecutar la consulta
         * 
         * Consulta SQL generada:
         * SELECT * FROM categories
         * LIMIT 4;
         */
        $featuredCategories = Category::take(4)->get();

        // Pasar datos a la vista
        return view('welcome', compact('featuredProducts', 'featuredCategories'));
    }
}