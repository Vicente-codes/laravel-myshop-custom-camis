<?php

namespace App\Traits;

/**
 * TRAIT: LoadsMockData
 * 
 * PROPÓSITO: Centraliza la carga de todos los datos mock (categorías, productos, 
 *            ofertas, carrito) desde archivos PHP ubicados en database/data/
 * 
 * VENTAJAS DE USAR UN TRAIT:
 *   - Reutilización: Cualquier controlador puede "usar" este trait
 *   - Mantenibilidad: Si cambian los datos, solo editamos los archivos mock
 *   - Claridad: Los controladores no necesitan código de carga de datos
 * 
 * MÉTODOS DISPONIBLES:
 *   - getCategories(): Carga todas las categorías
 *   - getOffers(): Carga todas las ofertas
 *   - getProducts(): Carga todos los productos
 *   - getCart(): Carga el contenido del carrito
 *   - getAllMockData(): Carga TODO de una vez
 *   - enrichProductsWithOffers(): Añade información de ofertas a los productos
 */
trait LoadsMockData
{
    /**
     * MÉTODO: getCategories()
     * 
     * PROPÓSITO: Carga el archivo mock-categories.php desde database/data/
     * 
     * CÓMO FUNCIONA:
     *   1. database_path() devuelve la ruta absoluta a la carpeta database/
     *   2. Concatenamos 'data/mock-categories.php'
     *   3. require carga y ejecuta el archivo PHP, devolviendo lo que retorna
     *   4. En este caso, el archivo retorna un array de categorías
     * 
     * RETORNA: Array con todas las categorías
     */
    protected function getCategories(): array //: array → declaración de tipo de retorno. Significa que esta función debe devolver un array.
    {
        return require database_path('data/mock-categories.php'); // Se devuelve el array cargado desde el archivo mock-categories.php
    }

    /**
     * MÉTODO: getOffers()
     * 
     * PROPÓSITO: Carga el archivo mock-offers.php desde database/data/
     * 
     * RETORNA: Array con todas las ofertas disponibles
     */
    protected function getOffers(): array
    {
        return require database_path('data/mock-offers.php');
    }

    /**
     * MÉTODO: getProducts()
     * 
     * PROPÓSITO: Carga el archivo mock-products.php desde database/data/
     * 
     * RETORNA: Array con todos los productos de la tienda
     */
    protected function getProducts(): array
    {
        return require database_path('data/mock-products.php');
    }

    /**
     * MÉTODO: getCart()
     * 
     * PROPÓSITO: Carga el archivo mock-cart.php desde database/data/
     * 
     * RETORNA: Array con los items actualmente en el carrito
     */
    protected function getCart(): array
    {
        return require database_path('data/mock-cart.php');
    }

    /**
     * MÉTODO: getAllMockData()
     * 
     * PROPÓSITO: Carga TODOS los datos mock de una vez en un único array
     * 
     * VENTAJA: Si necesitas múltiples tipos de datos, una sola llamada
     * es más eficiente que llamar a cada método por separado
     * 
     * RETORNA: Array con estructura:
     *   [
     *       'categories' => [...],
     *       'offers' => [...],
     *       'products' => [...],
     *       'cart' => [...]
     *   ]
     */
    protected function getAllMockData(): array
    {
        return [
            'categories' => $this->getCategories(),
            'offers' => $this->getOffers(),
            'products' => $this->getProducts(),
            'cart' => $this->getCart(),
        ];
    }

    /**
     * MÉTODO: enrichProductsWithOffers()
     * 
     * PROPÓSITO: Enriquece cada producto con datos de su oferta y calcula el precio final
     * 
     * CÓMO FUNCIONA:
     *   1. Carga todas las ofertas del sistema
     *   2. Recorre cada producto con array_map()
     *   3. Si el producto tiene una oferta:
     *      a. Añade el objeto 'offer' con los datos completos de la oferta
     *      b. Calcula el precio final restando el descuento
     *   4. Si no tiene oferta:
     *      a. Establece 'offer' a null
     *      b. El precio final es igual al precio original
     * 
     * EJEMPLO:
     *   Producto original: ['price' => 10, 'offer_id' => 1]
     *   Con oferta del 20% de descuento:
     *   Resultado: ['price' => 10, 'offer_id' => 1, 'offer' => {...}, 'final_price' => 8]
     * 
     * PARÁMETROS:
     *   @param array $products Array de productos a enriquecer
     * 
     * RETORNA: Array de productos enriquecidos con oferta y precio final
     */
    protected function enrichProductsWithOffers(array $products): array
    {
        // Obtenemos todas las ofertas disponibles
        $offers = $this->getOffers();

        /**
         * EXPLICACIÓN DE array_map():
         * 
         * array_map() es una función que:
         *   - Recorre cada elemento del array
         *   - Aplica una función a cada elemento
         *   - Devuelve un nuevo array con los resultados
         * 
         * Sintaxis: array_map(function($item) { ... }, $array)
         * 
         * En nuestro caso:
         *   - $product: cada producto del array
         *   - use($offers): importa la variable $offers a la función anónima
         */
        return array_map(function($product) use ($offers) {
            
            /**
             * LÓGICA DE ENRIQUECIMIENTO:
             * 
             * Verificamos:
             *   1. ¿El producto tiene offer_id? (no es null)
             *   2. ¿Existe esa oferta en el array $offers?
             */
            if ($product['offer_id'] !== null && isset($offers[$product['offer_id']])) {
                
                // Obtenemos los datos completos de la oferta
                $offer = $offers[$product['offer_id']];
                
                // Añadimos la oferta completa al producto
                $product['offer'] = $offer;

                /**
                 * CÁLCULO DEL PRECIO FINAL:
                 * 
                 * Fórmula: Precio Final = Precio Original - (Precio Original * % Descuento / 100)
                 * 
                 * Ejemplo: Precio = 10€, Descuento = 20%
                 *   Descuento en euros = 10 * (20 / 100) = 10 * 0.20 = 2€
                 *   Precio Final = 10 - 2 = 8€
                 */
                $discount = $product['price'] * ($offer['discount_percentage'] / 100);
                $product['final_price'] = $product['price'] - $discount;
            } else {
                /**
                 * Si no tiene oferta:
                 *   - offer es null
                 *   - final_price es igual al precio original
                 */
                $product['offer'] = null;
                $product['final_price'] = $product['price'];
            }

            // Retornamos el producto enriquecido
            return $product;

        }, $products);  // Aplica la función a cada $product de $products
    }
}