<?php

namespace App\Traits;

/**
 * TRAIT: LoadsMockData
 * 
 * DESCRIPCIÓN:
 * Este trait proporciona métodos para cargar datos mock (de prueba)
 * desde archivos PHP. Los controladores que usan este trait pueden
 * acceder fácilmente a datos de categorías, ofertas, productos y carrito
 * sin necesidad de una base de datos real.
 * 
 * MÉTODOS DISPONIBLES:
 * - getCategories(): Carga y retorna todas las categorías
 * - getOffers(): Carga y retorna todas las ofertas
 * - getCart(): Carga y retorna el carrito actual
 * - getProducts(): Carga y retorna todos los productos
 * - getAllMockData(): Carga y retorna TODOS los datos de una vez
 * - enrichProductsWithOffers(): Enriquece productos con datos de ofertas
 */

trait LoadsMockData
{
    /**
     * MÉTODO: getCategories()
     * 
     * DESCRIPCIÓN:
     * Carga el archivo mock-categories.php y retorna un array
     * con todas las categorías disponibles.
     * 
     * RETORNA: array de categorías
     * EJEMPLO DE USO:
     * $categories = $this->getCategories();
     * // Resultado: array con id 1=>categoría, 2=>categoría, etc.
     */
    protected function getCategories(): array
    {
        return require database_path('data/mock-categories.php');
    }

    /**
     * MÉTODO: getOffers()
     * 
     * DESCRIPCIÓN:
     * Carga el archivo mock-offers.php y retorna un array
     * con todas las ofertas disponibles.
     * 
     * RETORNA: array de ofertas
     * EJEMPLO DE USO:
     * $offers = $this->getOffers();
     * // Resultado: array con id 1=>oferta, 2=>oferta, etc.
     */
    protected function getOffers(): array
    {
        return require database_path('data/mock-offers.php');
    }

    /**
     * MÉTODO: getCart()
     * 
     * DESCRIPCIÓN:
     * Carga el archivo mock-cart.php y retorna un array
     * con los items actualmente en el carrito.
     * 
     * RETORNA: array de items del carrito
     * EJEMPLO DE USO:
     * $cartItems = $this->getCart();
     * // Resultado: array con id 1=>item, 2=>item, etc.
     */
    protected function getCart(): array
    {
        return require database_path('data/mock-cart.php');
    }

    /**
     * MÉTODO: getProducts()
     * 
     * DESCRIPCIÓN:
     * Carga el archivo mock-products.php y retorna un array
     * con todos los productos disponibles en la tienda.
     * 
     * RETORNA: array de productos
     * EJEMPLO DE USO:
     * $products = $this->getProducts();
     * // Resultado: array con id 1=>producto, 2=>producto, etc.
     */
    protected function getProducts(): array
    {
        return require database_path('data/mock-products.php');
    }
}