<?php

namespace App\View\Components;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCard extends Component
{
    /**
     * COMPONENTE: ProductCard
     *
     * Tarjeta reutilizable que muestra un producto.
     * Se usa en: índice de productos, categorías, ofertas, etc.
     *
     * CARACTERÍSTICAS:
     * - Recibe un objeto Eloquent Product (no arrays).
     * - Permite añadir clases CSS opcionales desde la vista.
     * - Usa Illuminate\Contracts\View\View (mejor práctica).
     */

    public function __construct(
        public Product $product,
        public string $class = ''
    ) {
        // El constructor asigna automáticamente las propiedades públicas.
    }

    public function render(): View|Closure|string
    {
        return view('components.product-card');
    }
}

