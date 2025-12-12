<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CONTROLADOR: OfferController
 * 
 * RESPONSABILIDAD: Gestionar la visualización de ofertas
 * 
 * MÉTODOS:
 *   - index(): Listar todas las ofertas
 *   - show(): Mostrar productos con una oferta específica
 */
class OfferController extends Controller
{
    use LoadsMockData;

    /**
     * MÉTODO: index()
     * 
     * PROPÓSITO: Mostrar TODAS las ofertas disponibles
     * 
     * RUTA: GET /offers
     * NOMBRE DE RUTA: offers.index
     * 
     * LÓGICA:
     *   1. Cargar todas las ofertas
     *   2. Enviar a la vista
     * 
     * RETORNA: Vista con listado de ofertas
     */
    public function index(): View
    {
        // Obtener todas las ofertas
        $offers = $this->getOffers();

        // Enviar a la vista 'offers.index'
        return view('offers.index', ['offers' => $offers]);
    }

    /**
     * MÉTODO: show()
     * 
     * PROPÓSITO: Mostrar los productos que tienen una oferta específica
     * 
     * RUTA: GET /offers/{id}
     * NOMBRE DE RUTA: offers.show
     * 
     * PARÁMETROS:
     *   @param string $id El ID de la oferta
     * 
     * LÓGICA:
     *   1. Validar que el ID sea válido
     *   2. Cargar la oferta por su ID
     *   3. Si no existe, mostrar error 404
     *   4. Cargar todos los productos
     *   5. Filtrar solo los que tienen esta oferta
     *   6. Enriquecer productos con datos completos
     *   7. Enviar a la vista
     * 
     * RETORNA: Vista con productos de la oferta o error 404
     */
    public function show(string $id): View
    {
        /**
         * Validación del ID
         * Verificamos que sea un número válido (> 0)
         */
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de oferta inválido');
        }

        // Cargar todas las ofertas
        $offers = $this->getOffers();

        /**
         * Buscar la oferta específica
         */
        $offer = $offers[$id] ?? null;

        // Si no existe, mostrar error 404
        if (!$offer) {
            abort(404, 'Oferta no encontrada');
        }

        /**
         * Cargar todos los productos
         */
        $products = $this->getProducts();

        /**
         * Filtrar productos por oferta
         * 
         * Un producto solo puede tener UNA oferta
         * Así que filtramos aquellos cuyo 'offer_id' es igual al ID de la oferta actual
         */
        $offerProducts = array_filter($products, function($product) use ($id) {
            return $product['offer_id'] == $id;
        });

        /**
         * Enriquecer los productos con datos completos de la oferta
         */
        $offerProducts = $this->enrichProductsWithOffers($offerProducts);

        // Enviar la oferta y sus productos a la vista
        return view('offers.show', compact('offer', 'offerProducts'));
    }
}