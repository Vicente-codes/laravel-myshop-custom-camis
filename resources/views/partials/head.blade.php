<!-- resources/views/partials/head.blade.php -->
<!-- 
    PARTIAL: HEAD
    
    PROPÓSITO: Centralizar toda la configuración del <head> HTML
    
    INCLUYE:
      - Meta tags (charset, viewport, etc.)
      - Título dinámico de cada página
      - CDN de Tailwind CSS
      - Configuración de colores personalizados
      - Stack para estilos adicionales
    
    USO: Se incluye en el layout maestro con @include('partials.head')
-->

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Custom Camis - Camisetas Personalizadas')</title>

<!-- Tailwind CSS desde CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Configuración de colores personalizados para la marca -->
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    // Colores corporativos de Custom Camis
                    primary: {
                        500: '#3b82f6',  // Azul principal
                        600: '#2563eb',  // Azul oscuro
                        700: '#1d4ed8',  // Azul más oscuro
                    },
                    custom: {
                        orange: '#ff6b35',  // Naranja para ofertas
                    }
                }
            }
        }
    }
</script>

<!-- Stack de estilos (permite que las vistas añadan CSS personalizado) -->
@stack('styles')