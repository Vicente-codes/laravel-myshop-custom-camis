<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * INDEX: Mostrar el carrito del usuario actual
     *
     * En P3 no hay autenticación real, así que usamos el usuario 1.
     * En P4 se reemplazará por auth()->user().
     */
    public function index(): View
    {
        // Usuario por defecto (Usuario Demo)
        $user = User::find(1);

        /**
         * OBTENER PRODUCTOS DEL CARRITO
         *
         * Usamos:
         *     $user->products()->with('category', 'offer')->get();
         * en lugar de $user->products por dos motivos:
         *
         * 1. Eficiencia (Eager Loading)
         *    - Cargamos categoría y oferta en la misma consulta.
         *    - Evita el problema N+1 y reduce el número total de consultas.
         *
         * 2. Flexibilidad
         *    - Al usar el query builder de la relación (products()), podemos añadir
         *      filtros, ordenaciones o paginación en el futuro sin modificar el modelo.
         *
         * En resumen:
         * - Por qué: optimiza rendimiento y evita consultas innecesarias.
         * - Para qué: preparar un carrito más eficiente y escalable.
         */

        $cartProducts = $user->products()
                             ->with('category', 'offer')
                             ->get();

        return view('cart.index', compact('cartProducts'));
    }

    /**
     * STORE: Añadir un producto al carrito
     *
     * En esta práctica se simula.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('cart.index')
                         ->with('success', 'Producto añadido al carrito exitosamente');
    }

    /**
     * UPDATE: Actualizar la cantidad de un producto en el carrito
     *
     * En esta práctica se simula.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        return redirect()->route('cart.index')
                         ->with('success', 'Cantidad actualizada exitosamente');
    }
}
