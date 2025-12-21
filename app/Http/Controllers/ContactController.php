<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // ← Añadido según la práctica 3
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * CONTROLADOR: ContactController
     *
     * Gestiona la página de contacto de la tienda.
     * En esta práctica es una página estática con un mensaje "En construcción".
     *
     * PROPÓSITO:
     * - Proporcionar un lugar para que futuros desarrolladores creen
     *   un formulario de contacto real
     * - En P4 o posteriores se implementará la funcionalidad completa
     */

    /**
     * INDEX: Mostrar la página de contacto
     *
     * Ruta: GET /contact
     * Vista: resources/views/contact.blade.php
     */
    public function index(): View
    {
        return view('contact');
    }
}
