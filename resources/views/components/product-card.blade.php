<!-- resources/views/components/product-card.blade.php -->
<!-- 
    VISTA DEL COMPONENTE: Product Card
    
    PROPÓSITO: Mostrar una tarjeta atractiva de un producto
    
    DATOS DISPONIBLES:
      - $product: Array con todos los datos del producto
      - $class: Clases CSS adicionales (pasadas como prop)
    
    CARACTERÍSTICAS:
      1. Borde naranja si tiene oferta (ring-2 ring-orange-400)
      2. Badge naranja en esquina superior derecha con % de descuento
      3. Imagen placeholder
      4. Nombre del producto
      5. Descripción corta
      6. Badge con nombre de la oferta (si tiene)
      7. Precios (original tachado + final)
      8. Botón "Ver Detalles"
-->

<div class="bg-white rounded-lg shadow-lg overflow-hidden {{ 
    $product['offer'] !== null ? 'ring-2 ring-orange-400' : '' 
}} {{ $class }}">
    
    <!-- BADGE DE OFERTA (esquina superior derecha) -->
    @if($product['offer'] !== null)
        <div class="absolute top-0 right-0 bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-2 rounded-bl-lg font-bold shadow-lg z-10">
            <span class="text-lg">-{{ $product['offer']['discount_percentage'] }}%</span>
        </div>
    @endif
    
    <!-- IMAGEN DEL PRODUCTO (placeholder) -->
    <div class="h-48 bg-gray-200 flex items-center justify-center {{ 
        $product['offer'] !== null ? 'bg-gradient-to-br from-orange-50 to-red-50' : '' 
    }}">
        <span class="text-4xl">👕</span>
    </div>
    
    <!-- INFORMACIÓN DEL PRODUCTO -->
    <div class="p-6">
        
        <!-- Nombre -->
        <h4 class="text-xl font-bold mb-2 text-gray-900">
            {{ $product['name'] }}
        </h4>
        
        <!-- Descripción breve -->
        <p class="text-gray-600 mb-4 line-clamp-2">
            {{ $product['description'] }}
        </p>
        
        <!-- Badge del nombre de la oferta -->
        @if($product['offer'] !== null)
            <div class="mb-4">
                <span class="inline-block bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full font-semibold">
                    {{ $product['offer']['name'] }}
                </span>
            </div>
        @endif
        
        <!-- PRECIOS Y BOTÓN -->
        <div class="flex items-center justify-between flex-wrap gap-2">
            
            <!-- SECCIÓN DE PRECIOS -->
            <div class="flex flex-col">
                @if($product['offer'] !== null)
                    <!-- Precio original tachado -->
                    <span class="text-sm text-gray-400 line-through">
                        {{ number_format($product['price'], 2) }}€
                    </span>
                    <!-- Precio final (descuentado) -->
                    <span class="text-2xl font-bold text-orange-600">
                        {{ number_format($product['final_price'], 2) }}€
                    </span>
                @else
                    <!-- Precio normal (sin oferta) -->
                    <span class="text-2xl font-bold text-primary-600">
                        {{ number_format($product['price'], 2) }}€
                    </span>
                @endif
            </div>
            
            <!-- BOTÓN VER DETALLES -->
            <a href="{{ route('products.show', $product['id']) }}" 
               class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                Ver Detalles
            </a>
        </div>
    </div>
</div>