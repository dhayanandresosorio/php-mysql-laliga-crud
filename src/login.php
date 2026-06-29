<?php
require __DIR__ . '/includes/auth.php';

if (!empty($_SESSION['usuario'])) {
    redirect('listado_equipos.php');
}

$pageTitle = 'Login LaLiga';
$bodyColor = '#f5f5f5';
require __DIR__ . '/includes/header.php';
?>

<h1>LaLiga CRUD</h1>
<h2>Iniciar sesión</h2>

<form action="comprobar_login.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

    <label>
        Usuario:
        <input type="text" name="usuario" required>
    </label>

    <label>
        Contraseña:
        <input type="password" name="password" required>
    </label>

    <input type="submit" value="Entrar">
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
