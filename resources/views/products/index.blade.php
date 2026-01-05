@extends('layouts.public')

@section('title', 'Productos - Custom Camis')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Todos los Productos</h1>
            <p class="text-gray-600">Explora nuestro completo catálogo de camisetas personalizadas.</p>
        </div>

        @if(!empty($products))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No hay productos disponibles.</p>
            </div>
        @endif
    </div>
@endsection