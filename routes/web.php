<?php

use Illuminate\Support\Facades\Route;

// Importamos los controladores que manejarán las rutas. 
// Cada ruta apunta a un método dentro de uno de estos controladores.
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Este archivo define todas las rutas accesibles desde el navegador.
| Cada ruta responde a una URL y ejecuta un método de un controlador.
| Aquí se organizan rutas públicas, rutas protegidas y rutas de administración.
*/

// ===========================================
// RUTAS PÚBLICAS (Sin autenticación requerida)
// ===========================================

// Página principal del sitio (home). Muestra contenido destacado. 
// GET / → WelcomeController@index
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Página de contacto (formulario de contacto). 
Route::get('/contact', [ContactController::class, 'index'])->name('contact'); // GET /contact → muestra el formulario
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store'); // POST /contact → procesa el formulario y envía el mensaje

// Rutas de categorías en modo solo lectura. 
// resource() genera varias rutas REST automáticamente, pero aquí limitamos a index y show.
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

// Rutas de productos (solo lectura)
Route::get('/products-on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');// Ruta personalizada para productos en oferta.
Route::resource('products', ProductController::class)->only(['index', 'show']);// Rutas REST de productos, solo index y show (listar y ver un producto).

// Rutas de ofertas (solo lectura)
Route::resource('offers', OfferController::class)->only(['index', 'show']);

// =========================================== 
// RUTAS DEL CARRITO DE COMPRAS 
// =========================================== 
// Estas rutas permiten ver, añadir, actualizar y eliminar productos del carrito
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');// Mostrar el carrito
Route::post('/cart', [CartController::class, 'store'])->name('cart.store'); // Añadir un producto al carrito
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update'); // Actualizar la cantidad de un producto en el carrito
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy'); // Eliminar un producto del carrito
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); // Procesar el checkout

// ===========================================
// RUTAS DE USUARIO AUTENTICADO (Breeze)
// ===========================================
// Este grupo solo es accesible si el usuario ha iniciado sesión. 
// El middleware 'auth' protege todas las rutas dentro del grupo.

Route::middleware('auth')->group(function () {

    // Dashboard del usuario (vista general tras iniciar sesión)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas del perfil del usuario (editar, actualizar, eliminar cuenta)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ===========================================
// RUTAS DE ADMINISTRACIÓN (Protegidas + Logging)
// ===========================================
// Este grupo requiere: 
// - Estar autenticado ('auth') 
// - Pasar por un middleware personalizado 'log.activity' que registra actividad 
// Además, todas las rutas tendrán el prefijo /admin y el nombre admin.*

Route::middleware(['auth', 'log.activity'])->prefix('admin')->name('admin.')->group(function () {
    // Página principal de gestión de productos en el panel admin
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');

    // Rutas REST completas para productos, excepto index y show (ya existen en público)
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    
    // Rutas para la lista de deseos (Wishlist)
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{id}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

// =========================================== 
// RUTAS DE AUTENTICACIÓN (login, register, logout, etc.) 
// ===========================================
// Las rutas de autenticación (login, register, etc.) se incluyen desde aquí
require __DIR__.'/auth.php';
