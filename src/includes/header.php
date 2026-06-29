<?php
$pageTitle = $pageTitle ?? 'LaLiga CRUD';
$bodyColor = $bodyColor ?? '#ffffff';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body style="background-color: <?= e($bodyColor) ?>;">
    <main class="container">
