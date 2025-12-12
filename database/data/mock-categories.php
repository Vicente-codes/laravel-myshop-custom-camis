<?php
/**
 * ARCHIVO: mock-categories.php
 * 
 * PROPÓSITO: Define todas las categorías de camisetas disponibles
 * 
 * ESTRUCTURA: Un array asociativo donde:
 *   - La clave es el ID de la categoría (1, 2, 3, etc.)
 *   - El valor es otro array con los detalles de la categoría
 * 
 * ATRIBUTOS DE CADA CATEGORÍA:
 *   - id: Identificador único
 *   - name: Nombre de la categoría
 *   - slug: Versión amigable para URLs (sin espacios, minúsculas, con guiones)
 *   - description: Descripción breve de qué tipo de camisetas incluye
 */

return [
    // Categoría 1: Camisetas Básicas
    1 => [
        'id' => 1,
        'name' => 'Camisetas Básicas',
        'slug' => 'camisetas-basicas',
        'description' => 'Camisetas lisas de alta calidad, perfectas para personalización con logos y diseños'
    ],
    
    // Categoría 2: Camisetas Premium
    2 => [
        'id' => 2,
        'name' => 'Camisetas Premium',
        'slug' => 'camisetas-premium',
        'description' => 'Camisetas de tejido premium con acabado superior, ideales para colecciones exclusivas'
    ],
    
    // Categoría 3: Camisetas Deportivas
    3 => [
        'id' => 3,
        'name' => 'Camisetas Deportivas',
        'slug' => 'camisetas-deportivas',
        'description' => 'Camisetas técnicas para equipos deportivos y eventos, con tecnología transpirable'
    ],
    
    // Categoría 4: Camisetas Corporativas
    4 => [
        'id' => 4,
        'name' => 'Camisetas Corporativas',
        'slug' => 'camisetas-corporativas',
        'description' => 'Camisetas personalizadas para uniformes corporativos y branding empresarial'
    ],
    
    // Categoría 5: Camisetas Especiales
    5 => [
        'id' => 5,
        'name' => 'Camisetas Especiales',
        'slug' => 'camisetas-especiales',
        'description' => 'Ediciones limitadas y diseños especiales para eventos y colaboraciones exclusivas'
    ]
];