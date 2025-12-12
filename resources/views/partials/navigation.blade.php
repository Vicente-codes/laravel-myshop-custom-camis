<!-- resources/views/partials/navigation.blade.php -->
<!-- 
    PARTIAL: NAVIGATION
    
    PROPÓSITO: Menú de navegación principal
    
    CARACTERÍSTICAS:
      - Enlaces a secciones principales
      - Resalta el enlace activo (clase active basada en ruta actual)
      - Responsive (oculto en móvil, visible en desktop)
    
    NOTA: Usa Route::is() de Laravel para detectar ruta activa
-->

<nav class="hidden md:flex space-x-8">
    
    <!-- Enlace: Inicio -->
    <a href="{{ route('welcome') }}" 
       class="text-gray-700 hover:text-primary-600 transition {{ 
           Route::is('welcome') ? 'text-primary-600 font-semibold border-b-2 border-primary-600' : '' 
       }}">
        Inicio
    </a>
    
    <!-- Enlace: Productos -->
    <a href="{{ route('products.index') }}" 
       class="text-gray-700 hover:text-primary-600 transition {{ 
           Route::is('products.*') ? 'text-primary-600 font-semibold border-b-2 border-primary-600' : '' 
       }}">
        Productos
    </a>
    
    <!-- Enlace: Categorías -->
    <a href="{{ route('categories.index') }}" 
       class="text-gray-700 hover:text-primary-600 transition {{ 
           Route::is('categories.*') ? 'text-primary-600 font-semibold border-b-2 border-primary-600' : '' 
       }}">
        Categorías
    </a>
    
    <!-- Enlace: Ofertas -->
    <a href="{{ route('offers.index') }}" 
       class="text-gray-700 hover:text-primary-600 transition {{ 
           Route::is('offers.*') ? 'text-primary-600 font-semibold border-b-2 border-primary-600' : '' 
       }}">
        Ofertas
    </a>
    
    <!-- Enlace: Contacto -->
    <a href="{{ route('contact') }}" 
       class="text-gray-700 hover:text-primary-600 transition {{ 
           Route::is('contact') ? 'text-primary-600 font-semibold border-b-2 border-primary-600' : '' 
       }}">
        Contacto
    </a>
</nav>