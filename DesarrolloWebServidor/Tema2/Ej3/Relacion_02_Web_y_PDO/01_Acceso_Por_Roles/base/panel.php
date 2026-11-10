<?php

declare(strict_types=1);
require_once __DIR__ . '/incidencias.php';
session_start();
// TODO: iniciar sesión, comprobar acceso y recuperar incidencias revisadas.
$nombre = htmlspecialchars((string) $_SESSION['nombre'], ENT_QUOTES, 'UTF-8');
$_SESSION['revisadas'] = [];

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Panel</title>
</head>

<body>
    <h1>Incidencias del centro</h1>
    <!-- TODO: saludo, estado de incidencias y botones POST para revisar. -->
    <h1>Bienvenida, <?= $nombre ?></h1>
    <p>Incidencia con id</p>
    <?php foreach ($incidencias as $id => $incidencia): ?>
        <p><?= htmlspecialchars($incidencia['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php if (!in_array($id, $_SESSION['revisadas'])): ?>
            <form action="revisar.php" method="post">
                <button type="submit">Revisar incidencia</button>
            </form>
        <?php endif; ?>
    <?php endforeach; ?>

    <form action="logout.php" method="post">
        <button type="submit">Cerrar sesión</button>
    </form>
</body>

</html>