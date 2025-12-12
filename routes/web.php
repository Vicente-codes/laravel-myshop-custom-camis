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
 * PROPÓSITO: Define todas las rutas públicas de la tienda online
 * 
 * ESTRUCTURA:
 * Route::{metodo_http}(ruta, controlador@metodo)
 *   - Método HTTP: get, post, put, delete, etc.
 *   - Ruta: La URL que escucha
 *   - Controlador: Qué código ejecutar
 * 
 * CONVENCIÓN DE NOMBRES:
 *   - index: Listar todos
 *   - create: Mostrar formulario de creación
 *   - store: Guardar nuevo (POST)
 *   - show: Ver detalle
 *   - edit: Mostrar formulario de edición
 *   - update: Actualizar (PUT/PATCH)
 *   - destroy: Eliminar (DELETE)
 */

/**
 * RUTA: GET /
 * NOMBRE: welcome
 * CONTROLADOR: WelcomeController@index
 * 
 * PROPÓSITO: Página de inicio con productos y categorías destacados
 */
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

/**
 * RUTAS DE PRODUCTOS
 * Route::resource() automáticamente crea 7 rutas CRUD estándar
 */
Route::resource('products', ProductController::class);

/**
 * RUTA ESPECIAL: GET /products-on-sale
 * NOMBRE: products.on-sale
 * CONTROLADOR: ProductController@onSale
 * 
 * PROPÓSITO: Mostrar solo productos con ofertas activas
 * 
 * NOTA: Esta ruta DEBE ir ANTES de Route::resource('products',...)
 * porque si no, Laravel la interpretaría como 'products/{id}' con id='on-sale'
 */
Route::get('/products-on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');

/**
 * RUTAS DE CATEGORÍAS
 * Similar a products, pero sin crear formularios
 * Solo index (listar todas) y show (ver productos de una)
 */
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

/**
 * RUTAS DE OFERTAS
 * Similar a categorías
 */
Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
Route::get('/offers/{id}', [OfferController::class, 'show'])->name('offers.show');

/**
 * RUTAS DE CARRITO
 * index: ver contenido del carrito
 * store: añadir producto
 * update: cambiar cantidad
 */
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');

/**
 * RUTA DE CONTACTO (simple)
 * En las próximas prácticas la expandiremos
 */
Route::get('/contact', function () {
    return view('contact');
})->name('contact');