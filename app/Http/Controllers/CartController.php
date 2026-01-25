<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class CartController extends Controller
{
    /**
     * Muestra la vista del carrito de compras con los datos de la sesión.
     */
    public function index(): View
    {
        $cart = session()->get('cart', []);

        // Obtenemos los IDs únicos de los productos del carrito
        // Estructura cart: 'ID_SIZE' => ['product_id' => 1, 'quantity' => 1, 'size' => 'M']
        $productIds = collect($cart)->pluck('product_id')->unique()->toArray();

        // Cargamos los modelos de producto
        $products = Product::with(['category', 'offer'])->find($productIds)->keyBy('id');

        // Transformamos el carrito en una colección de productos con datos extra
        $cartProducts = collect($cart)->map(function ($item, $key) use ($products) {
            $product = $products->get($item['product_id']);

            // Si el producto fue borrado de la DB pero sigue en sesión, lo omitimos
            if (!$product) return null;

            // Clonamos para no afectar a otras instancias del mismo producto (otra talla)
            $itemProduct = clone $product;
            $itemProduct->quantity = $item['quantity']; // Sobrescribimos la quantity del modelo con la del carrito
            $itemProduct->size = $item['size'];
            $itemProduct->cart_id = $key; // Guardamos la clave compuesta para acciones (update/delete)

            return $itemProduct;
        })->filter(); // Eliminamos nulos

        return view('cart.index', [
            'cartProducts' => $cartProducts
        ]);
    }

    /**
     * Añade un producto al carrito de compras en la sesión.
     * Este método se ejecuta cuando el usuario hace clic en "Añadir al carrito".
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validación de la petición: 
        // - 'product_id' es obligatorio y debe existir en la tabla products, columna id. 
        // - 'size' es obligatorio y debe ser una cadena (la talla seleccionada). 
        // Si la validación falla, Laravel redirige automáticamente atrás con errores.
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
        ]);

        // 2. Obtener los datos enviados desde el formulario: 
        // - ID del producto. 
        // - Talla seleccionada.
        $productId = $request->input('product_id');
        $size = $request->input('size');

        // 3. Crear una clave compuesta para el carrito: 
        // Se combina el ID del producto con la talla. 
        // Ejemplo: producto 5, talla "M" → "5_M". 
        // Esto permite diferenciar el mismo producto con tallas distintas dentro del carrito.
        $cartId = $productId . '_' . $size;

        // 4. Obtener el carrito actual desde la sesión. 
        // Si no existe todavía, se devuelve un array vacío por defecto.
        $cart = session()->get('cart', []);

        // 5. Comprobar si ese producto con esa talla ya está en el carrito.
        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity']++;
        } else {
            $cart[$cartId] = [
                "product_id" => $productId,
                "quantity" => 1,
                "size" => $size
            ];
        }

        // 6. Guardar el carrito actualizado de nuevo en la sesión.
        session()->put('cart', $cart);

        // 8. Redirigir de vuelta a la página anterior con un mensaje de éxito en la sesión.
        return redirect()->back()->with('success', '¡Producto añadido al carrito!');
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     * @param string $id Es el $cartId (ej: 12_XL)
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->input('quantity');
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Cantidad actualizada correctamente.');
        }

        return redirect()->route('cart.index')->with('error', 'El producto no se encontró en el carrito.');
    }

    /**
     * Elimina un producto del carrito de compras.
     * @param string $id Es el $cartId (ej: 12_XL)
     */
    public function destroy(string $id): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
        }

        return redirect()->route('cart.index')->with('error', 'El producto no se encontró en el carrito.');
    }

    /**
     * Simula la finalización de la compra, vaciando el carrito.
     */
    public function checkout(): RedirectResponse
    {
        session()->forget('cart'); // Vacía el carrito de la sesión
        return redirect()->route('welcome')->with('success', '¡Pedido realizado con éxito! Gracias por tu compra.');
    }
}
