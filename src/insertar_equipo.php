<?php
require __DIR__ . '/includes/auth.php';
require_login();

require __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('listado_equipos.php');
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    die('Token CSRF inválido.');
}

$nombre = trim($_POST['nombre'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');
$estadio = trim($_POST['estadio'] ?? '');
$fundacion_year = (int)($_POST['fundacion_year'] ?? 0);
$presidente = trim($_POST['presidente'] ?? '');
$presupuesto = (float)($_POST['presupuesto'] ?? 0);

$query = "INSERT INTO equipos (nombre, ciudad, estadio, fundacion_year, presidente, presupuesto)
          VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($query);

if (!$stmt) {
    die('Error preparando la consulta: ' . $mysqli->error);
}

$stmt->bind_param('sssisd', $nombre, $ciudad, $estadio, $fundacion_year, $presidente, $presupuesto);
$stmt->execute();

$stmt->close();
$mysqli->close();

redirect('listado_equipos.php');
