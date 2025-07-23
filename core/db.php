<?php

// -----------------------------------------------------------------------------
// ARCHIVO DE CONEXIÓN A LA BASE DE DATOS
// -----------------------------------------------------------------------------
// Este archivo forma parte del directorio "core", donde colocamos elementos 
// compartidos por todo el sistema (como la conexión a la base de datos).
// 
// Este archivo se encarga de establecer la conexión entre PHP y MySQL.
// Se utiliza en todos los modelos que necesiten interactuar con la base de datos.
// -----------------------------------------------------------------------------

// Parámetros de conexión. En XAMPP, el usuario suele ser 'root' sin contraseña.
$host = 'localhost';
$usuario = 'root';
$contrasena = ''; // en XAMPP, por defecto no hay contraseña
$base_datos = 'clinica';

// Crear la conexión utilizando la extensión mysqli en modo orientado a objetos.
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// verificamos la conexeón
if($conn->connect_error) {
    // Si hay error, detenemos la ejecución y mostramos el mensaje.
    die("Error de conexión: ". $conn->connect_error);
}