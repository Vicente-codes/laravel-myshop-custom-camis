<!-- resources/views/layouts/app.blade.php -->
<!-- 
    LAYOUT MAESTRO
    
    PROPÓSITO: Estructura base de TODAS las páginas de la tienda
    
    CONTENIDO:
      1. Estructura HTML completa (<!DOCTYPE>, <html>, <head>, <body>)
      2. Inclusión de partials (head, header, footer)
      3. @yield('content') - Aquí va el contenido de cada página
      4. @stack('scripts') - Para scripts personalizados de cada página
    
    FLUJO:
      welcome.blade.php → @extends('layouts.app') → Hereda esta estructura
      El contenido de welcome.blade.php reemplaza @yield('content')
-->

<!DOCTYPE html>
<html lang="es">
    <head>
        @include('partials.head')
    </head>
    
    <body class="bg-gray-50">
        
        <!-- HEADER CON NAVEGACIÓN -->
        @include('partials.header')
        
        <!-- CONTENIDO PRINCIPAL (reemplazado por cada vista) -->
        <main class="min-h-screen">
            @yield('content')
        </main>
        
        <!-- FOOTER -->
        @include('partials.footer')
        
        <!-- Stack para scripts de cada página -->
        @stack('scripts')
    </body>
</html>