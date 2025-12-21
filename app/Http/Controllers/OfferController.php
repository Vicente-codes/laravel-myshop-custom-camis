<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Product; // ← Añadido según la práctica 3
use Illuminate\Http\Request; // ← Añadido según la práctica 3
use Illuminate\View\View;

class OfferController extends Controller
{
    /**
     * CONTROLADOR: OfferController
     * 
     * Gestiona operaciones relacionadas con ofertas especiales.
     * 
     * CAMBIOS vs PUD2:
     * - ❌ Eliminado: use App\Traits\LoadsMockData
     * - ✅ Añadido: use App\Models\Offer
     * - ✅ Reemplazado: $this->getOffers() → Offer::all()
     */

    /**
     * INDEX: Listar todas las ofertas
     * 
     * Ruta: GET /offers
     * Vista: resources/views/offers/index.blade.php
     */
    public function index(): View
    {
        // Obtener todas las ofertas de la base de datos
        $offers = Offer::all();

        // Pasar las ofertas a la vista
        return view('offers.index', compact('offers'));
    }

    /**
     * SHOW: Mostrar productos de una oferta específica
     * 
     * Ruta: GET /offers/{id}
     * Parámetro: id de la oferta
     */
    public function show(string $id): View
    {
        // Validar que el ID sea un número
        if (!is_numeric($id)) {
            abort(404, 'ID de oferta inválido');
        }

        // Obtener la oferta
        $offer = Offer::find($id);

        // Validar que existe
        if (!$offer) {
            abort(404, 'Oferta no encontrada');
        }

        /**
         * OBTENER PRODUCTOS CON ESTA OFERTA
         * 
         * $offer->products utiliza la relación:
         * public function products() { return $this->hasMany(Product::class); }
         * 
         * Con eager loading 'with' para cargar categorías sin problema N+1
         */
        $offerProducts = $offer->products()->with('category')->get();

        // Pasar datos a la vista
        return view('offers.show', compact('offer', 'offerProducts'));
    }
}
