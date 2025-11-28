<?php

declare(strict_types=1);

if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

if (!function_exists('view_path')) {
    function view_path(string $relative): string
    {
        return APP_ROOT . '/vistas/' . ltrim($relative, '/');
    }
}

if (!function_exists('controller_path')) {
    function controller_path(string $controller): string
    {
        return APP_ROOT . '/controladores/' . $controller . '.php';
    }
}

if (!function_exists('url')) {
    /**
     * Genera una URL que siempre pasa por el front controller.
     */
    function url(string $path, array $query = []): string
    {
        $path = '/' . ltrim($path, '/');
        $params = ['ruta' => $path];
        if (!empty($query)) {
            $params = array_merge($params, $query);
        }

        $frontController = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
        if ($frontController === '') {
            $frontController = '/index.php';
        }

        if ($frontController[0] !== '/') {
            $frontController = '/' . ltrim($frontController, '/');
        }

        return $frontController . '?' . http_build_query($params);
    }
}
