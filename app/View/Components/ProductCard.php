<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * COMPONENTE: ProductCard
 * 
 * DESCRIPCIÓN:
 * Este componente muestra una tarjeta visual de un producto.
 * Es reutilizable en cualquier lugar donde queramos mostrar un producto.
 * 
 * PROPIEDADES (props):
 * - $product: Array con los datos del producto
 * - $class: String con clases CSS adicionales personalizadas
 * 
 * USO:
 * <x-product-card :product="$product" class="custom-class" />
 */

class ProductCard extends Component
{
    /**
     * Datos del producto a mostrar
     */
    public array $product;

    /**
     * Clases CSS adicionales personalizadas
     */
    public string $class;

    /**
     * Constructor - Recibe los parámetros del componente
     */
    public function __construct(array $product, string $class = '')
    {
        $this->product = $product;
        $this->class = $class;
    }

    /**
     * Renderiza la vista del componente
     */
    public function render(): View|Closure|string
    {
        return view('components.product-card');
    }
}
