<?php

function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf_token(string $token): bool
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function get_background_color(): string
{
    $allowedColors = [
        '#ffffff',
        '#f0f8ff',
        '#f5f5dc',
        '#e6ffe6',
        '#fff0f5',
    ];

    $color = $_COOKIE['color_fondo'] ?? '#ffffff';

    return in_array($color, $allowedColors, true) ? $color : '#ffffff';
}
