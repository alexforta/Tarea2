<?php

declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/TallerRepositorio.php';
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
$talleres = [];
$inscripciones = [];
$repo = new TallerRepositorio(conectar());

$accion = $_POST['accion'] ?? '';

if ($accion === 'inscribir') {
    $id = filter_var($_POST['taller_id'] ?? null, FILTER_VALIDATE_INT);
    $nombre = $_POST['nombre'] ?? null;
    $email = $_POST['email'] ?? null;
    $repo->inscribir($id, $nombre, $email);
}elseif ($accion === 'cancelar') {
    $id = filter_var($_POST['inscripcion_id'] ?? null, FILTER_VALIDATE_INT);
    $repo->cancelar($id);
}
$talleres = $repo->listarTalleres();
$inscripciones = $repo->listarInscripciones();

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
            <th>Inscripciones Confirmadas</th>
            <th>Inscripciones Espera</th>
        </tr>
        <?php foreach ($talleres as $taller): ?>
            <tr>
                <td><?= e($taller['titulo']) ?></td>
                <td><?= $taller['plazas'] ?></td>
                <td><?= $taller['confirmadas'] ?></td>
                <td><?= $taller['cerradas'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Inscripciones</h2>
    <table border="1">
        <tr>
            <th>Taller</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Accion</th>
        </tr>
        <?php foreach ($inscripciones as $inscripcion): ?>
            <tr>
                <td><?= e($inscripcion['taller']) ?></td>
                <td><?= e($inscripcion['nombre']) ?></td>
                <td><?= e($inscripcion['email']) ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="accion" value="cancelar">
                        <button type="submit" name="inscripcion_id" value="<?= (int) $inscripcion['id'] ?>">cancelar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Inscribir</h2>
    <form method="post">
        <!-- Accion -->
        <input type="hidden" name="accion" value="inscribir">
        <label>Taller
            <select name="taller_id" required>
                <!-- Desplegable de para seleccionar un taller que quieres inscribir -->
                <?php foreach ($talleres as $taller): ?>
                    <option value="<?= (int) $taller['id'] ?>">
                        <?= e($taller['titulo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <!-- Introducir datos adicionales para la inscripcion -->
        <label>Nombre <input name="nombre" minlength="2" maxlength="80" required></label>
        <label>Email <input type="email" name="email" minlength="2" maxlength="80" required></label>
        <button type="submit">Incribir</button>
    </form>
</body>

</html>