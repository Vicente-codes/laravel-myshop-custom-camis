<?php
/**
 * ARCHIVO: mock-offers.php
 * 
 * PROPÓSITO: Define todas las ofertas y descuentos disponibles en la tienda
 * 
 * ESTRUCTURA: Un array asociativo donde:
 *   - La clave es el ID de la oferta (1, 2, 3, etc.)
 *   - El valor es un array con los detalles de la oferta
 * 
 * ATRIBUTOS DE CADA OFERTA:
 *   - id: Identificador único de la oferta
 *   - name: Nombre descriptivo de la promoción
 *   - slug: Versión amigable para URLs
 *   - discount_percentage: Porcentaje de descuento (ej: 20 = 20% de descuento)
 *   - description: Explicación de la oferta y sus condiciones
 */

return [
    // Oferta 1: Descuento por Volumen
    1 => [
        'id' => 1,
        'name' => 'Descuento por Volumen',
        'slug' => 'descuento-volumen',
        'discount_percentage' => 15,
        'description' => 'Descuento del 15% para pedidos de 100+ camisetas'
    ],
    
    // Oferta 2: Descuento Corporativo
    2 => [
        'id' => 2,
        'name' => 'Descuento Corporativo',
        'slug' => 'descuento-corporativo',
        'discount_percentage' => 20,
        'description' => 'Descuento del 20% para uniformes corporativos (mínimo 50 prendas)'
    ],
    
    // Oferta 3: Promoción de Verano
    3 => [
        'id' => 3,
        'name' => 'Promoción de Verano',
        'slug' => 'promocion-verano',
        'discount_percentage' => 10,
        'description' => 'Descuento especial de verano del 10% en camisetas deportivas'
    ],
    
    // Oferta 4: Nuevos Clientes
    4 => [
        'id' => 4,
        'name' => 'Bienvenida Nuevos Clientes',
        'slug' => 'bienvenida-nuevos',
        'discount_percentage' => 12,
        'description' => 'Descuento de bienvenida del 12% para tu primer pedido'
    ],
    
    // Oferta 5: Productos en Liquidación
    5 => [
        'id' => 5,
        'name' => 'Liquidación de Stock',
        'slug' => 'liquidacion-stock',
        'discount_percentage' => 25,
        'description' => 'Descuento del 25% en colecciones anteriores disponibles en stock'
    ]
];