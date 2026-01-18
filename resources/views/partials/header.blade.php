<!-- Carrito de Compras -->
<header class="bg-white shadow-lg relative">
    <div class="container mx-auto px-6 py-2">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex flex-1 items-center space-x-4">
            <a href="{{ route('welcome') }}">
                    <img src="{{ asset('images/horizontal2.png') }}" alt="Custom Camis" class="h-16 w-auto">
                </a>
            </div>
            
        <!-- Navegación usando partial -->
        @include('partials.navigation')
            
            <!-- Carrito -->
            @php
                $cart = session('cart', []);
                $totalQuantity = array_sum(array_column($cart, 'quantity'));
            @endphp
            <div class="flex flex-1 items-center space-x-4 justify-end">
            <a href="{{ route('cart.index') }}" 
                class="text-gray-700 hover:text-primary-600 transition">
                    🛒 Carrito ( {{ $totalQuantity }} )
            </a>
            </div>
        </div>
    </div>
</header>