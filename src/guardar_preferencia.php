<?php
require __DIR__ . '/includes/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('listado_equipos.php');
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    die('Token CSRF inválido.');
}

$allowedColors = [
    '#ffffff',
    '#f0f8ff',
    '#f5f5dc',
    '#e6ffe6',
    '#fff0f5',
];

$color_fondo = $_POST['color_fondo'] ?? '#ffffff';

if (!in_array($color_fondo, $allowedColors, true)) {
    $color_fondo = '#ffffff';
}

setcookie('color_fondo', $color_fondo, time() + (30 * 24 * 60 * 60), '/');

redirect('listado_equipos.php');
