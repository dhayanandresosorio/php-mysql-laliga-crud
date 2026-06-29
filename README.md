# PHP MySQL LaLiga CRUD

Aplicación CRUD básica desarrollada con PHP y MySQL para gestionar equipos de LaLiga.

El proyecto incluye autenticación de usuarios, sesiones, listado, detalle, creación, edición, eliminación de equipos, preferencias mediante cookies y conexión a base de datos usando `mysqli`.

> [!NOTE]
> Este repositorio está planteado como laboratorio técnico de PHP + MySQL. No es una aplicación de producción, sino una práctica organizada para entender conexión a base de datos, sesiones, formularios, consultas preparadas y operaciones CRUD.

## Objetivo

El objetivo principal es construir una pequeña aplicación web conectada a MySQL, separando la documentación, los scripts SQL y el código PHP.

La aplicación permite:

- iniciar sesión;
- listar equipos;
- ver el detalle de un equipo;
- añadir equipos;
- editar equipos;
- eliminar equipos;
- guardar una preferencia visual mediante cookie;
- crear usuarios desde terminal;
- trabajar con consultas preparadas;
- mantener la configuración fuera del repositorio.

## Tecnologías utilizadas

- PHP
- MySQL
- MySQLi
- SQL
- HTML
- CSS básico
- Sesiones PHP
- Cookies
- Consultas preparadas
- Git y GitHub

## Estructura del repositorio

~~~text
php-mysql-laliga-crud/
|-- README.md
|-- .gitignore
|-- .gitattributes
|-- docs/
|   |-- memoria.md
|   |-- memoria-original.md
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

## Funcionalidades

- Login con usuario y contraseña.
- Control de sesión con `$_SESSION`.
- Cierre de sesión.
- Listado de equipos.
- Vista de detalle.
- Alta de equipos.
- Edición de equipos.
- Eliminación de equipos mediante POST.
- Preferencia de color de fondo con cookie.
- Creación de usuarios desde terminal.
- Conexión MySQL centralizada.
- Plantilla de configuración sin credenciales reales.
- Uso de `password_hash()` y `password_verify()`.
- Uso de consultas preparadas.
- Escape de salida HTML con `htmlspecialchars()`.

## Base de datos

La base de datos utilizada se llama:

~~~text
laliga
~~~

Tablas principales:

- `equipos`
- `usuarios`

La carpeta `sql/` contiene los scripts necesarios para crear la base de datos, las tablas, el usuario de aplicación y algunos datos de ejemplo.

## Configuración local

El archivo real de configuración no se sube al repositorio.

Para ejecutar el proyecto:

1. Copiar `src/config.example.php` como `src/config.php`.
2. Editar la contraseña local de MySQL.
3. Ejecutar los scripts de `sql/`.
4. Crear un usuario de aplicación con `src/crear_usuario.php`.
5. Acceder a `src/login.php`.

Ejemplo:

~~~bash
cp src/config.example.php src/config.php
php src/crear_usuario.php admin contraseña_local
~~~

> [!IMPORTANT]
> Las credenciales reales no forman parte del repositorio. En los ejemplos se utiliza `CHANGE_ME_DB_PASSWORD` como placeholder.

## Seguridad aplicada

Durante la limpieza del proyecto se han aplicado varias mejoras:

- contraseña real sustituida por placeholder;
- archivo `src/config.php` excluido en `.gitignore`;
- uso de `password_hash()` y `password_verify()`;
- consultas preparadas en operaciones con datos;
- borrado mediante POST;
- token CSRF básico en formularios sensibles;
- salida HTML protegida con `htmlspecialchars()`;
- páginas internas protegidas mediante sesión.

## Documentación

La memoria técnica completa está en:

~~~text
docs/memoria.md
~~~

La documentación original de la práctica, limpiada de credenciales, se conserva en:

~~~text
docs/memoria-original.md
~~~
