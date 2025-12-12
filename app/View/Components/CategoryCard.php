<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryCard extends Component
{
    public array $category;
    public string $class;

    public function __construct(array $category, string $class = '')
    {
        $this->category = $category;
        $this->class = $class;
    }

    public function render(): View|Closure|string
    {
        return view('components.category-card');
    }
}
