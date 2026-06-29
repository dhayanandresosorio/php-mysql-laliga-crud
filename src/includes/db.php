<?php

$configFile = __DIR__ . '/../config.php';

if (!file_exists($configFile)) {
    $configFile = __DIR__ . '/../config.example.php';
}

$config = require $configFile;

$mysqli = new mysqli(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);

if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');
