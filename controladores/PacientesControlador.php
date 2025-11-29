<?php

require_once __DIR__ . '/../core/helpers.php';
require_once APP_ROOT . '/modelos/Paciente.php';

class PacientesControlador
{
    public function crear(): void
    {
        require view_path('pacientes/crear.php');
    }

    public function guardar(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            http_response_code(405);
            echo '<h1>Método no permitido</h1>';
            return;
        }

        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';

        $exito = Paciente::crear($nombre, $email);

        $destino = url('/pacientes/crear', [
            'exito' => $exito ? 1 : 0,
        ]);

        header('Location: ' . $destino);
        exit;
    }
}
