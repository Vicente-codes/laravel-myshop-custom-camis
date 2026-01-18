<?php
/**
 * ARCHIVO: mock-categories.php
 * 
 * DESCRIPCIÓN:
 * Este archivo contiene las categorías de productos de la tienda.
 * Cada categoría es un array asociativo con id, name, slug y description.
 * Las categorías se usan para organizar los productos en la tienda.
 * 
 * ESTRUCTURA DE UNA CATEGORÍA:
 * - id: Identificador único de la categoría (número)
 * - name: Nombre de la categoría (string)
 * - slug: Versión URL-friendly del nombre (string)
 * - description: Descripción breve de la categoría (string)
 */

return [
    // CATEGORÍA 1: Camisetas Básicas
    // Son camisetas con colores sólidos, sin diseño personalizado
    1 => [
        'id' => 1,
        'name' => 'Camisetas Básicas',
        'slug' => 'camisetas-basicas',
        'description' => 'Camisetas de alta calidad en colores sólidos, ideales para eventos corporativos y uniforme básico',
        'image' => 'camisetas-basicas.jpg'
    ],

    // CATEGORÍA 2: Camisetas Personalizadas
    // Camisetas con diseños, logos o texto personalizado
    2 => [
        'id' => 2,
        'name' => 'Camisetas Personalizadas',
        'slug' => 'camisetas-personalizadas',
        'description' => 'Camisetas con diseños, logos y textos personalizados. Disponibles en serigrafía, DTG y vinilo',
        'image' => 'camisetas-personalizadas.jpg'
    ],

    // CATEGORÍA 3: Uniformes Corporativos
    // Uniformes completos para empresas
    3 => [
        'id' => 3,
        'name' => 'Uniformes Corporativos',
        'slug' => 'uniformes-corporativos',
        'description' => 'Uniformes completos para empresas, con logo bordado o impreso',
        'image' => 'uniformes-corporativos.jpg'
    ],

    // CATEGORÍA 4: Prendas Deportivas
    // Equipos deportivos y prendas técnicas
    4 => [
        'id' => 4,
        'name' => 'Prendas Deportivas',
        'slug' => 'prendas-deportivas',
        'description' => 'Equipos deportivos y prendas técnicas para equipos y eventos',
        'image' => 'prendas-deportivas.jpg'
    ],

    // CATEGORÍA 5: Prendas de Temporada
    // Colecciones por temporada o eventos especiales
    5 => [
        'id' => 5,
        'name' => 'Prendas de Temporada',
        'slug' => 'prendas-temporada',
        'description' => 'Colecciones especiales por temporada, eventos y campañas promocionales',
        'image' => 'prendas-temporada.jpg'
    ],
];