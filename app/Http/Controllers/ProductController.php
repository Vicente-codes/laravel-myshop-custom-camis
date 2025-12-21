<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Obtener todos los productos con categoría y oferta
        $products = Product::with(['category', 'offer'])->get();

        return view('products.index', compact('products'));
    }

    /**
     * Display only products that have an active offer
     */
    public function onSale(): View
    {
        // Solo productos con offer_id no nulo
        $products = Product::with(['category', 'offer'])
                           ->whereNotNull('offer_id')
                           ->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // En una app real: devolver formulario con categorías y ofertas
        // Aquí solo redirigimos como indica la práctica
        return redirect()->route('products.index')
                         ->with('success', 'Formulario de creación simulado');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // En una app real: validar y guardar
        // Aquí solo redirigimos como indica la práctica
        return redirect()->route('products.index')
                         ->with('success', 'Producto creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        // Validar ID
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de producto inválido');
        }

        // Obtener producto con relaciones
        $product = Product::with(['category', 'offer'])->find($id);

        if (!$product) {
            abort(404, 'Producto no encontrado');
        }

        $category = $product->category;

        return view('products.show', compact('product', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // En una app real: devolver formulario con datos del producto
        // Aquí solo redirigimos como indica la práctica
        return redirect()->route('products.show', $id)
                         ->with('success', 'Producto editado');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // En una app real: validar y actualizar
        // Aquí solo redirigimos como indica la práctica
        return redirect()->route('products.show', $id)
                         ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // En una app real: eliminar el producto
        // Aquí solo redirigimos como indica la práctica
        return redirect()->route('products.index')
                         ->with('success', 'Producto eliminado exitosamente');
    }
}
