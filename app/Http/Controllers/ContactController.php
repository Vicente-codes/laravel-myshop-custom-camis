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

    /**
     * STORE: Procesar el formulario de contacto
     *
     * Ruta: POST /contact
     */
    public function store(Request $request)
    {
        // 1. Validar los datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // 2. Enviar el correo
        try {
            \Illuminate\Support\Facades\Mail::to('admin@customcamis.com')->send(new \App\Mail\ContactFormMail($validated));
        } catch (\Exception $e) {
            // En un entorno real, registraríamos el error
            // Log::error('Error enviando correo de contacto: ' . $e->getMessage());
            return back()->with('error', 'Hubo un error al enviar tu mensaje. Por favor, inténtalo de nuevo más tarde.');
        }

        // 3. Redirigir con mensaje de éxito
        return back()->with('success', '¡Gracias por contactarnos! Hemos recibido tu mensaje y te responderemos a la brevedad.');
    }
}
