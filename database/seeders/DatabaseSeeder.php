<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    /**
     * SEEDER PRINCIPAL: DatabaseSeeder
     * 
     * Este es el seeder maestro que ejecuta todos los demás seeders.
     * Es IMPORTANTE ejecutarlos en el orden correcto para respetar las claves foráneas.
     * 
     * Orden de ejecución:
     * 1. UserSeeder - Crea usuarios (tabla independiente)
     * 2. CategorySeeder - Crea categorías (tabla independiente)
     * 3. OfferSeeder - Crea ofertas (tabla independiente)
     * 4. ProductSeeder - Crea productos (depende de categories y offers)
     * 5. ProductUserSeeder - Puebla carrito (depende de users y products)
     * 
     * ¿Por qué es importante el orden?
     * 
     * Imagina que ejecutas ProductSeeder ANTES que CategorySeeder.
     * ProductSeeder intenta insertar un producto con category_id = 1.
     * Pero la categoría con id = 1 NO existe aún.
     * ¡ERROR DE CLAVE FORÁNEA!
     * 
     * Por eso el orden es crítico:
     * - Las tablas sin dependencias (Users, Categories, Offers) primero
     * - Las tablas con dependencias (Products) después
     * - Las tablas pivot (ProductUser) al final
     */
    public function run(): void
    {
        $demoMode = (bool) config('demo.allow_seed');

        if (app()->isProduction() && ! $demoMode) {
            $this->command?->warn('Seeding demo omitido: ALLOW_DEMO_SEED no está activado.');

            return;
        }

        if ($demoMode) {
            $this->validateDemoPasswords();
            $this->command?->info('Seeding demo activado: ALLOW_DEMO_SEED=true.');
        }

        /**
         * EJECUTAR SEEDERS EN ORDEN CORRECTO
         * 
         * $this->call() ejecuta cada seeder en el orden especificado.
         * 
         * El método call() permite:
         * - Ejecutar cada seeder de forma independiente
         * - Mantener el orden de ejecución
         * - Asegurar que las dependencias de claves foráneas se respeten
         */
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            OfferSeeder::class,
            ProductSeeder::class,
            ProductUserSeeder::class,
        ]);
    }

    private function validateDemoPasswords(): void
    {
        $invalid = [];

        foreach ([
            'DEMO_ADMIN_PASSWORD' => config('demo.admin_password'),
            'DEMO_CUSTOMER_PASSWORD' => config('demo.customer_password'),
        ] as $name => $password) {
            if (! is_string($password) || strlen($password) < 12) {
                $invalid[] = $name;
            }
        }

        if ($invalid === []) {
            return;
        }

        $message = count($invalid) === 1
            ? "Seeding demo abortado: {$invalid[0]} debe estar definida y tener al menos 12 caracteres."
            : 'Seeding demo abortado: '.implode(' y ', $invalid).' deben estar definidas y tener al menos 12 caracteres.';

        throw new RuntimeException($message);
    }
}

