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
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
        ]);
        
        $productId = $request->input('product_id');
        $size = $request->input('size');
        
        // Clave compuesta: ID_TALLA
        $cartId = $productId . '_' . $size;
        
        $cart = session()->get('cart', []);

        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity']++;
        } else {
            $cart[$cartId] = [
                "product_id" => $productId,
                "quantity" => 1,
                "size" => $size
            ];
        }

        session()->put('cart', $cart);
        
        // OPCIONAL: Si el usuario está logueado, sincronizar con DB (lo omitimos por ahora por simplicidad MVP)
        
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