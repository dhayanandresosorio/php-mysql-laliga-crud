<?php
require __DIR__ . '/includes/auth.php';
require_login();

require __DIR__ . '/includes/db.php';

$bodyColor = get_background_color();

$query = "SELECT id_equipo, nombre, ciudad, estadio, fundacion_year, presidente, presupuesto
          FROM equipos
          ORDER BY nombre";

$lista_liga = $mysqli->query($query);

if (!$lista_liga) {
    die('Error ejecutando la consulta: ' . $mysqli->error);
}

$pageTitle = 'Listado de equipos';
require __DIR__ . '/includes/header.php';
?>

<h1>LaLiga CRUD</h1>
<h2>Listado de equipos</h2>

<p>Usuario conectado: <strong><?= e(current_user()) ?></strong></p>

<nav class="nav">
    <a href="nuevo_equipo.php">Añadir equipo</a>
    <a href="preferencias.php">Cambiar color de fondo</a>
    <a href="logout.php">Cerrar sesión</a>
</nav>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Equipo</th>
            <th>Ciudad</th>
            <th>Estadio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $lista_liga->fetch_assoc()) { ?>
            <tr>
                <td><?= (int)$row['id_equipo'] ?></td>
                <td><?= e($row['nombre']) ?></td>
                <td><?= e($row['ciudad']) ?></td>
                <td><?= e($row['estadio']) ?></td>
                <td>
                    <a href="detalle_equipo.php?id_equipo=<?= (int)$row['id_equipo'] ?>">Ver</a>
                    <a href="editar_equipo.php?id_equipo=<?= (int)$row['id_equipo'] ?>">Editar</a>

                    <form action="borrar_equipo.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que quieres borrar este equipo?');">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                        <input type="hidden" name="id_equipo" value="<?= (int)$row['id_equipo'] ?>">
                        <input type="submit" value="Borrar">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$mysqli->close();
require __DIR__ . '/includes/footer.php';
?>
