# MyShop - Custom Camis

Una aplicación de comercio electrónico desarrollada en Laravel para la gestión y venta de camisetas personalizadas. Permite a los usuarios explorar productos, gestionar su carrito de compras y realizar pedidos, mientras ofrece a los administradores un panel completo para gestionar productos, categorías y usuarios.

## Tecnologías Utilizadas

Este proyecto utiliza un stack moderno basado en PHP y JavaScript:

*   **Backend:**
    *   **PHP:** ^8.2
    *   **Laravel Framework:** ^12.0
    *   **MySQL:** Base de datos relacional.
*   **Frontend:**
    *   **Blade:** Motor de plantillas de Laravel.
    *   **Tailwind CSS:** Framework de utilidades CSS para el diseño.
    *   **Alpine.js:** Framework JavaScript ligero para interactividad.
    *   **Vite:** Herramienta de construcción y desarrollo frontend.
*   **Herramientas de Desarrollo:**
    *   **Laravel Sail:** Entorno de desarrollo local basado en Docker.
    *   **Composer:** Gestor de dependencias de PHP.
    *   **NPM:** Gestor de paquetes de Node.js.

## Estructura del Proyecto

La estructura sigue el estándar de Laravel, destacando los siguientes directorios:

*   `app/Http/Controllers`: Contiene la lógica de negocio (ProductController, CartController, etc.).
*   `app/Models`: Modelos Eloquent que representan las tablas de la base de datos (Product, User, Category, Offer).
*   `database/migrations`: Definiciones del esquema de la base de datos.
*   `database/seeders`: Datos de prueba iniciales (incluyendo usuario administrador).
*   `resources/views`: Plantillas Blade para el frontend (productos, carrito, admin).
*   `routes/web.php`: Definición de todas las rutas de la aplicación.

## Requisitos Previos

Para ejecutar este proyecto en local necesitas tener instalado:

*   **PHP:** Versión 8.2 o superior.
*   **Composer:** Última versión estable.
*   **Node.js & NPM:** Para compilar los assets del frontend.
*   **Docker Desktop:** Recomendado para usar Laravel Sail (base de datos y servicios listos para usar).
*   **MySQL:** Si no usas Docker, necesitas un servidor MySQL local.

## Instrucciones de Instalación

Sigue estos pasos para desplegar el proyecto en tu máquina local:

1.  **Clonar el repositorio:**
    ```bash
    git clone <URL_DEL_REPOSITORIO>
    cd MyShop
    ```

2.  **Instalar dependencias de PHP:**
    ```bash
    composer install
    ```

3.  **Configurar variables de entorno:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Asegúrate de configurar las credenciales de base de datos en el archivo `.env` si no usas Sail.*

4.  **Iniciar el entorno (Opción con Docker/Sail):**
    ```bash
    ./vendor/bin/sail up -d
    ```

5.  **Ejecutar migraciones y seeders (Importar BD y datos de prueba):**
    ```bash
    # Con Sail
    ./vendor/bin/sail artisan migrate --seed
    
    # Sin Sail
    php artisan migrate --seed
    ```

6.  **Instalar y compilar dependencias de Frontend:**
    ```bash
    npm install
    npm run dev
    ```

## Uso Básico

Una vez iniciada la aplicación, puedes acceder a ella desde tu navegador:

*   **URL Principal:** `http://localhost` (o el puerto configurado).
*   **Navegación:** Explora el catálogo de productos, filtra por categorías y añade items al carrito.

### Acceso de Prueba (Admin / Usuario)
El seeder crea usuarios de prueba automáticamente. Puedes usar las siguientes credenciales para acceder a las funciones protegidas y al panel de administración:

*   **Email:** `demo@example.com`
*   **Contraseña:** `password`

## Autores y Créditos

*   **Vicente** - Desarrollador Principal - [GitHub](https://github.com/Vicente-codes)

*Agradecimientos a la comunidad de Laravel por su increíble documentación y recursos.*

## Licencia

Este proyecto es para **Uso Educativo**.

---
*Este proyecto fue desarrollado como parte de un ejercicio académico/práctico.*
