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

$pageTitle = 'Detalle del equipo';
$bodyColor = get_background_color();
require __DIR__ . '/includes/header.php';
?>

<h1>LaLiga CRUD</h1>
<h2>Detalle del equipo</h2>

<?php if (!$equipo) { ?>
    <p>No existe ese equipo.</p>
<?php } else { ?>
    <ul>
        <li><strong>ID:</strong> <?= (int)$equipo['id_equipo'] ?></li>
        <li><strong>Nombre:</strong> <?= e($equipo['nombre']) ?></li>
        <li><strong>Ciudad:</strong> <?= e($equipo['ciudad']) ?></li>
        <li><strong>Estadio:</strong> <?= e($equipo['estadio']) ?></li>
        <li><strong>Fundación:</strong> <?= e($equipo['fundacion_year']) ?></li>
        <li><strong>Presidente:</strong> <?= e($equipo['presidente']) ?></li>
        <li><strong>Presupuesto:</strong> <?= e($equipo['presupuesto']) ?></li>
    </ul>
<?php } ?>

<p><a href="listado_equipos.php">Volver al listado</a></p>

<?php
$stmt->close();
$mysqli->close();
require __DIR__ . '/includes/footer.php';
?>
