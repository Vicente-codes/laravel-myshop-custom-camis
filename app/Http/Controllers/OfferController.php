<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\View\View;

/**
 * CONTROLADOR: OfferController
 * 
 * RESPONSABILIDAD:
 * Gestiona operaciones relacionadas con ofertas especiales.
 * 
 * MÉTODOS:
 * - index: Listar todas las ofertas disponibles
 * - show: Mostrar una oferta específica y sus productos
 * 
 * RUTAS:
 * - GET /offers => OfferController@index (lista de ofertas)
 * - GET /offers/{id} => OfferController@show (detalle de oferta y productos)
 */

class OfferController extends Controller
{
    // Importamos el trait para acceso a métodos de datos mock
    use LoadsMockData;

    /**
     * MÉTODO: index()
     * 
     * DESCRIPCIÓN:
     * Muestra un listado de TODAS las ofertas disponibles en la tienda.
     * Permite al usuario ver todas las promociones activas.
     * 
     * PASOS:
     * 1. Carga todas las ofertas desde el mock
     * 2. Retorna la vista offers.index con todas las ofertas
     * 
     * RETORNA: Vista offers/index.blade.php con:
     * - $offers: array con todas las ofertas
     */
    public function index(): View
    {
        // PASO 1: Cargar todas las ofertas
        $offers = $this->getOffers();

        // PASO 2: Retornar la vista con las ofertas
        return view('offers.index', compact('offers'));
    }

    /**
     * MÉTODO: show()
     * 
     * DESCRIPCIÓN:
     * Muestra los PRODUCTOS que tienen una oferta específica aplicada.
     * 
     * PASOS:
     * 1. Obtiene el ID de la oferta de la URL
     * 2. Valida que el ID sea un número válido
     * 3. Carga todas las ofertas
     * 4. Busca la oferta con ese ID
     * 5. Valida que la oferta exista
     * 6. Carga todos los productos
     * 7. FILTRA: Mantiene solo los productos cuyo offer_id coincida
     * 8. Enriquece los productos filtrados con datos de ofertas
     * 9. Retorna la vista show con la oferta y sus productos
     * 
     * PARÁMETRO: $id - ID de la oferta (de la URL)
     * 
     * RETORNA: Vista offers/show.blade.php con:
     * - $offer: array con datos de la oferta
     * - $offerProducts: array con productos de esa oferta
     * 
     * O: Error 404 si la oferta no existe
     */
    public function show(string $id): View
    {
        // PASO 1: Validar que el ID sea un número
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de oferta inválido');
        }

        // PASO 2: Cargar todas las ofertas
        $offers = $this->getOffers();

        // PASO 3: Buscar la oferta con ese ID
        $offer = $offers[$id] ?? null;

        // PASO 4: Validar que la oferta exista
        if (!$offer) {
            abort(404, 'Oferta no encontrada');
        }

        // PASO 5: Cargar todos los productos
        $products = $this->getProducts();

        // PASO 6: FILTRAR: Mantener solo productos de esta oferta
        // Recordar: Un producto solo puede tener UNA oferta (relación 1:N)
        $offerProducts = array_filter($products, function ($product) use ($id) {
            return $product['offer_id'] == $id;
        });

        // PASO 7: Enriquecer los productos filtrados
        $offerProducts = $this->enrichProductsWithOffers($offerProducts);

        // PASO 8: Retornar la vista con la oferta y sus productos
        return view('offers.show', compact('offer', 'offerProducts'));
    }
}