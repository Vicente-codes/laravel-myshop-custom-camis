<?php
/**
 * ARCHIVO: mock-products.php
 * 
 * DESCRIPCIÓN:
 * Este archivo contiene los productos disponibles en la tienda Custom Camis.
 * Cada producto es una camiseta, uniforme o prenda deportiva que podemos vender.
 * 
 * ESTRUCTURA DE UN PRODUCTO:
 * - id: Identificador único del producto (número)
 * - name: Nombre del producto (string)
 * - description: Descripción detallada del producto (string)
 * - price: Precio en euros (número decimal, ej: 9.99)
 * - category_id: ID de la categoría a la que pertenece (número)
 * - offer_id: ID de la oferta aplicada, o null si no tiene (número o null)
 */

return [
    // PRODUCTOS CATEGORÍA 1: Camisetas Básicas
    
    1 => [
        'id' => 1,
        'name' => 'Camiseta Básica Blanca',
        'description' => 'Camiseta 100% algodón, corte clásico. Ideal para uniforme corporativo básico. Colores: Blanco',
        'price' => 8.50,
        'category_id' => 1,
        'offer_id' => 1,
        'image' => 'camisetas-basicas.jpg'
    ],

    2 => [
        'id' => 2,
        'name' => 'Camiseta Básica Negra',
        'description' => 'Camiseta 100% algodón, corte clásico. Ideal para uniforme corporativo básico. Colores: Negro',
        'price' => 8.50,
        'category_id' => 1,
        'offer_id' => 2,
        'image' => 'camisetas-basicas.jpg'
    ],

    3 => [
        'id' => 3,
        'name' => 'Camiseta Básica Azul',
        'description' => 'Camiseta 100% algodón, corte clásico. Ideal para uniforme corporativo básico. Colores: Azul',
        'price' => 8.50,
        'category_id' => 1,
        'offer_id' => null,
        'image' => 'camisetas-basicas.jpg'
    ],

    // PRODUCTOS CATEGORÍA 2: Camisetas Personalizadas
    
    4 => [
        'id' => 4,
        'name' => 'Camiseta Serigrafía Logo Empresa',
        'description' => 'Camiseta personalizada con técnica de serigrafía. Incluye diseño de logo de empresa. Colores variados',
        'price' => 15.99,
        'category_id' => 2,
        'offer_id' => 3,
        'image' => 'camisetas-personalizadas.jpg'
    ],

    5 => [
        'id' => 5,
        'name' => 'Camiseta DTG Diseño Completo',
        'description' => 'Camiseta personalizada con técnica DTG (Direct-to-Garment). Permite diseños complejos y a todo color',
        'price' => 18.50,
        'category_id' => 2,
        'offer_id' => null,
        'image' => 'camisetas-personalizadas.jpg'
    ],

    6 => [
        'id' => 6,
        'name' => 'Camiseta Vinilo Número o Nombre',
        'description' => 'Camiseta con números o nombres en vinilo. Perfecta para equipos deportivos. Colores personalizables',
        'price' => 12.75,
        'category_id' => 2,
        'offer_id' => 5,
        'image' => 'camisetas-personalizadas.jpg'
    ],

    // PRODUCTOS CATEGORÍA 3: Uniformes Corporativos
    
    7 => [
        'id' => 7,
        'name' => 'Uniforme Corporativo Completo',
        'description' => 'Uniforme corporativo completo (camiseta + pantalón) con logo bordado. Colores corporativos',
        'price' => 45.00,
        'category_id' => 3,
        'offer_id' => 3,
        'image' => 'uniformes-corporativos.jpg'
    ],

    8 => [
        'id' => 8,
        'name' => 'Chaleco Corporativo con Logo',
        'description' => 'Chaleco corporativo con logo bordado. Disponible en varios colores. Tallas: XS a XXL',
        'price' => 28.50,
        'category_id' => 3,
        'offer_id' => null,
        'image' => 'uniformes-corporativos.jpg'
    ],

    // PRODUCTOS CATEGORÍA 4: Prendas Deportivas
    
    9 => [
        'id' => 9,
        'name' => 'Camiseta Deportiva Técnica',
        'description' => 'Camiseta deportiva con tejido técnico anti-sudoración. Disponible con números y nombres en vinilo',
        'price' => 16.99,
        'category_id' => 4,
        'offer_id' => 4,
        'image' => 'prendas-deportivas.jpg'
    ],

    10 => [
        'id' => 10,
        'name' => 'Conjunto de Uniforme Deportivo',
        'description' => 'Conjunto completo de uniforme deportivo (camiseta + pantalón corto) con números personalizados',
        'price' => 35.50,
        'category_id' => 4,
        'offer_id' => 1,
        'image' => 'prendas-deportivas.jpg'
    ],

    // PRODUCTOS CATEGORÍA 5: Prendas de Temporada
    
    11 => [
        'id' => 11,
        'name' => 'Camiseta Verano Colores Vibrantes',
        'description' => 'Camiseta especial verano con colores vibrantes y diseños frescos. 100% algodón',
        'price' => 11.99,
        'category_id' => 5,
        'offer_id' => 4,
        'image' => 'prendas-temporada.jpg'
    ],

    12 => [
        'id' => 12,
        'name' => 'Camiseta Invierno Térmico',
        'description' => 'Camiseta térmica para invierno con aislamiento de calor. Disponible en colores oscuros',
        'price' => 19.99,
        'category_id' => 5,
        'offer_id' => 2,
        'image' => 'prendas-temporada.jpg'
    ],
];