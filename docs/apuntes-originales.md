
# Instalación y configuración de MySQL para una aplicación PHP

## 1. Instalación del servicio de base de datos

Instalar un servicio de base de datos en la máquina donde tenemos la aplicación PHP.

En primer lugar, hemos de actualizar los repositorios e instalar el paquete básico para poder tener un servidor MySQL. Para ello usaremos las siguientes órdenes:

```bash
isard@dhayan:~$ sudo apt update
isard@dhayan:~$ sudo apt install mysql-server
````

## 2. Comprobación del estado del servicio

Comprobamos que el servicio está activo:

```bash
isard@dhayan:~$ sudo systemctl status mysql
```

Salida esperada:

```text
● mysql.service - MySQL Community Server
    Loaded: loaded (/usr/lib/systemd/system/mysql.service; enabled; preset: enabled)
    Active: active (running) since Tue 2026-01-20 02:03:53 CET; 1min 12s ago
    Process: 4716 ExecStartPre=/usr/share/mysql/mysql-systemd-start pre (code=exited, status=0/SUCCESS)
    Main PID: 4725 (mysqld)
    Status: "Server is operational"
    Tasks: 37 (limit: 4603)
    Memory: 353.6M (peak: 378.0M)
    CPU: 1.410s
    CGroup: /system.slice/mysql.service
            └─4725 /usr/sbin/mysqld
```

Mensajes del sistema:

```text
de gen. 20 02:03:52 dhayan systemd[1]: Starting mysql.service - MySQL Community Server...
de gen. 20 02:03:53 dhayan systemd[1]: Started mysql.service - MySQL Community Server.
```

## 3. Acceso a MySQL

Intentamos acceder a MySQL:

```bash
isard@dhayan:~$ sudo mysql
```

## 4. Creación de la base de datos y tablas

### 4.1 Creación de la base de datos

Crear una base de datos con una tabla que almacenará la información de la aplicación.

Una vez dentro de MySQL, crearemos una base de datos que, en este caso, se llamará `laliga`:

```sql
mysql> CREATE DATABASE laliga;
```

Seguidamente, seleccionamos la base de datos para trabajar en ella:

```sql
mysql> USE laliga;
```

### 4.2 Creación de la tabla `equipos`

Una vez que podamos trabajar con ella, crearemos la tabla `equipos`, con los siguientes campos:
Número, ciudad/sede, estadio, año de fundación, presidente y presupuesto.

```sql
mysql> CREATE TABLE equipos (
    id_equipo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150),
    ciudad VARCHAR(100),
    estadio VARCHAR(100),
    fundacion_year YEAR NOT NULL,
    presidente VARCHAR(100),
    presupuesto DECIMAL(12,2)
);
```

Resultado:

```text
Query OK, 0 rows affected (0,12 sec)
```

Comprobamos que la tabla se ha creado correctamente:

```sql
mysql> SHOW TABLES;
```

```text
+------------------+
| Tables_in_laliga |
+------------------+
| equipos          |
+------------------+
1 row in set (0,00 sec)
```

### 4.3 Creación de la tabla `usuarios`

Crear una tabla para almacenar la información de autenticación (al menos el nombre de usuario y la contraseña):

```sql
mysql> CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255)
);
```

```text
Query OK, 0 rows affected (0,06 sec)
```

## 5. Creación de un usuario para la aplicación

Crear un usuario para acceder a la base de datos desde la aplicación.
Este usuario debe tener acceso completo a la base de datos creada en el punto anterior.

Creamos el usuario con:

```sql
mysql> CREATE USER 'dhayan_php'@'localhost' IDENTIFIED BY 'CHANGE_ME_DB_PASSWORD';
```

```text
Query OK, 0 rows affected (0,04 sec)
```

Le concedemos todos los permisos sobre la base de datos `laliga`:

```sql
mysql> GRANT ALL PRIVILEGES ON laliga.* TO 'dhayan_php'@'localhost';
```

```text
Query OK, 0 rows affected (0,05 sec)
```

Aplicamos los cambios:

```sql
mysql> FLUSH PRIVILEGES;
```

```text
Query OK, 0 rows affected (0,01 sec)
```

Salimos de MySQL:

```sql
mysql> EXIT;
```

## 6. Ejemplo de conexión a MySQL desde PHP

Ejemplo de cómo conectarse a una base de datos desde PHP.

Para conectarnos con la base de datos, debemos crear un archivo PHP que realice la conexión. El siguiente código es el que hemos empleado para ello.

### Archivo: `laliga.php`

```php
<?php

$mysqli = new mysqli("localhost", "dhayan_php", "CHANGE_ME_DB_PASSWORD", "laliga");

echo $mysqli->host_info . "\n";

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "<p>[Connected Successfully]</p>";
```

En este caso, usamos `mysqli` para conectar a la base de datos. El constructor recibe cuatro parámetros:

* Host: `localhost`
* Usuario: `dhayan_php`
* Contraseña: `CHANGE_ME_DB_PASSWORD`
* Base de datos: `laliga`

Al final, se muestra información sobre la conexión para confirmar que se ha realizado correctamente y, en caso de error, se muestra un mensaje y se detiene el script.

## 7. Ejecución de consultas que no devuelven datos

Ejemplo de cómo ejecutar consultas que no devuelven datos (INSERT).

El código que usaremos es el siguiente:

```php
<?php

$mysqli = new mysqli("localhost", "dhayan_php", "CHANGE_ME_DB_PASSWORD", "laliga");

echo $mysqli->host_info . "\n";

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "<p>[Connected Successfully]</p>";

$nombre = $_POST['nombre'];
$ciudad = $_POST['ciudad'];
$estadio = $_POST['estadio'];
$fundacion_year = $_POST['fundacion_year'];
$presidente = $_POST['presidente'];
$presupuesto = $_POST['presupuesto'];

$query = "INSERT INTO equipos (nombre, ciudad, estadio, fundacion_year, presidente, presupuesto)
          VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("sssisi", $nombre, $ciudad, $estadio, $fundacion_year, $presidente, $presupuesto);

$stmt->execute();

echo "Se ha ejecutado el INSERT";
```

En este caso, hacemos una consulta `INSERT INTO` para almacenar los datos en la tabla `equipos`.
Utilizamos `prepare()` y `bind_param()` para evitar vulnerabilidades de **SQL Injection** de manera básica y, finalmente, usamos `execute()` para ejecutar la consulta preparada.
