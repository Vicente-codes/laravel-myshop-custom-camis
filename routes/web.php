<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CartController;

/**
 * ARCHIVO: routes/web.php
 * 
 * DESCRIPCIÓN:
 * Este archivo define TODAS las rutas públicas de la tienda online.
 * Cada ruta mapea una URL a un controlador y método específico.
 * 
 * ESTRUCTURA DE UNA RUTA:
 * Route::metodo('url', 'ControladorNombre@metodo')
 *   - método: GET, POST, PUT, DELETE, etc.
 *   - url: ruta accesible desde el navegador
 *   - Controlador@metodo: qué se ejecuta
 * 
 * MÉTODOS CONVENIENTES:
 * - Route::resource('name', 'Controller'): Crea 7 rutas CRUD de una vez
 * - Route::get(), Route::post(), etc.: Rutas individuales específicas
 */

// ============================================================================
// RUTA 1: PÁGINA DE INICIO
// ============================================================================
// URL: http://localhost/
// Método: GET (solo lectura)
// Controlador: WelcomeController
// Método: index()
// Descripción: Muestra la página de inicio con productos y categorías destacados
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// ============================================================================
// RUTAS 2-8: PRODUCTOS (RESOURCE CONTROLLER)
// ============================================================================
// El método resource() crea automáticamente estas 7 rutas:
// 1. GET /products => ProductController@index (lista)
// 2. GET /products/create => ProductController@create (formulario nuevo)
// 3. POST /products => ProductController@store (guardar nuevo)
// 4. GET /products/{id} => ProductController@show (detalle)
// 5. GET /products/{id}/edit => ProductController@edit (formulario editar)
// 6. PUT /products/{id} => ProductController@update (guardar cambios)
// 7. DELETE /products/{id} => ProductController@destroy (eliminar)

Route::resource('products', ProductController::class);

// Ruta adicional: Mostrar solo productos con oferta
// URL: http://localhost/products-on-sale
// Método: GET
// Controlador: ProductController
// Método: onSale()
// Descripción: Muestra solo productos que tienen una oferta activa
Route::get('/products-on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');

// ============================================================================
// RUTAS 9-10: CATEGORÍAS
// ============================================================================
// 1. GET /categories => CategoryController@index (lista de categorías)
// 2. GET /categories/{id} => CategoryController@show (productos de categoría)
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

// ============================================================================
// RUTAS 11-12: OFERTAS
// ============================================================================
// 1. GET /offers => OfferController@index (lista de ofertas)
// 2. GET /offers/{id} => OfferController@show (productos de oferta)
Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
Route::get('/offers/{id}', [OfferController::class, 'show'])->name('offers.show');

// ============================================================================
// RUTAS 13-15: CARRITO DE COMPRAS
// ============================================================================
// 1. GET /cart => CartController@index (ver carrito)
// 2. POST /cart => CartController@store (añadir producto)
// 3. PUT /cart/{id} => CartController@update (actualizar cantidad)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');

// ============================================================================
// RUTA 16: PÁGINA DE CONTACTO
// ============================================================================
// URL: http://localhost/contact
// Método: GET
// Descripción: Página de contacto (mostrará "En construcción" por ahora)
Route::view('contact', 'contact')->name('contact');