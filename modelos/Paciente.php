<?php

// -----------------------------------------------------------------------------
// MODELO: PACIENTE
// -----------------------------------------------------------------------------
// Los modelos se encargan de acceder y manipular los datos en la base de datos.
// Este archivo define la clase Paciente y su método para registrar un nuevo paciente.
// -----------------------------------------------------------------------------


// Incluir el archivo de conexión a la base de datos.
// __DIR__ representa la carpeta actual, por eso usamos '../core/db.php' para subir un nivel.
require_once(__DIR__.'/../core/db.php');

// Definimos la clase Paciente, que encapsula las acciones relacionadas con la tabla pacientes.
class Paciente {

    // Método estático para crear un nuevo paciente.
    public static function crear($nombre, $email){

        global $conn; // Usamos la conexión creada en db.php

        // Preparamos la consulta SQL con placeholders (?) para evitar inyección SQL.
        $stmt = $conn->prepare("INSERT INTO pacientes(nombre, email) VALUES (?, ?)");

        // Asociamos los valores recibidos a los placeholders de forma segura.
        $stmt->bind_param("ss", $nombre, $email); // "ss" indica que son dos strings
        // Nunca insertes directamente variables en la SQL si puedes usar sentencias preparadas como ésta!
        // Es una de las mejores prácticas básicas de desarrollo web seguro.

        // Ejecutamos la consulta y devolvemos true o false según el resultado.
        return $stmt->execute();
    }
}