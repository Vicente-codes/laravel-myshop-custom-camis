<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CONTROLADOR: CartController
 * 
 * RESPONSABILIDAD:
 * Gestiona operaciones relacionadas con el carrito de compras.
 * 
 * MÉTODOS:
 * - index: Mostrar el contenido actual del carrito
 * - store: Añadir un producto al carrito (simulado)
 * - update: Actualizar cantidad de producto en carrito (simulado)
 * 
 * RUTAS:
 * - GET /cart => CartController@index (ver carrito)
 * - POST /cart => CartController@store (añadir producto)
 * - PUT /cart/{id} => CartController@update (actualizar cantidad)
 */

class CartController extends Controller
{
    // Importamos el trait para acceso a métodos de datos mock
    use LoadsMockData;

    /**
     * MÉTODO: index()
     * 
     * DESCRIPCIÓN:
     * Muestra el contenido actual del carrito de compras del usuario.
     * Muestra cada producto con su nombre, precio y cantidad.
     * 
     * PASOS:
     * 1. Carga el carrito actual (items del carrito)
     * 2. Carga todos los productos para obtener sus nombres y precios
     * 3. Enriquece cada item del carrito con:
     *    - Nombre del producto
     *    - Precio del producto
     * 4. Retorna la vista cart.index con los items del carrito
     * 
     * RETORNA: Vista cart/index.blade.php con:
     * - $cartItems: array con items del carrito (enriquecidos con nombre y precio)
     */
    public function index(): View
    {
        // PASO 1: Cargar el carrito actual
        $cart = $this->getCart();

        // PASO 2: Cargar todos los productos
        $products = $this->getProducts();

        // PASO 3: Enriquecer cada item del carrito
        // Añadimos nombre y precio del producto a cada item
        $cartWithProducts = [];
        foreach ($cart as $item) {
            // Obtener el producto para este item
            $product = $products[$item['product_id']] ?? null;

            // Crear item enriquecido con datos del producto
            $cartWithProducts[] = array_merge(
                $item,
                [
                    'name' => $product ? $product['name'] : 'Producto no encontrado',
                    'price' => $product ? $product['price'] : 0,
                ]
            );
        }

        // PASO 4: Retornar la vista con items del carrito
        return view('cart.index', ['cartItems' => $cartWithProducts]);
    }

    /**
     * MÉTODO: store()
     * 
     * DESCRIPCIÓN:
     * Añade un nuevo producto al carrito.
     * 
     * POR AHORA: Solo simulamos que se añadió el producto.
     * Más tarde se implementará la lógica real con sesiones.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()
            ->route('cart.index')
            ->with('success', 'Producto añadido al carrito exitosamente');
    }

    /**
     * MÉTODO: update()
     * 
     * DESCRIPCIÓN:
     * Actualiza la cantidad de un producto en el carrito.
     * 
     * POR AHORA: Solo simulamos que se actualizó la cantidad.
     * Más tarde se implementará la lógica real con sesiones.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        return redirect()
            ->route('cart.index')
            ->with('success', 'Cantidad actualizada exitosamente');
    }
}