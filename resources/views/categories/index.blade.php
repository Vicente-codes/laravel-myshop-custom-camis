@extends('layouts.public')

@section('title', 'Categorías - Custom Camis')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Nuestras Categorías</h1>
            <p class="text-gray-600">Explora nuestros productos organizados por categoría.</p>
        </div>

        @if(!empty($categories))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <x-category-card :category="$category" />
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No hay categorías disponibles.</p>
            </div>
        @endif
    </div>
@endsection