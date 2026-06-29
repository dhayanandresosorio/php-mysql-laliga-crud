<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('login.php');
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    die('Token CSRF inválido.');
}

$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';

$query = "SELECT usuario, password_hash FROM usuarios WHERE usuario = ?";
$stmt = $mysqli->prepare($query);

if (!$stmt) {
    die('Error preparando la consulta: ' . $mysqli->error);
}

$stmt->bind_param('s', $usuario);
$stmt->execute();

$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();

if ($fila && password_verify($password, $fila['password_hash'])) {
    session_regenerate_id(true);
    $_SESSION['usuario'] = $fila['usuario'];
    redirect('listado_equipos.php');
}

redirect('login.php');
