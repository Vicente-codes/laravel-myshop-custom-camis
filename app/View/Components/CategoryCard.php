<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryCard extends Component
{
    /**
     * COMPONENTE: CategoryCard
     *
     * Tarjeta reutilizable que muestra una categoría.
     * Se usa en: listados, menús, secciones destacadas, etc.
     *
     * CARACTERÍSTICAS:
     * - Recibe un objeto Eloquent Category (no arrays).
     * - Permite añadir clases CSS opcionales desde la vista.
     * - Usa Illuminate\Contracts\View\View (mejor práctica).
     */

    public function __construct(
        public Category $category,
        public string $class = ''
    ) {
        // El constructor asigna automáticamente las propiedades públicas.
    }

    public function render(): View|Closure|string
    {
        return view('components.category-card');
    }
}

