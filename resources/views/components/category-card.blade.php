<!-- Componente: Tarjeta de Categoría -->
<!-- Muestra una categoría en forma de tarjeta -->

<div class="bg-white rounded-lg shadow-lg p-6 product-card cursor-pointer hover:shadow-xl transition {{ $class }}">
    <!-- Icono -->
    @if($category->image)
        <img src="{{ asset('images/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-48 object-cover rounded-t-lg mb-4">
    @else
        <div class="text-4xl text-primary-500 mb-4 h-48 flex items-center justify-center bg-gray-100 rounded-t-lg">📂</div>
    @endif

    <!-- Nombre de la Categoría -->
    <h4 class="text-xl font-bold mb-2 text-gray-900">
        {{ $category->name }}
    </h4>

    <!-- Descripción -->
    <p class="text-gray-600 mb-4">
        {{ $category->description }}
    </p>

    <!-- Botón Ver Productos -->
    <a href="{{ route('categories.show', $category->id) }}"
       class="text-primary-600 font-semibold hover:text-primary-700 transition">
        Ver Productos →
    </a>
</div>