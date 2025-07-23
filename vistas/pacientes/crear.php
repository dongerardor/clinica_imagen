<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Nuevo Paciente</title>
    </head>
    <body>
         <!-- 
            Formulario para registrar un nuevo paciente.
            Al hacer clic en "Guardar", se envían los datos por método POST 
            al archivo pacientesControlador.php, que se encarga de procesarlos.
        -->
        <form action="../../controladores/pacientesControlador.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre completo" required><br>
            <input type="email" name="email" placeholder="Correo electrónico" required><br>
            <button type="submit">Guardar</button>
        </form>

         <!-- 
            Si hay un parámetro "exito" en la URL, mostramos un mensaje.
            Esto ocurre luego de que el controlador redirige con "?exito=1" o "?exito=0".
        -->
        <?php if (isset($_GET['exito'])): ?>
            <p><?= $_GET['exito'] ? 'Paciente registrado correctamente!' : 'Error al registrar al paciente.' ?></p>
        <?php endif; ?>
    </body>
</html>