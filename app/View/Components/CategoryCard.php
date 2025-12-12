<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * COMPONENTE: CategoryCard
 * 
 * PROPÓSITO: Mostrar una tarjeta de categoría reutilizable
 * 
 * PROPS ESPERADOS:
 *   - $category: Array con datos de la categoría (id, name, description, slug)
 *   - $class: (opcional) Clases CSS adicionales
 * 
 * RENDERIZADO:
 *   <x-category-card :category="$category" />
 */
class CategoryCard extends Component
{
    public array $category;
    public string $class;
    
    public function __construct(array $category = [], string $class = '')
    {
        $this->category = $category;
        $this->class = $class;
    }

    public function render(): View|Closure|string
    {
        return view('components.category-card');
    }
}
