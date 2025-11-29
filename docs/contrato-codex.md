# **Contrato Codex v1.0 – Proyecto Clínica Imagen (MVC-Light)**

_Documento de convenciones técnicas para desarrollo asistido por IA y humanos._

---

## 1. Estructura del Proyecto

```
clinica/
│
├── public/              # Punto de entrada HTTP (Front Controller)
│   └── index.php
│
├── controladores/       # Controladores (CamelCase)
│   └── NombreControlador.php
│
├── modelos/             # Modelos (CamelCase)
│   └── Nombre.php
│
├── vistas/              # Vistas PHP/HTML simples
│   ├── home.php
│   └── entidad/
│       └── vista.php
│
├── core/                # Infraestructura
│   ├── helpers.php
│   └── db.php
│
└── docs/                # Documentación del proyecto
```

**Regla:** Toda nueva funcionalidad debe respetar esta estructura.

---

## 2. Convenciones de Nombres

### 2.1 Controladores

- Archivo: `NombreControlador.php`
- Clase: `class NombreControlador`
- Métodos públicos (acciones):

  - `index()`, `crear()`, `guardar()`, `editar()`, `actualizar()`, `eliminar()`

**Ejemplo:**

```php
class PacientesControlador { ... }
```

---

### 2.2 Modelos

- Archivo: `Nombre.php`
- Clase: `class Nombre`
- Métodos típicos:

  - `obtenerTodos()`, `buscarPorId($id)`, `guardar()`, `actualizar()`, `eliminar()`

---

### 2.3 Vistas

- Ubicación: `/vistas/<entidad>/<vista>.php`
- No contienen lógica de negocio.
- Pueden incluir loops y condicionales simples.
- Reciben datos ya preparados por el controlador.

---

## 3. Router (Front Controller)

El punto de entrada único es:

```
public/index.php
```

El router usa un array `$rutas`:

```php
$rutas = [
    'GET' => [
        '/' => ['HomeControlador', 'inicio'],
        '/pacientes/crear' => ['PacientesControlador', 'crear'],
    ],
    'POST' => [
        '/pacientes/guardar' => ['PacientesControlador', 'guardar'],
    ],
];
```

### Reglas del Router

1. La ruta se pasa mediante el parámetro GET `?ruta=...`.
2. Siempre debe comenzar con `/`.
3. No se debe inventar otra forma de routing.
4. El router:

   1. Detecta método HTTP
   2. Normaliza la ruta
   3. Busca coincidencia exacta
   4. Carga el controlador
   5. Ejecuta la acción correspondiente

---

## 4. Helpers

### 4.1 APP_ROOT

Definición:

```php
define('APP_ROOT', dirname(__DIR__));
```

Esto apunta al directorio raíz del proyecto, subiendo desde `/public`.

---

### 4.2 URL Helper

Toda ruta debe generarse con:

```php
url('/pacientes/crear');
```

Genera:

```
/index.php?ruta=/pacientes/crear
```

---

### 4.3 Path Helpers

```php
controller_path($nombre);
view_path($ruta);
```

Usarlos siempre; no construir rutas a mano.

---

## 5. Autoloading Manual

Antes de instanciar un controlador:

```php
require_once controller_path($controlador);
```

Regla: Nunca usar Composer ni PSR-4 en este proyecto.

---

## 6. Base de Datos (`core/db.php`)

Debe existir una función `db()` que devuelva siempre el mismo PDO:

```php
function db(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        $pdo = new PDO('mysql:host=localhost;dbname=clinica', 'user', 'pass');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $pdo;
}
```

### Reglas:

- Todas las consultas deben usar prepared statements.
- Los modelos deben depender siempre de `db()`.

---

## 7. Reglas para Controladores

Los controladores deben:

1. Sanitizar datos con `trim()`.
2. Validar entradas según corresponda.
3. Interactuar con los modelos.
4. Elegir la vista adecuada.
5. Pasar datos en variables simples.
6. No emitir HTML directamente (excepto mensajes breves).

Ejemplo:

```php
public function crear() {
    require view_path('pacientes/crear.php');
}
```

---

## 8. Vistas

Las vistas:

- No contienen SQL.
- No contienen lógica de negocio.
- Pueden usar pequeñas estructuras de control (`if`, `foreach`).
- Son HTML + PHP liviano.
- Se cargan siempre desde un controlador.

---

## 9. Sesiones

Reglas:

- Iniciar sesión solo donde se necesite:

```php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
```

- No iniciar sesiones en vistas.
- Pueden usarse para autenticación y mensajes flash.

---

## 10. Seguridad Mínima Obligatoria

- Usar `password_hash()` y `password_verify()`.
- Sanitizar entradas de usuario.
- Validar formularios en servidor.
- Usar prepared statements siempre.
- Nunca interpolar variables directamente en SQL.

---

## 11. Reglas Específicas para Codex

Codex debe:

1. Respetar estrictamente esta estructura y convenciones.
2. Crear los archivos en las carpetas correctas.
3. Nombrar clases y archivos en CamelCase.
4. Usar siempre `url()`, `view_path()`, `controller_path()`.
5. Utilizar `db()` para acceder a la base de datos.
6. No inventar rutas ni carpetas nuevas.
7. No colocar lógica en las vistas.
8. No escribir consultas sin prepared statements.
9. No usar funciones o técnicas que no estén en este contrato.
10. Mantener el código simple, claro y legible.

---

# Fin del Contrato Codex v1.0
