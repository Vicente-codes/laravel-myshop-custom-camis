<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * SEEDER: Usuarios
     * 
     * Este seeder crea usuarios de prueba para la funcionalidad del carrito.
     * No tenemos datos mock de usuarios (PUD2 no los necesitaba),
     * así que creamos algunos usuarios con la Factory de Laravel.
     * 
     * Factory: Es una clase que genera datos aleatorios siguiendo un patrón.
     * Laravel incluye por defecto UserFactory en database/factories/
     */
    
    public function run(): void
    {
        /**
         * CREAR UN USUARIO ESPECÍFICO
         * 
         * Usa la factory para crear un usuario con datos conocidos.
         * Estos datos los usaremos después para poblar el carrito.
         * 
         * Parámetros:
         * - name: Nombre del usuario
         * - email: Email único (el del carrito de ejemplo)
         * - password: Se cifra automáticamente (hasheada)
         * 
         * Resultado: Crea 1 usuario con email 'demo@example.com'
         */
        User::factory()->create([
            'name' => 'Usuario Demo',
            'email' => 'demo@example.com',
        ]);

        /**
         * CREAR USUARIOS ALEATORIOS
         * 
         * Usa la factory para crear 2 usuarios adicionales con datos aleatorios.
         * Faker es una librería que genera datos realistas.
         * 
         * Resultado: Crea 2 usuarios con emails aleatorios, nombres aleatorios, etc.
         */
        User::factory(2)->create();

        /**
         * RESULTADO FINAL
         * 
         * Se crean 3 usuarios en total:
         * 1. Usuario Demo (demo@example.com)
         * 2. Usuario Aleatorio 1 (email aleatorio)
         * 3. Usuario Aleatorio 2 (email aleatorio)
         */
    }
}
