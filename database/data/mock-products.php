<?php
/**
 * ARCHIVO: mock-products.php
 * 
 * PROPÓSITO: Define todos los productos (camisetas) disponibles en la tienda
 * 
 * ESTRUCTURA: Un array asociativo donde:
 *   - La clave es el ID del producto
 *   - El valor es un array con los detalles del producto
 * 
 * ATRIBUTOS DE CADA PRODUCTO:
 *   - id: Identificador único del producto
 *   - name: Nombre del producto
 *   - description: Descripción detallada de la camiseta
 *   - price: Precio en euros (ej: 15.99)
 *   - category_id: ID de la categoría a la que pertenece
 *   - offer_id: ID de la oferta (null si no tiene oferta)
 *   - stock: Cantidad disponible en almacén
 *   - material: Tipo de tela (ej: "Algodón 100%")
 *   - sizes_available: Tallas disponibles
 * 
 * REGLAS DE NEGOCIO:
 *   - Un producto puede tener UNA oferta activa O ninguna
 *   - Una oferta puede aplicarse a VARIOS productos
 *   - El stock debe ser realista (0-500 unidades típicamente)
 */

return [
    // Producto 1: Camiseta Básica Blanca
    1 => [
        'id' => 1,
        'name' => 'Camiseta Básica Blanca - 100% Algodón',
        'description' => 'Camiseta lisa de algodón puro, perfecta para serigrafía y estampación. Ajuste clásico y cómodo. Ideal para personalizaciones corporativas.',
        'price' => 8.50,
        'category_id' => 1,
        'offer_id' => 1,  // Tiene la oferta de Descuento por Volumen
        'stock' => 350,
        'material' => 'Algodón 100% (180 g/m²)',
        'sizes_available' => ['XS', 'S', 'M', 'L', 'XL', 'XXL']
    ],

    // Producto 2: Camiseta Premium Azul
    2 => [
        'id' => 2,
        'name' => 'Camiseta Premium Azul Marino - Tejido Superior',
        'description' => 'Camiseta premium con acabado de lujo. Tejido de alta densidad que proporciona durabilidad y comodidad superior. Perfecta para marcas exclusivas.',
        'price' => 14.99,
        'category_id' => 2,
        'offer_id' => null,  // Sin oferta actualmente
        'stock' => 120,
        'material' => 'Algodón/Poliéster (200 g/m²)',
        'sizes_available' => ['S', 'M', 'L', 'XL', 'XXL']
    ],

    // Producto 3: Camiseta Deportiva Roja
    3 => [
        'id' => 3,
        'name' => 'Camiseta Deportiva Roja - Tecnología Transpirable',
        'description' => 'Camiseta técnica especialmente diseñada para actividades deportivas. Tela con tecnología de transpiración rápida y absorción de humedad. Ideal para equipos deportivos.',
        'price' => 12.50,
        'category_id' => 3,
        'offer_id' => 3,  // Tiene la oferta de Promoción de Verano
        'stock' => 280,
        'material' => 'Poliéster reciclado 100% (150 g/m²)',
        'sizes_available' => ['XS', 'S', 'M', 'L', 'XL', 'XXL']
    ],

    // Producto 4: Camiseta Corporativa Negra
    4 => [
        'id' => 4,
        'name' => 'Camiseta Corporativa Negra - Uniformes Empresariales',
        'description' => 'Camiseta perfecta para uniformes y branding corporativo. Ofrece una imagen profesional y está disponible en grandes volúmenes. Compatibilidad total con bordado y estampación.',
        'price' => 9.99,
        'category_id' => 4,
        'offer_id' => 2,  // Tiene la oferta Corporativa
        'stock' => 500,
        'material' => 'Algodón/Poliéster (190 g/m²)',
        'sizes_available' => ['S', 'M', 'L', 'XL', 'XXL']
    ],

    // Producto 5: Camiseta Especial Gris Melange
    5 => [
        'id' => 5,
        'name' => 'Camiseta Especial Gris Melange - Edición Limitada',
        'description' => 'Camiseta de edición limitada con tonalidad gris melange única. Perfecta para colecciones exclusivas y colaboraciones especiales. Stock limitado.',
        'price' => 11.75,
        'category_id' => 5,
        'offer_id' => 5,  // Tiene la oferta de Liquidación
        'stock' => 45,
        'material' => 'Algodón melange (185 g/m²)',
        'sizes_available' => ['M', 'L', 'XL']
    ],

    // Producto 6: Camiseta Básica Gris
    6 => [
        'id' => 6,
        'name' => 'Camiseta Básica Gris - 100% Algodón',
        'description' => 'Camiseta lisa en gris, hermana de la blanca. Versátil y cómoda, ideal para cualquier tipo de personalización. Calidad estándar pero confiable.',
        'price' => 8.50,
        'category_id' => 1,
        'offer_id' => 1,  // Tiene la oferta de Descuento por Volumen
        'stock' => 320,
        'material' => 'Algodón 100% (180 g/m²)',
        'sizes_available' => ['XS', 'S', 'M', 'L', 'XL', 'XXL']
    ],

    // Producto 7: Camiseta Premium Verde Oliva
    7 => [
        'id' => 7,
        'name' => 'Camiseta Premium Verde Oliva - Tejido Superior',
        'description' => 'Camiseta premium en color verde oliva exclusivo. Tejido de primera calidad con toque suave al tacto. Ideal para colaboraciones con marcas de lujo.',
        'price' => 14.99,
        'category_id' => 2,
        'offer_id' => 4,  // Tiene la oferta de Bienvenida
        'stock' => 95,
        'material' => 'Algodón/Poliéster (200 g/m²)',
        'sizes_available' => ['S', 'M', 'L', 'XL', 'XXL']
    ],

    // Producto 8: Camiseta Deportiva Blanca
    8 => [
        'id' => 8,
        'name' => 'Camiseta Deportiva Blanca - Tecnología Transpirable',
        'description' => 'Camiseta técnica en blanco para máxima versatilidad. Tela de alto rendimiento perfecta para equipos deportivos, entrenamiento y eventos.',
        'price' => 12.50,
        'category_id' => 3,
        'offer_id' => null,  // Sin oferta
        'stock' => 245,
        'material' => 'Poliéster reciclado 100% (150 g/m²)',
        'sizes_available' => ['XS', 'S', 'M', 'L', 'XL', 'XXL']
    ],

    // Producto 9: Camiseta Corporativa Azul
    9 => [
        'id' => 9,
        'name' => 'Camiseta Corporativa Azul - Uniformes Empresariales',
        'description' => 'Camiseta corporativa en azul profesional. Mantiene la calidad y versatilidad de nuestra línea corporativa. Disponible para grandes volúmenes.',
        'price' => 9.99,
        'category_id' => 4,
        'offer_id' => 2,  // Tiene la oferta Corporativa
        'stock' => 480,
        'material' => 'Algodón/Poliéster (190 g/m²)',
        'sizes_available' => ['S', 'M', 'L', 'XL', 'XXL']
    ],

    // Producto 10: Camiseta Especial Borgoña
    10 => [
        'id' => 10,
        'name' => 'Camiseta Especial Borgoña - Edición Limitada',
        'description' => 'Camiseta de edición especial en elegante color borgoña. Acabado premium con cantidad limitada. Perfecta para eventos y ediciones coleccionables.',
        'price' => 11.75,
        'category_id' => 5,
        'offer_id' => null,  // Sin oferta
        'stock' => 60,
        'material' => 'Algodón 100% (185 g/m²)',
        'sizes_available' => ['M', 'L', 'XL']
    ]
];