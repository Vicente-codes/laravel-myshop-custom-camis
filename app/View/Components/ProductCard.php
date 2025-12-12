<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * COMPONENTE: ProductCard
 * 
 * PROPÓSITO: Mostrar una tarjeta de producto reutilizable
 * 
 * PROPS ESPERADOS:
 *   - $product: Array con datos del producto (id, name, price, final_price, offer, etc.)
 *   - $class: (opcional) Clases CSS adicionales
 * 
 * RENDERIZADO:
 *   <x-product-card :product="$product" />
 * 
 * CARACTERÍSTICAS:
 *   - Muestra nombre y descripción
 *   - Destacado visual si tiene oferta (borde naranja)
 *   - Badge con porcentaje de descuento en esquina superior derecha
 *   - Precio original tachado si tiene oferta
 *   - Precio final en grande
 *   - Enlace "Ver Detalles"
 */
class ProductCard extends Component
{
    public array $product;
    public string $class;
    
    /**
     * CONSTRUCTOR
     * 
     * Se ejecuta cuando se crea el componente
     * Recibe los props pasados desde la vista
     */
    public function __construct(array $product = [], string $class = '')
    {
        $this->product = $product;
        $this->class = $class;
    }

    /**
     * MÉTODO: render()
     * 
     * Indica qué vista usar para renderizar este componente
     * Devuelve: resources/views/components/product-card.blade.php
     */
    public function render(): View|Closure|string
    {
        return view('components.product-card');
    }
}
