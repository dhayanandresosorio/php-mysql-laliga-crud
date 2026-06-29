# Memoria técnica - PHP MySQL LaLiga CRUD

## 1. Resumen del proyecto

En esta práctica he desarrollado una aplicación CRUD básica utilizando PHP y MySQL.

La aplicación permite gestionar equipos de LaLiga desde una interfaz web sencilla. Incluye login, sesiones, listado de equipos, vista de detalle, inserción, edición, eliminación y preferencias de usuario mediante cookies.

El objetivo principal ha sido practicar la conexión entre PHP y MySQL, la gestión de formularios, el uso de sesiones y la ejecución de consultas SQL desde código PHP.

> [!NOTE]
> Este proyecto no está planteado como una aplicación final de producción. Es un laboratorio técnico para practicar PHP, MySQL, sesiones, cookies, consultas preparadas y organización de código.

---

## 2. Funcionalidades implementadas

La aplicación incluye:

- inicio de sesión;
- cierre de sesión;
- protección de páginas mediante `$_SESSION`;
- listado de equipos;
- detalle de un equipo;
- inserción de nuevos equipos;
- edición de equipos existentes;
- eliminación de equipos;
- preferencia de color de fondo mediante cookie;
- creación de usuarios desde terminal;
- conexión reutilizable a MySQL;
- token CSRF básico en formularios sensibles.

---

## 3. Base de datos

La base de datos principal se llama `laliga`.

Tablas utilizadas:

- `equipos`;
- `usuarios`.

La tabla `equipos` almacena la información de los clubes.

La tabla `usuarios` almacena los usuarios que pueden acceder a la aplicación. En esta versión se utiliza `password_hash` para guardar hashes de contraseña, evitando almacenar contraseñas en texto plano.

---

## 4. Tabla equipos

~~~sql
CREATE TABLE IF NOT EXISTS equipos (
    id_equipo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    estadio VARCHAR(100) NOT NULL,
    fundacion_year YEAR NOT NULL,
    presidente VARCHAR(100),
    presupuesto DECIMAL(12,2)
);
~~~

---

## 5. Tabla usuarios

~~~sql
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);
~~~

La contraseña no se guarda directamente. Se genera un hash mediante `password_hash()` desde PHP.

Para validar el login se utiliza `password_verify()`.

---

## 6. Organización del código

La aplicación se ha reorganizado separando responsabilidades:

- `src/includes/db.php`: conexión a MySQL.
- `src/includes/auth.php`: control de sesión y acceso.
- `src/includes/helpers.php`: funciones auxiliares.
- `src/includes/header.php`: cabecera común.
- `src/includes/footer.php`: cierre HTML común.
- `src/assets/style.css`: estilo básico de la interfaz.

Esta separación hace que el código sea más limpio y más fácil de revisar.

---

## 7. Conexión a MySQL

La conexión se centraliza en `src/includes/db.php`.

El archivo carga la configuración desde `src/config.php`. Si ese archivo no existe, utiliza `src/config.example.php` como plantilla.

~~~php
$config = require __DIR__ . '/../config.php';

$mysqli = new mysqli(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);
~~~

El archivo `src/config.php` está excluido mediante `.gitignore` para evitar subir credenciales reales.

---

## 8. Login y sesiones

El login se realiza desde `src/login.php`.

El formulario envía los datos a `src/comprobar_login.php`.

El proceso de autenticación consulta el usuario en la base de datos y valida la contraseña mediante `password_verify()`.

~~~php
if ($fila && password_verify($password, $fila['password_hash'])) {
    session_regenerate_id(true);
    $_SESSION['usuario'] = $fila['usuario'];
    redirect('listado_equipos.php');
}
~~~

Las páginas internas comprueban si existe una sesión activa mediante `require_login()`.

---

## 9. Consultas preparadas

Las operaciones que reciben datos externos utilizan consultas preparadas.

Ejemplo de inserción:

~~~php
$query = "INSERT INTO equipos (nombre, ciudad, estadio, fundacion_year, presidente, presupuesto)
          VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($query);
$stmt->bind_param('sssisd', $nombre, $ciudad, $estadio, $fundacion_year, $presidente, $presupuesto);
$stmt->execute();
~~~

Esto evita concatenar directamente los datos del formulario dentro de la consulta SQL.

---

## 10. Protección CSRF básica

Para las acciones sensibles se añade un token CSRF básico.

El token se genera en sesión y después se valida en los formularios POST.

~~~php
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    die('Token CSRF inválido.');
}
~~~

---

## 11. Cookies de preferencias

La aplicación permite guardar una preferencia de color de fondo.

El archivo `src/guardar_preferencia.php` guarda la cookie durante 30 días.

~~~php
setcookie('color_fondo', $color_fondo, time() + (30 * 24 * 60 * 60), '/');
~~~

Para evitar valores no deseados, el color se valida contra una lista de colores permitidos.

---

## 12. Limpieza realizada

Durante la preparación del repositorio se han aplicado estos cambios:

- se sustituyó la contraseña real por `CHANGE_ME_DB_PASSWORD`;
- se separó la documentación larga en `docs/`;
- se creó una carpeta `sql/` con scripts reutilizables;
- se movió el código PHP limpio a `src/`;
- se añadieron includes reutilizables;
- se añadió una hoja CSS básica;
- se añadió `.gitignore`;
- se añadió `.gitattributes`;
- se evitó publicar `config.php`;
- se descartó como código activo una versión inicial insegura que mezclaba conexión, formulario e inserción con SQL concatenado.

---

## 13. Valor técnico

Esta práctica demuestra conocimientos básicos pero importantes para desarrollo web con PHP y MySQL:

- conexión a base de datos;
- creación de tablas;
- usuarios y permisos MySQL;
- sesiones;
- cookies;
- formularios;
- operaciones CRUD;
- consultas preparadas;
- separación de configuración;
- protección básica CSRF;
- organización de un repositorio para portfolio.
