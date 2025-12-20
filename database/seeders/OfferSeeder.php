<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    use LoadsMockData;

    /**
     * SEEDER: Ofertas
     * 
     * Inserta las ofertas especiales de PUD2 en la tabla offers.
     * Mismo patrón que CategorySeeder.
     */
    
    public function run(): void
    {
        // Cargar ofertas desde database/data/mock-offers.php
        $offers = $this->getOffers();

        // Insertar cada oferta en la tabla offers
        foreach ($offers as $offer) {
            Offer::create($offer);
        }
    }
}