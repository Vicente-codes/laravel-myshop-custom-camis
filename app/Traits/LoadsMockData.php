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

    /**
     * MÉTODO: getAllMockData()
     * 
     * DESCRIPCIÓN:
     * Carga TODOS los datos mock de una vez (categorías, ofertas,
     * carrito y productos). Útil cuando necesitas varios datos juntos.
     * 
     * RETORNA: array asociativo con claves: 'categories', 'offers', 'cart', 'products'
     * EJEMPLO DE USO:
     * $allData = $this->getAllMockData();
     * // Resultado: [
     * //     'categories' => [...],
     * //     'offers' => [...],
     * //     'cart' => [...],
     * //     'products' => [...]
     * // ]
     */
    protected function getAllMockData(): array
    {
        return [
            'categories' => $this->getCategories(),
            'offers' => $this->getOffers(),
            'cart' => $this->getCart(),
            'products' => $this->getProducts(),
        ];
    }

    /**
     * MÉTODO: enrichProductsWithOffers()
     * 
     * DESCRIPCIÓN:
     * Este es el método MÁS IMPORTANTE del trait.
     * 
     * Toma un array de productos y "enriquece" cada uno con:
     * 1. Los datos completos de su oferta (si tiene)
     * 2. El precio final después de aplicar el descuento
     * 
     * ESTO ES CRÍTICO porque:
     * - Evita hacer cálculos en las vistas (mala práctica)
     * - Centraliza la lógica de descuentos
     * - Los componentes Blade reciben datos listos para mostrar
     * 
     * PARÁMETROS:
     * - $products: Array de productos a procesar
     * 
     * RETORNA: Array de productos enriquecidos con 'offer' y 'final_price'
     * 
     * EJEMPLO DE USO:
     * $rawProducts = $this->getProducts(); // Sin ofertas enriquecidas
     * $enrichedProducts = $this->enrichProductsWithOffers($rawProducts);
     * // Ahora cada producto tiene:
     * //   - $product['offer']: datos completos de la oferta (o null)
     * //   - $product['final_price']: precio después del descuento
     */
    protected function enrichProductsWithOffers(array $products): array
    {
        // Obtenemos TODAS las ofertas de una vez para búsqueda rápida
        $offers = $this->getOffers();

        // Recorremos cada producto y lo procesamos
        return array_map(function ($product) use ($offers) {
            // PASO 1: Verificar si el producto tiene una oferta
            if ($product['offer_id'] !== null && isset($offers[$product['offer_id']])) {
                // El producto tiene oferta y la oferta existe
                $offer = $offers[$product['offer_id']];
                
                // PASO 2: Asignamos la oferta al producto
                $product['offer'] = $offer;

                // PASO 3: Calculamos el precio final con descuento
                // Fórmula: descuento = (precio × porcentaje) / 100
                $discount = ($product['price'] * $offer['discount_percentage']) / 100;
                
                // Precio final = precio original - descuento
                $product['final_price'] = $product['price'] - $discount;
            } else {
                // El producto NO tiene oferta
                $product['offer'] = null;
                $product['final_price'] = $product['price'];
            }

            // Retornamos el producto enriquecido con los nuevos datos
            return $product;
        }, $products);
    }
}