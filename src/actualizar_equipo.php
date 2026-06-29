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

$id_equipo = (int)($_POST['id_equipo'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');
$estadio = trim($_POST['estadio'] ?? '');
$fundacion_year = (int)($_POST['fundacion_year'] ?? 0);
$presidente = trim($_POST['presidente'] ?? '');
$presupuesto = (float)($_POST['presupuesto'] ?? 0);

$query = "UPDATE equipos
          SET nombre = ?, ciudad = ?, estadio = ?, fundacion_year = ?, presidente = ?, presupuesto = ?
          WHERE id_equipo = ?";

$stmt = $mysqli->prepare($query);

if (!$stmt) {
    die('Error preparando la consulta: ' . $mysqli->error);
}

$stmt->bind_param('sssisdi', $nombre, $ciudad, $estadio, $fundacion_year, $presidente, $presupuesto, $id_equipo);
$stmt->execute();

$stmt->close();
$mysqli->close();

redirect('listado_equipos.php');
