@extends('layouts.public')

@section('title', $product->name . ' - Custom Camis')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Imagen del Producto -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="h-96 bg-gray-200 flex items-center justify-center overflow-hidden">
                    @if(!empty($product->image))
                        <img src="{{ $product->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-8xl">👕</span>
                    @endif
                </div>
            </div>

            <!-- Información del Producto -->
            <div class="bg-white rounded-lg shadow-lg p-6">

                <!-- Nombre -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    {{ $product->name }}
                </h1>

                <!-- Descripción -->
                <p class="text-gray-600 mb-6">
                    {{ $product->description }}
                </p>

                <!-- Precio -->
                <div class="mb-6">
                    @if($product->offer)
                        @php
                            // Calculamos el precio POTENCIAL manualmente
                            $discountedPrice = $product->price - ($product->price * ($product->offer->discount_percentage / 100));
                        @endphp

                        <div class="flex flex-col">
                            <div class="flex items-baseline gap-3">
                                <span class="text-2xl text-gray-400 line-through">
                                    €{{ number_format($product->price, 2) }}
                                </span>
                                <span class="text-4xl font-bold text-orange-600">
                                    €{{ number_format($discountedPrice, 2) }}
                                </span>
                            </div>

                            <!-- Mostrar aviso solo si la oferta requiere comprar más de 1 unidad -->
                            @if($product->offer->min_quantity > 1)
                            <!-- Mensaje informativo indicando la cantidad mínima para obtener el precio especial -->
                                <p class="text-sm text-orange-600 mt-2 font-medium">
                                    * Precio especial comprando {{ $product->offer->min_quantity }} o más unidades
                                </p>
                            @endif

                            <p class="text-sm text-green-600 mt-2">
                                ¡Ahorras €{{ number_format($product->price - $discountedPrice, 2) }} por unidad!
                            </p>
                        </div>
                    @else
                        <span class="text-4xl font-bold text-primary-600">
                            €{{ number_format($product->price, 2) }}
                        </span>
                    @endif
                </div>

                <!-- Categoría -->
                @if($product->category)
                    <div class="mb-6">
                        <span class="text-sm text-gray-500">Categoría:</span>
                        <a href="{{ route('categories.show', $product->category->id) }}"
                           class="ml-2 bg-primary-100 text-primary-800 px-3 py-1 rounded-full text-sm hover:bg-primary-200 transition">
                            {{ $product->category->name }}
                        </a>
                    </div>
                @endif

                <!-- Oferta -->
                @if($product->offer)
                    <div class="mb-6">
                        <span class="text-sm text-gray-500">Oferta activa:</span>
                        <div class="mt-2">
                            <span class="inline-block bg-orange-100 text-orange-800 text-sm px-3 py-1 rounded-full">
                                🏷 {{ $product->offer->name }}
                                (-{{ $product->offer->discount_percentage }}%)
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Botones de Acción -->
                <div class="flex items-center space-x-4">
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <!-- Selector de Tallas -->
                        <!-- Antes de mostrar el selector, el sistema comprueba si el producto realmente tiene tallas.
                        Solo se muestra este bloque si 'sizes' NO está vacío y contiene al menos un elemento. -->
                        @if(!empty($product->sizes) && count($product->sizes) > 0)
                            <div class="mb-4">
                                
                                <!-- Etiqueta del selector de tallas -->
                                <label for="size" class="block text-gray-700 font-bold mb-2">Selecciona tu Talla:</label>
                                
                                <!-- Selector desplegable de tallas.
                                El atributo REQUIRED obliga al usuario a elegir una talla antes de continuar.
                                Mientras no se seleccione una opción válida, el formulario NO permitirá añadir al carrito. -->
                                <select name="size" id="size" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" required>
                                    
                                    <!-- Opción inicial deshabilitada, obliga a tomar una decisión -->
                                    <option value="" disabled selected>Elige una opción...</option>
                                    
                                    <!-- Recorrido de todas las tallas disponibles del producto -->
                                    @foreach($product->sizes as $size)
                                        <option value="{{ $size }}">{{ $size }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            {{-- Si no hay tallas definidas, enviamos una por defecto o ocultamos el selector --}}
                             <input type="hidden" name="size" value="U">
                        @endif

                        <button type="submit" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full">
                            🛒 Añadir al Carrito
                        </button>
                    </form>

                    {{-- Botón de Wishlist (solo para usuarios autenticados) --}}
                    @auth
                        <form action="{{ route('wishlist.store', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="border-2 border-red-500 text-red-500 px-6 py-3 rounded-lg hover:bg-red-500 hover:text-white transition">
                                ❤️ Guardar en Favoritos
                            </button>
                        </form>
                    @endauth

                    <a href="{{ route('products.index') }}" 
                    class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-100 transition">
                        ← Volver a Productos
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
