<?php
require __DIR__ . '/includes/auth.php';
require_login();

$pageTitle = 'Preferencias';
$bodyColor = get_background_color();
require __DIR__ . '/includes/header.php';
?>

<h1>LaLiga CRUD</h1>
<h2>Elegir color de fondo</h2>

<form action="guardar_preferencia.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

    <label>
        Color de fondo:
        <select name="color_fondo">
            <option value="#ffffff">Blanco</option>
            <option value="#f0f8ff">Azul claro</option>
            <option value="#f5f5dc">Beige</option>
            <option value="#e6ffe6">Verde claro</option>
            <option value="#fff0f5">Rosa claro</option>
        </select>
    </label>

    <input type="submit" value="Guardar preferencia">
</form>

<p><a href="listado_equipos.php">Volver al listado</a></p>

<?php require __DIR__ . '/includes/footer.php'; ?>
