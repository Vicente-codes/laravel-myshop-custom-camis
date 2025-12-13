@extends('layouts.app')

@section('title', $product['name'] . ' - Custom Camis')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Imagen del Producto -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="h-96 bg-gray-200 flex items-center justify-center">
                    <span class="text-8xl">👕</span>
                </div>
            </div>

            <!-- Información del Producto -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    {{ $product['name'] }}
                </h1>

                <p class="text-gray-600 mb-6">
                    {{ $product['description'] }}
                </p>

                <!-- Precio -->
                <div class="mb-6">
                    @if($product['offer'] !== null)
                        <div class="flex items-baseline gap-3">
                            <span class="text-2xl text-gray-400 line-through">
                                {{ number_format($product['price'], 2) }}€
                            </span>
                            <span class="text-4xl font-bold text-orange-600">
                                {{ number_format($product['final_price'], 2) }}€
                            </span>
                        </div>
                        <p class="text-sm text-orange-600 mt-2">
                            ¡Ahorras {{ number_format($product['price'] - $product['final_price'], 2) }}€!
                        </p>
                    @else
                        <span class="text-4xl font-bold text-primary-600">
                            {{ number_format($product['price'], 2) }}€
                        </span>
                    @endif
                </div>

                <!-- Categoría -->
                @if(isset($category))
                    <div class="mb-6">
                        <span class="text-sm text-gray-500">Categoría</span>
                        <a href="{{ route('categories.show', $category['id']) }}"
                           class="ml-2 bg-primary-100 text-primary-800 px-3 py-1 rounded-full text-sm hover:bg-primary-200 transition">
                            {{ $category['name'] }}
                        </a>
                    </div>
                @endif

                <!-- Oferta -->
                @if($product['offer'] !== null)
                    <div class="mb-6">
                        <span class="text-sm text-gray-500">Oferta Activa</span>
                        <div class="mt-2">
                            <span class="inline-block bg-orange-100 text-orange-800 text-sm px-3 py-1 rounded-full">
                                {{ $product['offer']['name'] }} - {{ $product['offer']['discount_percentage'] }}% descuento
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Botones de Acción -->
                <div class="flex space-x-4">
                    <a href="{{ route('cart.store') }}"
                       class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">
                        Añadir al Carrito
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="border border-primary-600 text-primary-600 px-6 py-3 rounded-lg hover:bg-primary-50 transition">
                        Volver a Productos
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection