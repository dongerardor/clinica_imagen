# Centralizar el enrutamiento HTTP

Centralizar el enrutamiento significa que todas las peticiones del navegador pasan primero por un único archivo PHP (por ejemplo `public/index.php`). Ese archivo actúa como "recepcionista": recibe la solicitud, decide qué controlador debe atenderla y le entrega los datos necesarios.

## ¿Por qué nos conviene?

1. **Una sola puerta de entrada.** Así evitamos que las vistas se abran directamente en el navegador. En lugar de acceder a `vistas/pacientes/crear.php`, siempre se visita `index.php` y este decide mostrar el formulario apropiado. Esto reduce la duplicación y previene accesos inesperados a archivos internos.

2. **Organización más clara.** Tener un punto central facilita ver todas las rutas de la aplicación en un mismo lugar (por ejemplo, un arreglo de rutas). Eso hace más sencillo agregar nuevas pantallas o modificar las existentes sin tener que buscar archivos dispersos.

3. **Mejor control y seguridad.** El front controller puede aplicar validaciones comunes (autenticación, sanitización de datos, manejo de errores) antes de entregar la petición al controlador específico. Esto ahorra código repetido y ayuda a mantener las reglas de negocio en un solo sitio.

## ¿Cómo implementarlo paso a paso?

1. **Crear el front controller.** Moveríamos `index.php` a una carpeta pública (`public/index.php`) y haríamos que todas las solicitudes lleguen ahí (ajustando el servidor o `.htaccess`).
2. **Definir una tabla de rutas.** Dentro de `index.php`, podríamos tener un arreglo que asocie cada URL con el controlador y la acción a ejecutar, por ejemplo:
   ```php
   $rutas = [
       '/' => ['PacientesControlador', 'listar'],
       '/pacientes/crear' => ['PacientesControlador', 'crear'],
       '/pacientes/guardar' => ['PacientesControlador', 'guardar'],
   ];
   ```
3. **Despachar la solicitud.** El front controller lee la URL solicitada, busca la ruta correspondiente y crea el controlador adecuado. Si no encuentra la ruta, responde con un error 404 controlado.
4. **Renderizar la vista.** El controlador prepara los datos y se los pasa a una vista. Como todo pasa por el front controller, también podemos definir un motor de plantillas simple o incluir encabezados y pies de página comunes.

## Implementación actual

El repositorio ya incluye un `public/index.php` que aplica esta idea usando un parámetro `ruta` en la URL. Todas las vistas utilizan el helper `url()` para generar enlaces que pasan por el front controller, y cada controlador (por ejemplo, `PacientesControlador`) expone métodos por acción (`crear`, `guardar`). Así mantenemos la estructura organizada y evitamos exponer archivos internos directamente.

## Resultado esperado

Al final, tendremos una estructura donde los archivos públicos viven en `public/`, los controladores en `controladores/`, los modelos en `modelos/` y las vistas en `vistas/`. Las nuevas rutas se agregan editando un solo archivo, y cualquier lógica transversal (logs, seguridad, sesiones) se maneja en un único lugar antes de llegar a los controladores. Esto vuelve al proyecto más escalable y mantenible a medida que crece.
