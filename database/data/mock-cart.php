<?php
/**
 * ARCHIVO: mock-cart.php
 * 
 * PROPÓSITO: Simula el contenido del carrito de compras
 * 
 * ESTRUCTURA: Un array asociativo donde:
 *   - La clave es el ID del item en el carrito
 *   - El valor es un array con los detalles del item
 * 
 * ATRIBUTOS DE CADA ITEM DEL CARRITO:
 *   - id: Identificador único del item
 *   - product_id: ID del producto que está en el carrito
 *   - quantity: Número de unidades de ese producto
 *   - added_at: Fecha y hora en que se añadió al carrito
 */

return [
    // Item 1: 2 unidades del Producto 1
    1 => [
        'id' => 1,
        'product_id' => 1,
        'quantity' => 2,
        'added_at' => '2025-01-15 10:30:00'
    ],
    
    // Item 2: 1 unidad del Producto 3
    2 => [
        'id' => 2,
        'product_id' => 3,
        'quantity' => 1,
        'added_at' => '2025-01-15 11:15:00'
    ],
    
    // Item 3: 4 unidades del Producto 5
    3 => [
        'id' => 3,
        'product_id' => 5,
        'quantity' => 4,
        'added_at' => '2025-01-15 12:00:00'
    ]
];