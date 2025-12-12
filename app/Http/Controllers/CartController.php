<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CONTROLADOR: CartController
 * 
 * RESPONSABILIDAD: Gestionar el carrito de compras
 * 
 * MÉTODOS:
 *   - index(): Mostrar el contenido del carrito
 *   - store(): Añadir un producto al carrito
 *   - update(): Actualizar la cantidad de un producto en el carrito
 */
class CartController extends Controller
{
    use LoadsMockData;

    /**
     * MÉTODO: index()
     * 
     * PROPÓSITO: Mostrar el estado actual del carrito de compras
     * 
     * RUTA: GET /cart
     * NOMBRE DE RUTA: cart.index
     * 
     * LÓGICA:
     *   1. Cargar el carrito (items simulados)
     *   2. Cargar todos los productos
     *   3. Para cada item del carrito, buscar su producto
     *   4. Combinar datos del item + datos del producto
     *   5. Enviar a la vista
     * 
     * RETORNA: Vista con contenido del carrito
     */
    public function index(): View
    {
        // Obtener el carrito (array de items)
        $cart = $this->getCart();
        
        // Obtener todos los productos (para buscar nombres y precios)
        $products = $this->getProducts();

        /**
         * Enriquecer items del carrito con información de productos
         * 
         * Convertimos esto:
         *   ['id' => 1, 'product_id' => 1, 'quantity' => 2, ...]
         * 
         * A esto:
         *   ['id' => 1, 'product_id' => 1, 'quantity' => 2, 
         *    'name' => 'Camiseta...', 'price' => 8.50, ...]
         */
        $cartWithProducts = [];
        
        foreach ($cart as $item) {
            // Buscamos el producto correspondiente a este item
            $product = $products[$item['product_id']] ?? null;
            
            /**
             * Combinamos el item del carrito con los datos del producto
             * 
             * array_merge() une dos arrays
             * Si hay claves duplicadas, el segundo array sobrescribe
             */
            $cartWithProducts[] = array_merge($item, [
                'name' => $product ? $product['name'] : 'Producto no encontrado',
                'price' => $product ? $product['price'] : 0
            ]);
        }

        /**
         * Enviar los items del carrito enriquecidos a la vista
         */
        return view('cart.index', [
            'cartItems' => $cartWithProducts
        ]);
    }

    /**
     * MÉTODO: store()
     * 
     * PROPÓSITO: Añadir un nuevo producto al carrito
     * 
     * RUTA: POST /cart
     * NOMBRE DE RUTA: cart.store
     * 
     * PARÁMETROS:
     *   @param Request $request Datos del formulario (product_id, quantity)
     * 
     * NOTA: En esta práctica es simulado, no guarda realmente
     * 
     * RETORNA: Redirección al carrito con mensaje de éxito
     */
    public function store(Request $request)
    {
        /**
         * En una aplicación real:
         *   1. Validaríamos que product_id y quantity sean válidos
         *   2. Buscaríamos el producto
         *   3. Lo guardaríamos en la sesión o base de datos
         *   4. Retornaríamos un mensaje de éxito
         */
        
        return redirect()->route('cart.index')
            ->with('success', 'Producto añadido al carrito exitosamente');
    }

    /**
     * MÉTODO: update()
     * 
     * PROPÓSITO: Actualizar la cantidad de un producto en el carrito
     * 
     * RUTA: PUT/PATCH /cart/{id}
     * NOMBRE DE RUTA: cart.update
     * 
     * PARÁMETROS:
     *   @param Request $request Datos nuevos (quantity)
     *   @param string $id El ID del item en el carrito
     * 
     * NOTA: En esta práctica es simulado
     * 
     * RETORNA: Redirección al carrito con mensaje de éxito
     */
    public function update(Request $request, string $id)
    {
        /**
         * En una aplicación real:
         *   1. Validaríamos que la cantidad sea válida (0-99)
         *   2. Si es 0, eliminaríamos el producto del carrito
         *   3. Si es > 0, actualizaríamos la cantidad
         *   4. Guardaríamos en sesión o base de datos
         *   5. Retornaríamos un mensaje de éxito
         */
        
        return redirect()->route('cart.index')
            ->with('success', 'Cantidad actualizada exitosamente');
    }
}