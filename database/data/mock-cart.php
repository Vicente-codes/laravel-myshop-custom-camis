<?php
/**
 * ARCHIVO: mock-cart.php
 * 
 * DESCRIPCIÓN:
 * Este archivo simula un carrito de compras. Contiene items que un usuario
 * ha añadido a su carrito. Es una simulación global - todos comparten carrito.
 * En una aplicación real, cada usuario tendría su propio carrito en la sesión.
 * 
 * ESTRUCTURA DE UN ITEM EN CARRITO:
 * - id: Identificador único del item en el carrito (número)
 * - product_id: ID del producto añadido al carrito (número)
 * - quantity: Cantidad de unidades del producto (número)
 * - added_at: Fecha y hora en que se añadió (string, formato: YYYY-MM-DD HH:MM:SS)
 */

return [
    // ITEM 1: 2 unidades de camisetas básicas blancas
    // El usuario quiere 2 Camisetas Blancas (producto 1)
    1 => [
        'id' => 1,
        'product_id' => 1,
        'quantity' => 2,
        'added_at' => '2025-01-15 10:30:00'
    ],

    // ITEM 2: 1 uniforme deportivo completo
    // El usuario añadió 1 Conjunto de Uniforme Deportivo (producto 10)
    2 => [
        'id' => 2,
        'product_id' => 10,
        'quantity' => 1,
        'added_at' => '2025-01-15 11:15:00'
    ],

    // ITEM 3: 4 camisetas personalizadas DTG
    // El usuario quiere 4 Camisetas DTG (producto 5)
    3 => [
        'id' => 3,
        'product_id' => 5,
        'quantity' => 4,
        'added_at' => '2025-01-15 12:00:00'
    ],
];