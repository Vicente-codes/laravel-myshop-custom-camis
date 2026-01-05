<!DOCTYPE html>
<html lang="es">
<head>
    @include('partials.head')
</head>
<body class="bg-gray-50">
    <!-- Header con navegación -->
    @include('partials.header')

    <!-- Contenido principal -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    @stack('scripts')
</body>
</html>