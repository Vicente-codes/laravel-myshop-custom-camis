<!-- resources/views/partials/footer.blade.php -->
<!-- 
    PARTIAL: FOOTER
    
    PROPÓSITO: Pie de página con información corporativa
    
    SECCIONES:
      - Descripción de Custom Camis
      - Enlaces rápidos
      - Información de contacto
      - Derechos de autor
-->

<footer class="bg-gray-800 text-white py-8 mt-12">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- SECCIÓN 1: Información de la empresa -->
            <div>
                <h5 class="text-xl font-bold mb-4">Custom Camis S.L.</h5>
                <p class="text-gray-400">
                    Especialistas en personalización de camisetas bajo demanda. 
                    Soluciones para empresas y consumidores finales.
                </p>
            </div>
            
            <!-- SECCIÓN 2: Enlaces rápidos -->
            <div>
                <h6 class="font-bold mb-4">Enlaces Rápidos</h6>
                <ul class="space-y-2 text-gray-400">
                    <li>
                        <a href="{{ route('welcome') }}" class="hover:text-white transition">
                            Inicio
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="hover:text-white transition">
                            Productos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" class="hover:text-white transition">
                            Categorías
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="hover:text-white transition">
                            Contacto
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- SECCIÓN 3: Contacto -->
            <div>
                <h6 class="font-bold mb-4">Contacto</h6>
                <ul class="space-y-2 text-gray-400">
                    <li>📧 info@customcamis.com</li>
                    <li>📞 +34 XXX XXX XXX</li>
                    <li>🕐 Lunes a Viernes: 9:00 - 18:00</li>
                </ul>
            </div>
        </div>
        
        <!-- DERECHOS DE AUTOR -->
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; 2025 Custom Camis S.L. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>