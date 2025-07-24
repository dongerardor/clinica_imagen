<?php

// -----------------------------------------------------------------------------
// CONTROLADOR DE PACIENTES
// -----------------------------------------------------------------------------
// Los controladores se encargan de recibir las acciones del usuario 
// (como enviar un formulario), procesar los datos, y coordinar con los modelos 
// (acceso a base de datos) y las vistas (interfaz).
// En este caso, este controlador se encarga de registrar un nuevo paciente.
// -----------------------------------------------------------------------------

// Abajo: se muestran errores en pantalla para facilitar la depuración durante el desarrollo.
// No se recomienda dejar esto activo en un servidor en producción.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cargar el modelo Paciente, que contiene la función para guardar en la base de datos.
require_once('../modelos/Paciente.php');

// Verificar si la solicitud fue por POST (es decir, si se envió el formulario).
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Obtengo los datos enviados desde el formulario.
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    // si guardo al paciente bien... éxito!!
    $exito = Paciente::crear($nombre, $email);

    // y luego, me voy al formulario nuevamente, diciendo si tuve éxito o no.
    header('Location: ../vistas/pacientes/crear.php?exito=' . ($exito ? '1' : '0'));
}