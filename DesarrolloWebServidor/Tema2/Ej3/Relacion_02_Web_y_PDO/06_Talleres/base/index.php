<?php

declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/TallerRepositorio.php';
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
$talleres = [];
$repo = new TallerRepositorio(conectar());
$talleres = $repo->listarTalleres();

// Completa las acciones POST y recupera talleres e inscripciones.
// Utiliza htmlspecialchars() para mostrar datos de la base de datos.
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Talleres</title>
</head>

<body>
    <h1>Talleres</h1>
    <!-- Completa las tablas y los formularios. -->
    <h2>Talleres</h2>
    <table border="1">
        <tr>
            <th>Titulo</th>
            <th>Plazas</th>
            <th>Inscripciones</th>
        </tr>
        <?php foreach ($talleres as $taller): ?>
            <tr>
                <td><?= e($taller['titulo']) ?></td>
                <td><?= $taller['plazas'] ?></td>
                <td><?= $taller['inscripciones'] ?></td>
                <td><?= $taller['confirmadas'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>