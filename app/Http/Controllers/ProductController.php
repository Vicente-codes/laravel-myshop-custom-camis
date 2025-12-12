<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CONTROLADOR: ProductController
 * 
 * RESPONSABILIDAD: Gestionar todas las operaciones con productos
 * 
 * Este es un controlador RESOURCE, lo que significa que implementa
 * los métodos estándar CRUD de Laravel:
 *   - index(): Listar todos los productos
 *   - create(): Mostrar formulario de creación
 *   - store(): Guardar un nuevo producto
 *   - show(): Ver detalle de un producto
 *   - edit(): Mostrar formulario de edición
 *   - update(): Actualizar un producto existente
 *   - destroy(): Eliminar un producto
 * 
 * Además añadimos:
 *   - onSale(): Mostrar solo productos con ofertas
 */
class ProductController extends Controller
{
    use LoadsMockData;

    /**
     * MÉTODO: index()
     * 
     * PROPÓSITO: Mostrar el listado de TODOS los productos
     * 
     * RUTA: GET /products
     * NOMBRE DE RUTA: products.index
     * 
     * LÓGICA:
     *   1. Cargar todos los productos
     *   2. Enriquecer con datos de ofertas
     *   3. Enviar a la vista para mostrarlos
     * 
     * RETORNA: Vista con listado de productos
     */
    public function index(): View
    {
        // Obtener todos los productos
        $products = $this->getProducts();

        /**
         * Enriquecer productos con:
         *   - offer: datos de la oferta asociada
         *   - final_price: precio con descuento
         */
        $enrichedProducts = $this->enrichProductsWithOffers($products);

        // Enviar a la vista 'products.index'
        // El array $enrichedProducts estará disponible como $products en la vista
        return view('products.index', ['products' => $enrichedProducts]);
    }

    /**
     * MÉTODO: onSale()
     * 
     * PROPÓSITO: Mostrar SOLO los productos que tienen oferta activa
     * 
     * RUTA: GET /products-on-sale
     * NOMBRE DE RUTA: products.on-sale
     * 
     * LÓGICA:
     *   1. Cargar todos los productos
     *   2. Enriquecer con ofertas
     *   3. Filtrar solo aquellos cuya 'offer' no sea null
     *   4. Enviar a la vista
     * 
     * RETORNA: Vista con solo productos en oferta
     */
    public function onSale(): View
    {
        // Obtener todos los productos
        $products = $this->getProducts();
        
        // Enriquecer con datos de ofertas
        $enrichedProducts = $this->enrichProductsWithOffers($products);

        /**
         * Filtrar productos que tengan oferta
         * 
         * array_filter() recorre el array y mantiene solo los elementos
         * que hacen true la función de comparación
         * 
         * En nuestro caso: mantener solo si $product['offer'] !== null
         */
        $productsOnSale = array_filter($enrichedProducts, function($product) {
            return $product['offer'] !== null;
        });

        // Enviar a la misma vista que index(), pero con solo productos en oferta
        return view('products.index', ['products' => $productsOnSale]);
    }

    /**
     * MÉTODO: create()
     * 
     * PROPÓSITO: Mostrar el formulario para crear un nuevo producto
     * 
     * RUTA: GET /products/create
     * NOMBRE DE RUTA: products.create
     * 
     * NOTA: En esta práctica es simulado, no hay formulario real
     * 
     * RETORNA: Redirección a la lista con mensaje
     */
    public function create()
    {
        return redirect()->route('products.index')
            ->with('success', 'Formulario de creación de producto (simulado)');
    }

    /**
     * MÉTODO: store()
     * 
     * PROPÓSITO: Guardar un nuevo producto en la base de datos
     * 
     * RUTA: POST /products
     * NOMBRE DE RUTA: products.store
     * 
     * PARÁMETROS:
     *   @param Request $request Los datos del formulario
     * 
     * NOTA: En esta práctica es simulado, no guarda datos reales
     * 
     * RETORNA: Redirección a la lista con mensaje de éxito
     */
    public function store(Request $request)
    {
        return redirect()->route('products.index')
            ->with('success', 'Producto creado exitosamente');
    }

    /**
     * MÉTODO: show()
     * 
     * PROPÓSITO: Mostrar los detalles completos de un producto específico
     * 
     * RUTA: GET /products/{id}
     * NOMBRE DE RUTA: products.show
     * 
     * PARÁMETROS:
     *   @param string $id El ID del producto a mostrar
     * 
     * LÓGICA:
     *   1. Validar que el ID sea un número válido
     *   2. Cargar el producto por su ID
     *   3. Si no existe, mostrar error 404
     *   4. Enriquecer el producto con oferta y precio final
     *   5. Cargar la categoría del producto
     *   6. Enviar a la vista de detalle
     * 
     * RETORNA: Vista con detalle del producto o error 404
     */
    public function show(string $id): View
    {
        /**
         * Validación del ID
         * 
         * Comprobamos que:
         *   - is_numeric($id): Es un número
         *   - $id < 1: No es cero ni negativo
         * 
         * Si falla, abort(404) muestra página de error
         */
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de producto inválido');
        }

        // Obtener todos los productos
        $products = $this->getProducts();

        /**
         * Buscar el producto por su ID
         * 
         * $products[$id] ?? null significa:
         *   - Si existe $products[$id], usar ese valor
         *   - Si no existe, usar null
         */
        $product = $products[$id] ?? null;

        // Si el producto no existe, mostrar error
        if (!$product) {
            abort(404, 'Producto no encontrado');
        }

        /**
         * Enriquecer el producto
         * 
         * Lo metemos en un array temporal para poder usar enrichProductsWithOffers
         * Luego extraemos el resultado
         */
        $enrichedProducts = $this->enrichProductsWithOffers([$id => $product]);
        $product = $enrichedProducts[$id];

        /**
         * Obtener la categoría del producto
         * 
         * Usamos $product['category_id'] para encontrar su categoría
         */
        $categories = $this->getCategories();
        $category = $categories[$product['category_id']] ?? null;

        // Enviar el producto enriquecido y su categoría a la vista
        return view('products.show', compact('product', 'category'));
    }

    /**
     * MÉTODO: edit()
     * 
     * PROPÓSITO: Mostrar el formulario para editar un producto
     * 
     * RUTA: GET /products/{id}/edit
     * NOMBRE DE RUTA: products.edit
     * 
     * PARÁMETROS:
     *   @param string $id El ID del producto a editar
     * 
     * NOTA: En esta práctica es simulado
     * 
     * RETORNA: Redirección al detalle con mensaje
     */
    public function edit(string $id)
    {
        return redirect()->route('products.show', $id)
            ->with('success', 'Producto editado');
    }

    /**
     * MÉTODO: update()
     * 
     * PROPÓSITO: Actualizar un producto existente
     * 
     * RUTA: PUT/PATCH /products/{id}
     * NOMBRE DE RUTA: products.update
     * 
     * PARÁMETROS:
     *   @param Request $request Los datos nuevos del formulario
     *   @param string $id El ID del producto a actualizar
     * 
     * NOTA: En esta práctica es simulado
     * 
     * RETORNA: Redirección al detalle con mensaje de éxito
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('products.show', $id)
            ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * MÉTODO: destroy()
     * 
     * PROPÓSITO: Eliminar un producto de la tienda
     * 
     * RUTA: DELETE /products/{id}
     * NOMBRE DE RUTA: products.destroy
     * 
     * PARÁMETROS:
     *   @param string $id El ID del producto a eliminar
     * 
     * NOTA: En esta práctica es simulado
     * 
     * RETORNA: Redirección a la lista con mensaje de éxito
     */
    public function destroy(string $id)
    {
        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}