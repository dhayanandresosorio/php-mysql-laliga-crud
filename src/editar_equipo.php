<?php
require __DIR__ . '/includes/auth.php';
require_login();

require __DIR__ . '/includes/db.php';

$id_equipo = (int)($_GET['id_equipo'] ?? 0);

$query = "SELECT id_equipo, nombre, ciudad, estadio, fundacion_year, presidente, presupuesto
          FROM equipos
          WHERE id_equipo = ?";

$stmt = $mysqli->prepare($query);

if (!$stmt) {
    die('Error preparando la consulta: ' . $mysqli->error);
}

$stmt->bind_param('i', $id_equipo);
$stmt->execute();

$resultado = $stmt->get_result();
$equipo = $resultado->fetch_assoc();

if (!$equipo) {
    die('No existe ese equipo.');
}

$pageTitle = 'Editar equipo';
$bodyColor = get_background_color();
require __DIR__ . '/includes/header.php';
?>

<h1>LaLiga CRUD</h1>
<h2>Editar equipo</h2>

<form action="actualizar_equipo.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="id_equipo" value="<?= (int)$equipo['id_equipo'] ?>">

    <label>Nombre:
        <input type="text" name="nombre" value="<?= e($equipo['nombre']) ?>" required>
    </label>

    <label>Ciudad:
        <input type="text" name="ciudad" value="<?= e($equipo['ciudad']) ?>" required>
    </label>

    <label>Estadio:
        <input type="text" name="estadio" value="<?= e($equipo['estadio']) ?>" required>
    </label>

    <label>Fundación:
        <input type="number" name="fundacion_year" value="<?= e($equipo['fundacion_year']) ?>" required>
    </label>

    <label>Presidente:
        <input type="text" name="presidente" value="<?= e($equipo['presidente']) ?>">
    </label>

    <label>Presupuesto:
        <input type="number" step="0.01" name="presupuesto" value="<?= e($equipo['presupuesto']) ?>">
    </label>

    <input type="submit" value="Guardar cambios">
</form>

<p><a href="listado_equipos.php">Volver al listado</a></p>

<?php
$stmt->close();
$mysqli->close();
require __DIR__ . '/includes/footer.php';
?>
