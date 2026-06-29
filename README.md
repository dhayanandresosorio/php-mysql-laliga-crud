# PHP MySQL LaLiga CRUD

Proyecto de práctica realizado con PHP y MySQL para gestionar equipos de LaLiga mediante un CRUD sencillo.

El proyecto empezó como una práctica de conexión entre PHP y MySQL. Después lo he reorganizado para GitHub separando el código PHP, los scripts SQL y la documentación, de forma que se pueda revisar mejor y no quede todo mezclado en un único README.

## Qué trabaja este proyecto

La aplicación permite:

- iniciar sesión con usuario y contraseña;
- mantener la sesión activa con `$_SESSION`;
- listar equipos;
- ver el detalle de un equipo;
- añadir equipos;
- editar equipos;
- eliminar equipos;
- guardar una preferencia visual con una cookie;
- crear usuarios desde terminal;
- conectar PHP con MySQL usando `mysqli`.

También he añadido algunas mejoras básicas para que el código quede más limpio, como separar la conexión a base de datos, usar una configuración de ejemplo y evitar subir credenciales reales.

## Tecnologías utilizadas

- PHP
- MySQL
- MySQLi
- SQL
- HTML
- CSS básico
- Sesiones PHP
- Cookies
- Git y GitHub

## Estructura del repositorio

~~~text
php-mysql-laliga-crud/
|-- README.md
|-- .gitignore
|-- .gitattributes
|-- docs/
|   |-- memoria.md
|   |-- apuntes-originales.md
|-- sql/
|   |-- README.md
|   |-- 01_create_database.sql
|   |-- 02_create_tables.sql
|   |-- 03_create_app_user.sql
|   |-- 04_sample_data.sql
|-- src/
|   |-- config.example.php
|   |-- index.php
|   |-- login.php
|   |-- comprobar_login.php
|   |-- logout.php
|   |-- listado_equipos.php
|   |-- nuevo_equipo.php
|   |-- insertar_equipo.php
|   |-- detalle_equipo.php
|   |-- editar_equipo.php
|   |-- actualizar_equipo.php
|   |-- borrar_equipo.php
|   |-- preferencias.php
|   |-- guardar_preferencia.php
|   |-- crear_usuario.php
|   |-- assets/
|   |   |-- style.css
|   |-- includes/
|   |   |-- auth.php
|   |   |-- db.php
|   |   |-- helpers.php
|   |   |-- header.php
|   |   |-- footer.php
~~~

## Base de datos

La base de datos utilizada se llama `laliga`.

Tablas principales:

- `equipos`
- `usuarios`

Los scripts SQL están separados en la carpeta `sql/` para poder crear la base de datos, las tablas, el usuario de aplicación y algunos datos de ejemplo.

## Cómo probarlo en local

El archivo real de configuración no se sube al repositorio.

Para probar el proyecto:

1. Copiar `src/config.example.php` como `src/config.php`.
2. Cambiar la contraseña de ejemplo por la contraseña local de MySQL.
3. Ejecutar los scripts de la carpeta `sql/`.
4. Crear un usuario de acceso con `src/crear_usuario.php`.
5. Entrar desde `src/login.php`.

Ejemplo:

~~~bash
cp src/config.example.php src/config.php
php src/crear_usuario.php admin contraseña_local
~~~

En el repositorio se usa `CHANGE_ME_DB_PASSWORD` como valor de ejemplo.

## Cambios que hice al preparar el repo

La práctica original estaba más centrada en documentar los pasos de instalación y conexión a MySQL. Para dejarla mejor como proyecto de GitHub, hice estos cambios:

- separé el código PHP en `src/`;
- añadí scripts SQL reutilizables en `sql/`;
- separé funciones comunes en `src/includes/`;
- añadí una hoja de estilos básica;
- moví la explicación larga a `docs/memoria.md`;
- limpié credenciales y dejé una configuración de ejemplo;
- añadí `.gitignore` y `.gitattributes`.

## Notas

Es un proyecto de práctica, no una aplicación pensada para producción. Aun así, he intentado aplicar buenas bases: consultas preparadas, contraseña hasheada, separación de configuración, control de sesión y borrado mediante POST.

La memoria técnica está en:

~~~text
docs/memoria.md
~~~

Los apuntes originales de la práctica, ya limpiados de credenciales, están en:

~~~text
docs/apuntes-originales.md
~~~
