<footer class="bg-gray-800 text-white py-8 mt-12">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <h5 class="text-xl font-bold mb-4">Custom Camis S.L.</h5>
                <p class="text-gray-400">Especialistas en personalización de camisetas bajo demanda para empresas y eventos.</p>
            </div>
            <div>
                <h6 class="font-bold mb-4">Enlaces Rápidos</h6>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('welcome') }}" class="hover:text-white transition">Inicio</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Productos</a></li>
                    <li><a href="{{ route('categories.index') }}" class="hover:text-white transition">Categorías</a></li>
                    <li><a href="{{ route('offers.index') }}" class="hover:text-white transition">Ofertas</a></li>
                </ul>
            </div>
            <div>
                <h6 class="font-bold mb-4">Contacto</h6>
                <ul class="space-y-2 text-gray-400">
                    <li>📧 contacto@example.com</li>
                    <li>📞 +34 XXX XXX XXX</li>
                    <li>📍 Madrid, España</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Custom Camis S.L. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>