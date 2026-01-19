@extends('layouts.public')

@section('title', 'Contacto - Custom Camis')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Contacta con Nosotros</h1>
                <p class="text-gray-600">Estamos aquí para ayudarte.</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8">
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nombre -->
                    <div class="mb-6">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Nombre Completo</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror"
                               placeholder="Tu nombre">
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-bold mb-2">Correo Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('email') border-red-500 @enderror"
                               placeholder="tu@email.com">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Asunto -->
                    <div class="mb-6">
                        <label for="subject" class="block text-gray-700 font-bold mb-2">Asunto</label>
                        <select name="subject" id="subject"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('subject') border-red-500 @enderror">
                            <option value="" disabled selected>Selecciona un motivo</option>
                            <option value="General" {{ old('subject') == 'General' ? 'selected' : '' }}>Consulta General</option>
                            <option value="Pedido" {{ old('subject') == 'Pedido' ? 'selected' : '' }}>Estado de mi Pedido</option>
                            <option value="Diseño" {{ old('subject') == 'Diseño' ? 'selected' : '' }}>Consulta sobre Diseños</option>
                            <option value="Soporte" {{ old('subject') == 'Soporte' ? 'selected' : '' }}>Soporte Técnico</option>
                        </select>
                        @error('subject')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mensaje -->
                    <div class="mb-6">
                        <label for="message" class="block text-gray-700 font-bold mb-2">Mensaje</label>
                        <textarea name="message" id="message" rows="5"
                                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('message') border-red-500 @enderror"
                                  placeholder="Escribe tu mensaje aquí...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botón Enviar -->
                    <div class="flex items-center justify-end">
                        <button type="submit"
                                class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Enviar Mensaje
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection