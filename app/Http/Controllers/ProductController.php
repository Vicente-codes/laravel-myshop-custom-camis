<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CONTROLADOR: ProductController
 * 
 * RESPONSABILIDAD:
 * Gestiona TODOS las operaciones relacionadas con productos.
 * Es un controlador RESOURCE, por lo que implementa:
 * - index: Listar todos los productos
 * - create: Mostrar formulario de creación (simulado)
 * - store: Guardar nuevo producto (simulado)
 * - show: Mostrar detalle de un producto específico
 * - edit: Mostrar formulario de edición (simulado)
 * - update: Guardar cambios (simulado)
 * - destroy: Eliminar un producto (simulado)
 * 
 * RUTAS GENERADAS:
 * - GET /products => ProductController@index (lista de todos)
 * - GET /products/create => ProductController@create (formulario)
 * - POST /products => ProductController@store (guardar)
 * - GET /products/{id} => ProductController@show (detalle)
 * - GET /products/{id}/edit => ProductController@edit (editar formulario)
 * - PUT /products/{id} => ProductController@update (guardar cambios)
 * - DELETE /products/{id} => ProductController@destroy (eliminar)
 * - GET /products/on-sale => ProductController@onSale (solo con ofertas)
 */

class ProductController extends Controller
{
    // Importamos el trait para acceso a métodos de datos mock
    use LoadsMockData;

    /**
     * MÉTODO: index()
     * 
     * DESCRIPCIÓN:
     * Muestra un listado de TODOS los productos disponibles en la tienda.
     * 
     * PASOS:
     * 1. Carga todos los productos
     * 2. Enriquece cada producto con sus datos de oferta
     * 3. Retorna la vista products.index con todos los productos
     * 
     * RETORNA: Vista products/index.blade.php con:
     * - $products: array con todos los productos enriquecidos
     */
    public function index(): View
    {
        // PASO 1: Cargar todos los productos
        $products = $this->getProducts();

        // PASO 2: Enriquecer productos con ofertas y precios finales
        $enrichedProducts = $this->enrichProductsWithOffers($products);

        // PASO 3: Retornar la vista con los productos
        return view('products.index', ['products' => $enrichedProducts]);
    }

    /**
     * MÉTODO: onSale()
     * 
     * DESCRIPCIÓN:
     * Muestra SOLO los productos que tienen una oferta activa.
     * Esto crea la sección de "Ofertas Especiales" de la tienda.
     * 
     * PASOS:
     * 1. Carga todos los productos
     * 2. Enriquece cada producto con sus datos de oferta
     * 3. FILTRA: Mantiene solo los que tienen offer_id != null
     * 4. Retorna la vista products.index (la misma que index())
     *    pero solo con productos con oferta
     * 
     * RETORNA: Vista products/index.blade.php con:
     * - $products: array solo con productos que tienen oferta
     */
    public function onSale(): View
    {
        // PASO 1: Cargar todos los productos
        $products = $this->getProducts();

        // PASO 2: Enriquecer productos
        $enrichedProducts = $this->enrichProductsWithOffers($products);

        // PASO 3: FILTRAR: Mantener solo productos con oferta
        // array_filter mantiene solo los elementos donde la función retorna true
        // Condición: el producto debe tener 'offer' que NO sea null
        $productsOnSale = array_filter($enrichedProducts, function ($product) {
            return $product['offer'] !== null;
        });

        // PASO 4: Retornar la vista con solo productos en oferta
        return view('products.index', ['products' => $productsOnSale]);
    }

    /**
     * MÉTODO: create()
     * 
     * DESCRIPCIÓN:
     * En una aplicación real, mostraría un formulario para crear un producto.
     * 
     * POR AHORA: Solo simulamos que se creó un producto.
     * Más tarde se implementará la funcionalidad real con formulario.
     */
    public function create(): RedirectResponse
    {
        return redirect()
            ->route('products.index')
            ->with('success', 'Formulario de creación de producto (simulado)');
    }

    /**
     * MÉTODO: store()
     * 
     * DESCRIPCIÓN:
     * En una aplicación real, guardería el producto en la base de datos.
     * 
     * POR AHORA: Solo redirigimos con un mensaje simulado.
     * Más tarde se implementará la lógica de guardado real.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()
            ->route('products.index')
            ->with('success', 'Producto creado exitosamente');
    }

    /**
     * MÉTODO: show()
     * 
     * DESCRIPCIÓN:
     * Muestra el DETALLE COMPLETO de un producto específico.
     * 
     * PASOS:
     * 1. Obtiene el ID del producto de la URL
     * 2. Valida que el ID sea un número válido
     * 3. Carga todos los productos
     * 4. Busca el producto con ese ID
     * 5. Valida que el producto exista
     * 6. Enriquece el producto con datos de oferta
     * 7. Obtiene la categoría del producto
     * 8. Retorna la vista show con todos los datos del producto
     * 
     * PARÁMETRO: $id - ID del producto a mostrar (de la URL)
     * 
     * RETORNA: Vista products/show.blade.php con:
     * - $product: array con datos completos del producto enriquecido
     * - $category: array con datos de la categoría del producto
     * 
     * O: Error 404 si el ID no es válido o el producto no existe
     */
    public function show(string $id): View
    {
        // PASO 1: Validar que el ID sea un número
        if (!is_numeric($id) || $id < 1) {
            // Si no es válido, mostrar error 404
            abort(404, 'ID de producto inválido');
        }

        // PASO 2: Cargar todos los productos
        $products = $this->getProducts();

        // PASO 3: Buscar el producto con ese ID
        // Accedemos directamente al array por índice
        $product = $products[$id] ?? null;

        // PASO 4: Validar que el producto exista
        if (!$product) {
            // Si no existe, mostrar error 404
            abort(404, 'Producto no encontrado');
        }

        // PASO 5: Enriquecer el producto con datos de oferta
        $enrichedProducts = $this->enrichProductsWithOffers([$id => $product]);
        $product = $enrichedProducts[$id];

        // PASO 6: Obtener la categoría del producto
        $categories = $this->getCategories();
        $category = $categories[$product['category_id']] ?? null;

        // PASO 7: Retornar la vista con datos completos
        return view('products.show', compact('product', 'category'));
    }

    /**
     * MÉTODO: edit()
     * 
     * DESCRIPCIÓN:
     * En una aplicación real, mostraría un formulario para editar un producto.
     * 
     * POR AHORA: Solo simulamos que se editó un producto.
     * Más tarde se implementará la funcionalidad real con formulario.
     */
    public function edit(string $id): RedirectResponse
    {
        return redirect()
            ->route('products.show', $id)
            ->with('success', 'Producto editado (simulado)');
    }

    /**
     * MÉTODO: update()
     * 
     * DESCRIPCIÓN:
     * En una aplicación real, guardaría los cambios en la base de datos.
     * 
     * POR AHORA: Solo redirigimos con un mensaje simulado.
     * Más tarde se implementará la lógica de guardado real.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        return redirect()
            ->route('products.show', $id)
            ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * MÉTODO: destroy()
     * 
     * DESCRIPCIÓN:
     * En una aplicación real, eliminaría el producto de la base de datos.
     * 
     * POR AHORA: Solo redirigimos con un mensaje simulado.
     * Más tarde se implementará la lógica de eliminación real.
     */
    public function destroy(string $id): RedirectResponse
    {
        return redirect()
            ->route('products.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}