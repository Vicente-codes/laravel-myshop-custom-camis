<header class="bg-white shadow-lg">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('welcome') }}" class="text-2xl font-bold text-primary-600 hover:text-primary-700">
                    Custom Camis
                </a>
            </div>

            <!-- Navegación -->
            @include('partials.navigation')

            <!-- Carrito -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-primary-600 transition">
                    🛒 Carrito
                </a>
            </div>
        </div>
    </div>
</header>