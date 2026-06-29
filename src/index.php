<?php
require __DIR__ . '/includes/auth.php';

if (!empty($_SESSION['usuario'])) {
    redirect('listado_equipos.php');
}

redirect('login.php');
