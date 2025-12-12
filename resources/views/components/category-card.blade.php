<!-- resources/views/components/category-card.blade.php -->
<!-- 
    VISTA DEL COMPONENTE: Category Card
    
    Muestra información de una categoría en forma de tarjeta
-->

<div class="bg-white rounded-lg shadow-lg p-6 cursor-pointer hover:shadow-xl transition {{ $class }}">
    
    <!-- ICONO DE CATEGORÍA -->
    <div class="text-4xl text-primary-500 mb-4">
        👚
    </div>
    
    <!-- NOMBRE DE LA CATEGORÍA -->
    <h4 class="text-xl font-bold mb-2 text-gray-900">
        {{ $category['name'] }}
    </h4>
    
    <!-- DESCRIPCIÓN -->
    <p class="text-gray-600 mb-4 line-clamp-2">
        {{ $category['description'] }}
    </p>
    
    <!-- ENLACE A VER PRODUCTOS -->
    <a href="{{ route('categories.show', $category['id']) }}" 
       class="text-primary-600 font-semibold hover:text-primary-700 transition">
        Ver Productos →
    </a>
</div>