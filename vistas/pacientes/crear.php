<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Nuevo Paciente</title>
    </head>
    <body>
        <!--
            Formulario para registrar un nuevo paciente.
            Al hacer clic en "Guardar", se envían los datos por método POST
            al controlador de pacientes a través del front controller.
        -->
        <form action="<?= htmlspecialchars(url('/pacientes/guardar'), ENT_QUOTES, 'UTF-8'); ?>" method="POST">
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

        <p><a href="<?= htmlspecialchars(url('/'), ENT_QUOTES, 'UTF-8'); ?>">Volver al inicio</a></p>
    </body>
</html>
