<?php
require __DIR__ . '/includes/auth.php';
require_login();

$pageTitle = 'Añadir equipo';
$bodyColor = get_background_color();
require __DIR__ . '/includes/header.php';
?>

<h1>LaLiga CRUD</h1>
<h2>Añadir equipo</h2>

<form action="insertar_equipo.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

    <label>Nombre:
        <input type="text" name="nombre" required>
    </label>

    <label>Ciudad:
        <input type="text" name="ciudad" required>
    </label>

    <label>Estadio:
        <input type="text" name="estadio" required>
    </label>

    <label>Fundación:
        <input type="number" name="fundacion_year" required>
    </label>

    <label>Presidente:
        <input type="text" name="presidente">
    </label>

    <label>Presupuesto:
        <input type="number" step="0.01" name="presupuesto">
    </label>

    <input type="submit" value="Guardar equipo">
</form>

<p><a href="listado_equipos.php">Volver al listado</a></p>

<?php require __DIR__ . '/includes/footer.php'; ?>
