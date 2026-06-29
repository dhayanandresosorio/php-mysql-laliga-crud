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

$query = "DELETE FROM equipos WHERE id_equipo = ?";
$stmt = $mysqli->prepare($query);

if (!$stmt) {
    die('Error preparando la consulta: ' . $mysqli->error);
}

$stmt->bind_param('i', $id_equipo);
$stmt->execute();

$stmt->close();
$mysqli->close();

redirect('listado_equipos.php');
