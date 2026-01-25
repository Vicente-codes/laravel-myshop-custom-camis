<div class="bg-white rounded-lg shadow-lg overflow-hidden product-card {{ $class }} relative {{ $product->offer ? 'ring-2 ring-orange-400' : '' }} flex flex-col h-full">
    <!-- Badge de oferta destacado (esquina superior derecha) -->
    @if($product->offer)
        <div class="absolute top-0 right-0 bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-2 rounded-bl-lg font-bold shadow-lg z-10">
            <span class="text-lg">
                -{{ $product->offer->discount_percentage }}%
            </span>
        </div>
    @endif

    <!-- Slot opcional para botón adicional en esquina superior izquierda (ej: eliminar de wishlist) -->
    @isset($topAction)
        <div class="absolute top-2 left-2 z-10">
            {{ $topAction }}
        </div>
    @endisset

    <!-- Contenedor de la imagen del producto -->
    <div class="h-48 bg-gray-200 flex items-center justify-center overflow-hidden {{ $product->offer ? 'bg-gradient-to-br from-orange-50 to-red-50' : '' }}">
        @if(!empty($product->image))
            <!-- Mostrar la imagen del producto Si contiene '/', viene de storage, Si no, viene de /public/images-->
            <!-- Esto permite usar dos sistemas de almacenamiento sin romper nada. -->
            <img src="{{ Str::contains($product->image, '/') ? asset('storage/' . $product->image) : asset('images/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover">
        @else
            <!-- Si NO hay imagen, mostrar un icono por defecto -->
            <span class="text-4xl">👕</span>
        @endif
    </div>

    <!-- Contenedor de información: Flex grow para ocupar espacio y alinear el fondo -->
    <div class="p-6 flex flex-col flex-grow">
        <h4 class="text-xl font-bold mb-2 text-gray-900">{{ $product->name }}</h4>
        <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 80) }}</p>

        <!-- Badge de oferta adicional (nombre de la oferta si el producto tiene una) -->
        @if($product->offer)
            <div class="mb-4">
            <!-- Etiqueta visual (badge) que destaca la oferta del producto.
             Se muestra solo cuando existe una oferta asociada.
             Incluye:
             - El nombre de la oferta.
             - Opcionalmente, el mínimo de unidades necesarias para aplicarla. -->    
            <span class="inline-block bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full font-semibold">
                    🏷️ {{ $product->offer->name }}
                    @if($product->offer->min_quantity > 1)
                        (Mín. {{ $product->offer->min_quantity }} uds)
                    @endif
                </span>
            </div>
        @endif

        <!-- Sección inferior empujada hacia abajo -->
        <div class="mt-auto">
            <!-- Precio -->
            <div class="mb-4">
                @if($product->offer)
                    @php
                        // Calculamos el precio POTENCIAL de oferta para mostrarlo visualmente
                        $discountedPrice = $product->price - ($product->price * ($product->offer->discount_percentage / 100));
                    @endphp
                    
                    <div class="flex flex-col">
                        <div class="flex items-baseline gap-2">
                            <span class="text-sm text-gray-400 line-through">€{{ number_format($product->price, 2) }}</span>
                            <span class="text-2xl font-bold text-orange-600">
                                €{{ number_format($discountedPrice, 2) }}
                            </span>
                        </div>
                        
                        <!-- Mostrar aviso solo si la oferta requiere comprar más de 1 unidad -->
                        @if($product->offer->min_quantity > 1)
                            
                        <!-- Mensaje informativo que explica al usuario que el precio con descuento
                            solo se aplica si compra la cantidad mínima establecida en la oferta.
                            Este texto aparece debajo del precio para aclarar la condición. -->
                        <span class="text-xs text-orange-600 font-medium mt-1">
                                * Precio aplicable comprando {{ $product->offer->min_quantity }} o más unidades
                            </span>
                        @endif
                    </div>
                @else
                    <span class="text-2xl font-bold text-primary-600">€{{ number_format($product->final_price, 2) }}</span>
                @endif
            </div>
    
            <!-- Acciones personalizables mediante slot -->
            @isset($actions)
                {{ $actions }}
            @else
                <!-- Acción por defecto: Ver Detalles -->
                <a href="{{ route('products.show', $product->id) }}" 
                   class="block text-center bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                    Ver Detalles
                </a>
            @endisset
        </div>
    </div>
</div>