@extends('layouts.app')

@section('title', 'Carrito - Custom Camis')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Mi Carrito</h1>
        <p class="text-gray-600">Revisa los productos que has seleccionado.</p>
    </div>

    @if($cartProducts->isNotEmpty())
        <!-- TABLA DE CARRITO -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Producto</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Precio</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Cantidad</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $total = 0; @endphp

                        @foreach($cartProducts as $product)
                            @php
                                /**
                                 * ACCESO A DATOS DEL PRODUCTO
                                 *
                                 * $product->name = Nombre del producto
                                 * $product->price = Precio original
                                 * $product->final_price = Precio con descuento (calculado por accessor)
                                 * $product->pivot->quantity = Cantidad en el carrito
                                 *
                                 * $product->pivot accede a los datos de la tabla pivot (product_user)
                                 * Contiene: product_id, user_id, quantity, created_at, updated_at
                                 */
                                $subtotal = $product->final_price * $product->pivot->quantity;
                                $total += $subtotal;
                            @endphp

                            <tr class="hover:bg-gray-50">
                                <!-- NOMBRE Y CATEGORÍA DEL PRODUCTO -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="text-3xl mr-4">👕</div>
                                        <div>
                                            <!-- Acceso a propiedad del producto -->
                                            <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                                            <!-- Acceso a relación: product->category -->
                                            <div class="text-sm text-gray-600">{{ $product->category->name }}</div>

                                            <!-- Badge de oferta si existe -->
                                            @if($product->offer)
                                                <span class="inline-block bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full mt-1">
                                                    {{ $product->offer->discount_percentage }}% OFF
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- PRECIO -->
                                <td class="px-6 py-4">
                                    @if($product->offer)
                                        <!-- Si tiene oferta, mostrar precio original tachado -->
                                        <div>
                                            <span class="text-sm text-gray-400 line-through">
                                                {{ number_format($product->price, 2) }}€
                                            </span>
                                        </div>
                                        <!-- Precio final en naranja -->
                                        <div class="font-semibold text-orange-600">
                                            {{ number_format($product->final_price, 2) }}€
                                        </div>
                                    @else
                                        <!-- Sin oferta, solo precio -->
                                        <div class="font-semibold text-gray-900">
                                            {{ number_format($product->final_price, 2) }}€
                                        </div>
                                    @endif
                                </td>

                                <!-- CANTIDAD -->
                                <td class="px-6 py-4">
                                    <!-- Acceso a pivot: quantity de la tabla product_user -->
                                    <span class="inline-block bg-gray-100 px-3 py-1 rounded">
                                        {{ $product->pivot->quantity }}
                                    </span>
                                </td>

                                <!-- SUBTOTAL -->
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    {{ number_format($subtotal, 2) }}€
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- TOTAL -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <div class="text-right">
                    <p class="text-gray-600 mb-2">Total:</p>
                    <p class="text-3xl font-bold text-primary-600">
                        {{ number_format($total, 2) }}€
                    </p>
                </div>
            </div>
        </div>

        <!-- BOTONES -->
        <div class="mt-6 flex justify-between">
            <a href="{{ route('products.index') }}"
               class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                Seguir Comprando
            </a>
            <button class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">
                Proceder al Pago
            </button>
        </div>

    @else
        <!-- CARRITO VACÍO -->
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <p class="text-gray-500 text-lg mb-6">Tu carrito está vacío.</p>
            <a href="{{ route('products.index') }}"
               class="inline-block bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">
                Ver Productos
            </a>
        </div>
    @endif
</div>
@endsection