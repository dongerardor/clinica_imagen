<?php
// Front controller de la aplicación.
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

define('APP_ROOT', __DIR__ . '/..');
require_once APP_ROOT . '/core/helpers.php';

$rutas = [
    'GET' => [
        '/' => ['HomeControlador', 'inicio'],
        '/pacientes/crear' => ['PacientesControlador', 'crear'],
    ],
    'POST' => [
        '/pacientes/guardar' => ['PacientesControlador', 'guardar'],
    ],
];

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$solicitud = isset($_GET['ruta']) ? $_GET['ruta'] : '/';
$solicitud = '/' . ltrim($solicitud, '/');
$solicitud = $solicitud === '/' ? '/' : rtrim($solicitud, '/');

if (!isset($rutas[$metodo][$solicitud])) {
    http_response_code(404);
    echo '<h1>Página no encontrada</h1>';
    exit;
}

[$controlador, $accion] = $rutas[$metodo][$solicitud];
$archivoControlador = controller_path($controlador);

if (!file_exists($archivoControlador)) {
    http_response_code(500);
    echo '<h1>Error interno</h1>';
    echo '<p>No se encontró el controlador solicitado.</p>';
    exit;
}

require_once $archivoControlador;

if (!class_exists($controlador)) {
    http_response_code(500);
    echo '<h1>Error interno</h1>';
    echo '<p>La clase del controlador no está disponible.</p>';
    exit;
}

$instancia = new $controlador();

if (!method_exists($instancia, $accion)) {
    http_response_code(500);
    echo '<h1>Error interno</h1>';
    echo '<p>La acción solicitada no existe en el controlador.</p>';
    exit;
}

$instancia->$accion();
