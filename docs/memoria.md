# Memoria técnica - PHP MySQL LaLiga CRUD

## 1. Punto de partida

Este proyecto empezó como una práctica para trabajar la conexión entre PHP y MySQL.

La idea inicial era sencilla: instalar MySQL, crear una base de datos llamada `laliga`, crear una tabla de equipos y conectar desde PHP para hacer consultas e inserciones.

Al revisar el proyecto para subirlo a GitHub, vi que podía quedar mejor si no lo dejaba como una única documentación larga. Por eso separé el contenido en varias partes:

- código PHP en `src/`;
- scripts SQL en `sql/`;
- documentación técnica en `docs/`;
- configuración de ejemplo sin credenciales reales.

No he querido convertirlo en una aplicación ficticia demasiado grande. La idea sigue siendo la misma: mostrar una práctica real de PHP + MySQL, pero organizada de una forma más limpia.

---

## 2. Qué permite hacer la aplicación

La aplicación permite gestionar equipos de LaLiga desde una interfaz web sencilla.

Funcionalidades principales:

- login de usuario;
- cierre de sesión;
- protección de páginas mediante sesión;
- listado de equipos;
- vista de detalle;
- creación de equipos;
- edición de equipos;
- borrado de equipos;
- preferencia de color de fondo mediante cookie;
- creación de usuarios desde terminal.

---

## 3. Base de datos

La base de datos utilizada se llama `laliga`.

Se utilizan dos tablas principales:

- `equipos`
- `usuarios`

La tabla `equipos` guarda la información de los clubes.

La tabla `usuarios` sirve para controlar el acceso a la aplicación.

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

Campos principales:

- `id_equipo`: identificador del equipo.
- `nombre`: nombre del club.
- `ciudad`: ciudad o sede.
- `estadio`: estadio principal.
- `fundacion_year`: año de fundación.
- `presidente`: presidente del club.
- `presupuesto`: presupuesto aproximado.

---

## 5. Tabla usuarios

~~~sql
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);
~~~

En la versión inicial de la práctica trabajaba con una tabla de usuarios más simple. Al reorganizar el proyecto, cambié el campo de contraseña a `password_hash` para dejar claro que no se debe guardar la contraseña en texto plano.

Desde PHP se usa:

- `password_hash()` para crear el hash;
- `password_verify()` para comprobar la contraseña en el login.

---

## 6. Organización del código

El código está separado para que sea más fácil de entender.

Archivos principales:

- `src/login.php`: formulario de inicio de sesión.
- `src/comprobar_login.php`: validación del usuario.
- `src/listado_equipos.php`: listado principal.
- `src/nuevo_equipo.php`: formulario para añadir equipo.
- `src/insertar_equipo.php`: inserción en base de datos.
- `src/detalle_equipo.php`: detalle de un equipo.
- `src/editar_equipo.php`: formulario de edición.
- `src/actualizar_equipo.php`: actualización de datos.
- `src/borrar_equipo.php`: eliminación de equipo.
- `src/preferencias.php`: formulario para elegir color de fondo.
- `src/guardar_preferencia.php`: guardado de la cookie.
- `src/crear_usuario.php`: creación de usuarios desde terminal.

También añadí una carpeta `includes/` para no repetir código en todos los archivos.

---

## 7. Includes reutilizables

La carpeta `src/includes/` contiene archivos comunes:

- `db.php`: conexión a MySQL.
- `auth.php`: control básico de sesión.
- `helpers.php`: funciones auxiliares.
- `header.php`: inicio de la plantilla HTML.
- `footer.php`: cierre de la plantilla HTML.

Esto hace que el proyecto sea más ordenado que tener conexión, sesión y HTML repetidos en cada archivo.

---

## 8. Conexión a MySQL

La conexión a MySQL se centraliza en `src/includes/db.php`.

El proyecto usa un archivo de configuración de ejemplo:

~~~text
src/config.example.php
~~~

Para ejecutarlo en local, habría que copiarlo como:

~~~text
src/config.php
~~~

El archivo `src/config.php` está en `.gitignore`, porque ahí irían los datos reales de conexión.

---

## 9. Login y sesiones

El login se hace con un formulario en `login.php`.

Después, `comprobar_login.php` busca el usuario en la base de datos y comprueba la contraseña con `password_verify()`.

Si el login es correcto, se guarda el usuario en sesión:

~~~php
$_SESSION['usuario'] = $fila['usuario'];
~~~

Las páginas internas llaman a `require_login()` para evitar que alguien acceda sin iniciar sesión.

---

## 10. CRUD de equipos

El CRUD trabaja sobre la tabla `equipos`.

Operaciones principales:

- `SELECT` para listar y ver detalles;
- `INSERT` para crear equipos;
- `UPDATE` para editar equipos;
- `DELETE` para borrar equipos.

En las operaciones que reciben datos del usuario se utilizan consultas preparadas.

Ejemplo de inserción:

~~~php
$query = "INSERT INTO equipos (nombre, ciudad, estadio, fundacion_year, presidente, presupuesto)
          VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($query);
$stmt->bind_param('sssisd', $nombre, $ciudad, $estadio, $fundacion_year, $presidente, $presupuesto);
$stmt->execute();
~~~

---

## 11. Preferencias con cookies

Añadí una preferencia sencilla de color de fondo.

El usuario elige un color desde `preferencias.php` y se guarda una cookie desde `guardar_preferencia.php`.

~~~php
setcookie('color_fondo', $color_fondo, time() + (30 * 24 * 60 * 60), '/');
~~~

Para no aceptar cualquier valor, el color se compara con una lista de colores permitidos.

---

## 12. Cambios de seguridad básicos

No es una aplicación profesional completa, pero sí he aplicado algunas bases que tienen sentido incluso en una práctica:

- no subir `config.php` con credenciales reales;
- usar una contraseña de ejemplo en la documentación;
- guardar hashes de contraseña;
- usar consultas preparadas;
- escapar la salida HTML con `htmlspecialchars()`;
- hacer el borrado mediante POST;
- añadir un token CSRF básico en formularios sensibles.

Estas mejoras no convierten la práctica en una aplicación lista para producción, pero sí muestran una forma más correcta de organizarla.

---

## 13. Qué mejoraría en una versión más completa

Si quisiera convertir este proyecto en algo más serio, los siguientes pasos serían:

- añadir validaciones más completas en formularios;
- mejorar el diseño visual;
- mostrar mensajes de error y éxito de forma más clara;
- añadir paginación o búsqueda en el listado;
- crear roles de usuario;
- preparar un entorno con Docker;
- añadir pruebas básicas;
- documentar una instalación completa en Apache o Nginx.

---

## 14. Valor de la práctica

Aunque es un proyecto sencillo, me ha servido para practicar varias bases importantes:

- conexión PHP + MySQL;
- creación de base de datos y tablas;
- separación de configuración;
- sesiones;
- cookies;
- operaciones CRUD;
- consultas preparadas;
- organización de un repositorio para GitHub.

Lo más importante de este repo no es que sea una aplicación grande, sino que muestra el proceso de pasar de una práctica básica a un proyecto más ordenado y revisable.
