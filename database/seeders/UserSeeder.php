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
        if (config('demo.allow_seed')) {
            $this->seedDemoUsers();

            return;
        }

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

    private function seedDemoUsers(): void
    {
        $admin = User::firstOrNew(['email' => config('demo.admin_email')]);
        $admin->name = 'Administrador Demo';
        $admin->password = config('demo.admin_password');
        $admin->email_verified_at = now();
        $admin->role = User::ROLE_ADMIN;
        $admin->save();

        $customer = User::firstOrNew(['email' => config('demo.customer_email')]);
        $customer->name = 'Cliente Demo';
        $customer->password = config('demo.customer_password');
        $customer->email_verified_at = now();
        $customer->role = User::ROLE_CUSTOMER;
        $customer->save();
    }
}
