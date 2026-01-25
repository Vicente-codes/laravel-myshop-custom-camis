<?php
//Todas las peticiones HTTP en Laravel pasan por este punto de entrada: public/index.php 
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// 1. Cargar el autoloader de Composer
require __DIR__.'/../vendor/autoload.php';

// 2. Crear la instancia de la aplicación Laravel
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// 3. Procesar la petición y obtener la respuesta
$app->handleRequest(Request::capture());

//El archivo index.php es el único archivo PHP accesible directamente desde el navegador. Todos
//los demás archivos de la aplicación están protegidos por estar fuera del directorio public , lo que
//añade una capa esencial de seguridad.