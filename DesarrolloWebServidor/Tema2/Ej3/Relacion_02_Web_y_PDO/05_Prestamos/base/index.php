<?php

declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/EquipoRepositorio.php';
// TODO: inicializar PDO y repositorio, validar POST y ejecutar acciones.

function h(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}
function listarPrestamoPorEquipo(int $idEquipo): array {
        $sql = "SELECT equipo.nombre as prestamo.id FROM equipo INNER JOIN prestamo ON equipo.id = prestamo.equipo_id";
        $sentencia = $this->pdo->prepare($sql);
        $sentencia->execute([$unidades, $id]);
    }

$error = '';
$equipos = [];
try {
    $repo = new EquipoRepositorio(conectar());
    $equipos = $repo->listarEquipos();

    
} catch (InvalidArgumentException $errorValidacion) {
    http_response_code(400);
    $error = $errorValidacion->getMessage();
} catch (PDOException $errorBD) {
    http_response_code(500);
    $error = 'No se pudo completar la operación. Revisa la conexión o los datos duplicados.';
}

// TODO: recuperar listas, gestionar errores y escapar datos mostrados.
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Ejercicio PDO</title>
</head>

<body>
    <h1>Ejercicio PDO</h1>
    <h2>Listado equipos</h2>
    <ul>
        <?php foreach ($equipos as $equipo): ?>
            <li>
                <?= $equipo['id'] ?>
                <?= h($equipo['nombre']) ?>
                <?= $equipo['unidades'] ?>

                <? $unidadesEquipos = $equipo['id']['unidades']?>
                <?= $sql = "SELECT equipo.nombre as prestamo.id FROM equipo INNER JOIN prestamo ON equipo.id = prestamo.equipo_id"?>
                <?=  $sql ?>?>
            </li>
        <?php endforeach; ?>
    </ul>
    <!-- TODO: formularios y tablas del enunciado. -->
</body>

</html>