<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/helpers.php';

function require_login(): void
{
    if (empty($_SESSION['usuario'])) {
        redirect('login.php');
    }
}

function current_user(): string
{
    return $_SESSION['usuario'] ?? '';
}
