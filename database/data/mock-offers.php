<?php
/**
 * ARCHIVO: mock-offers.php
 * 
 * DESCRIPCIÓN:
 * Este archivo contiene las ofertas especiales disponibles en la tienda.
 * Las ofertas aplican descuentos a productos específicos.
 * 
 * ESTRUCTURA DE UNA OFERTA:
 * - id: Identificador único de la oferta (número)
 * - name: Nombre de la oferta (string)
 * - slug: Versión URL-friendly del nombre (string)
 * - discount_percentage: Porcentaje de descuento (número, ej: 20 para 20%)
 * - description: Descripción de la oferta y sus condiciones (string)
 */

return [
    // OFERTA 1: Descuento por Volumen
    // Aplica cuando se piden muchas unidades (100+)
    1 => [
        'id' => 1,
        'name' => 'Descuento por Volumen',
        'slug' => 'descuento-volumen',
        'discount_percentage' => 20,
        'description' => 'Descuento del 20% en pedidos mayores a 100 unidades'
    ],

    // OFERTA 2: Promoción de Inicio de Año
    // Válida durante enero y febrero
    2 => [
        'id' => 2,
        'name' => 'Promoción Inicio de Año',
        'slug' => 'promo-inicio-ano',
        'discount_percentage' => 15,
        'description' => 'Descuento del 15% en todas las camisetas básicas durante enero y febrero'
    ],

    // OFERTA 3: Pack de Eventos
    // Para compras de uniformes para eventos
    3 => [
        'id' => 3,
        'name' => 'Pack de Eventos',
        'slug' => 'pack-eventos',
        'discount_percentage' => 25,
        'description' => 'Descuento del 25% en uniformes corporativos para eventos'
    ],

    // OFERTA 4: Ofertas Estacionales
    // Cambio de temporada (primavera, verano, etc)
    4 => [
        'id' => 4,
        'name' => 'Ofertas Estacionales',
        'slug' => 'ofertas-estacionales',
        'discount_percentage' => 10,
        'description' => 'Descuento del 10% en prendas de temporada al cambio de estación'
    ],

    // OFERTA 5: Descuento Cliente Recurrente
    // Para clientes que compran regularmente
    5 => [
        'id' => 5,
        'name' => 'Descuento Cliente Recurrente',
        'slug' => 'descuento-cliente-recurrente',
        'discount_percentage' => 12,
        'description' => 'Descuento del 12% para clientes con compras previas'
    ],
];