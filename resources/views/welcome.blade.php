@extends('layouts.public')

@section('title', 'Inicio - Custom Camis')

@push('styles')
    <style>
        .hero-gradient {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/slider-camis.png') }}?v={{ time() }}');
            background-size: cover;
            background-position: center;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                Bienvenido a Custom Camis
            </h2>
            <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                Personaliza tus camisetas bajo demanda. Serigrafía, DTG, vinilo. Perfecto para eventos corporativos, uniformes y equipos deportivos.
            </p>

            <!-- Buscador de Productos -->
            <div class="max-w-xl mx-auto mb-10">
                <form action="{{ route('products.index') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="¿Qué estás buscando? (ej. Camiseta Polo)" 
                           class="w-full py-4 pl-6 pr-14 rounded-full text-gray-900 border-none focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-2xl text-lg placeholder-gray-400">
                    <button type="submit" class="absolute right-2 top-2 bg-primary-600 text-white p-2.5 rounded-full hover:bg-primary-700 transition duration-300 shadow-md flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('products.index') }}"
                   class="bg-white text-primary-600 font-bold py-4 px-8 rounded-full hover:bg-gray-100 transition duration-300">
                    Ver Todos los Productos
                </a>
                <a href="{{ route('products.on-sale') }}"
                   class="border-2 border-white text-white font-bold py-4 px-8 rounded-full hover:bg-white hover:text-primary-600 transition duration-300">
                    Ofertas Especiales
                </a>
            </div>
        </div>
    </section>

    <!-- Categorías Destacadas -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold mb-12 text-center text-gray-900">
                Nuestras Categorías
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($featuredCategories as $category)
                    <x-category-card :category="$category" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No hay categorías disponibles.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Productos Destacados -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold mb-12 text-center text-gray-900">
                Productos Destacados
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No hay productos destacados.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection