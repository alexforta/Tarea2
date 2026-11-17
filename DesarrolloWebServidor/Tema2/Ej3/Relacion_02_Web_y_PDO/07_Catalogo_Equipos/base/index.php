<?php

declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/EquipoRepositorio.php';

function h(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

$error = '';
$equipos = [];
try {
    $repo = new EquipoRepositorio(conectar());
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Comprueba la accion pulsada en el formulario
        $accion = (string) ($_POST['accion'] ?? '');
        //Compueba que el numero enviado en el formulario sea mayor o igual a 1

        /**
         * Comprueba lo que llega de la variable accion y ejecuta segun lo que se le ha pedido su funcion
         */
        if ($accion === 'crear') {
            $repo->crear(
                (string) ($_POST['nombre'] ?? ''),
                (int) ($_POST['unidades'] ?? '')
            );
        }
        header('Location: index.php');
        exit;
    }

    $equipos = $repo->listar();
} catch (InvalidArgumentException $errorValidacion) {
    http_response_code(400);
    $error = $errorValidacion->getMessage();
} catch (PDOException $errorBD) {
    http_response_code(500);
    $error = 'No se pudo completar la operación. Revisa la conexión o los datos duplicados.';
}

// Completa las acciones POST y recupera el listado.
// Utiliza htmlspecialchars() para mostrar datos de la base de datos.
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Catálogo de equipos</title>
</head>

<body>
    <h1>Catálogo de equipos</h1>
    <?php if ($error !== ''): ?>
        <p><?= h($error) ?></p>
    <?php endif; ?>

    <h2>Crear usuario</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="accion" value="crear">
        <input name="nombre" placeholder="Nombre" required>
        <input type="number" name="unidades" placeholder="Unidades" required>
        <button type="submit">Crear</button>
    </form>
    <h2>Listado</h2>
    <ul>
        <?php foreach ($equipos as $equipo): ?>
            <li>
                <?= h($equipo['nombre']) ?>
                <?= $equipo['unidades'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>