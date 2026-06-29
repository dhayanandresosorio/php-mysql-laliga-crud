<?php
// Uso desde terminal:
// php src/crear_usuario.php usuario contraseña

require __DIR__ . '/includes/db.php';

if (PHP_SAPI !== 'cli') {
    echo "Este script debe ejecutarse desde terminal." . PHP_EOL;
    exit(1);
}

if ($argc < 3) {
    echo "Uso: php src/crear_usuario.php usuario contraseña" . PHP_EOL;
    exit(1);
}

$usuario = $argv[1];
$password = $argv[2];

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO usuarios (usuario, password_hash) VALUES (?, ?)";
$stmt = $mysqli->prepare($query);

if (!$stmt) {
    die('Error preparando la consulta: ' . $mysqli->error . PHP_EOL);
}

$stmt->bind_param('ss', $usuario, $passwordHash);
$stmt->execute();

echo "Usuario creado correctamente." . PHP_EOL;

$stmt->close();
$mysqli->close();
