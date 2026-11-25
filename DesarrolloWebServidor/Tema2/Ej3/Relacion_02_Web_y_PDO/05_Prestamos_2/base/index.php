<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/EquipoRepositorio.php';

// Completa las acciones POST y recupera los equipos y préstamos.
$repo = new EquipoRepositorio(conectar());
$equipos = $repo->listarEquipos();
// Utiliza htmlspecialchars() para mostrar datos de la base de datos.
?>
<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Préstamos de equipos</title></head>
<body>
<h1>Préstamos de equipos</h1>
<!-- Completa las tablas y los formularios. -->

</body>
</html>
