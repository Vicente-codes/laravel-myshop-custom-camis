<!-- resources/views/partials/header.blade.php -->
<!-- 
    PARTIAL: HEADER
    
    PROPÓSITO: Barra superior del sitio con logo, navegación y acceso al carrito
    
    ELEMENTOS:
      - Logo/marca de Custom Camis
      - Menú de navegación (incluido vía partial)
      - Enlace al carrito
    
    NOTA: Es visible en todas las páginas (definido en layout maestro)
-->

<header class="bg-white shadow-lg">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            
            <!-- LOGO/MARCA -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('welcome') }}" class="text-2xl font-bold text-primary-600">
                    👕 Custom Camis
                </a>
                <p class="hidden sm:block text-sm text-gray-600">
                    Camisetas Personalizadas
                </p>
            </div>
            
            <!-- NAVEGACIÓN (incluida desde otro partial) -->
            @include('partials.navigation')
            
            <!-- ENLACE AL CARRITO -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('cart.index') }}" 
                   class="text-gray-700 hover:text-primary-600 transition font-semibold">
                    🛒 Carrito
                </a>
            </div>
        </div>
    </div>
</header>