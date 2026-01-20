@extends('layouts.public')

@section('title', 'Ofertas - Custom Camis')

@section('content')
    <div class="container mx-auto px-6 py-12">

        <!-- Encabezado Minimalista -->
        <div class="mb-16 text-center">
            <h1 class="text-5xl font-extrabold text-gray-900 mb-4 tracking-tight leading-tight">
                Ofertas <span class="text-orange-600 block sm:inline">Especiales</span>
            </h1>
            <div class="h-1 w-24 bg-gray-900 mx-auto mb-6"></div>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto font-light">
                Descubre nuestra selección curada de productos con descuentos exclusivos. Calidad de impresión premium a precios inigualables.
            </p>
        </div>

        <!-- Listado de Ofertas Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($offers as $offer)
                <div class="group relative bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-300 ease-in-out transform hover:-translate-y-1 overflow-hidden">
                    
                    <!-- Decorative Top Bar -->
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-500 to-red-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>

                    <div class="p-8">
                        <!-- Discount Badge (Creative Sticker Style) -->
                        <div class="absolute top-4 right-4 rotate-12 group-hover:rotate-0 transition-transform duration-300">
                            <div class="bg-gray-900 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                                -{{ $offer->discount_percentage }}%
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-orange-600 transition-colors">
                            {{ $offer->name }}
                        </h3>

                        <p class="text-gray-500 mb-8 leading-relaxed line-clamp-3">
                            {{ $offer->description }}
                        </p>

                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-sm font-medium text-gray-400 group-hover:text-gray-600 transition-colors">
                                Ver colección
                            </span>
                            <a href="{{ route('offers.show', $offer->id) }}"
                               class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-50 text-gray-900 group-hover:bg-orange-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-20 text-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                    <p class="text-gray-500 text-lg font-medium">No hay ofertas disponibles en este momento.</p>
                    <p class="text-gray-400">Vuelve pronto para ver nuevas promociones.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection
