<?php

declare(strict_types=1);
require_once __DIR__ . '/rutas.php';

function h(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

// TODO: leer y normalizar la lista JSON de la cookie.
//Leo el valor de la cookie
$cookieFavoritos = $_COOKIE['rutas_favoritas'] ?? [];
$favoritos = [];
// TODO: calcular el total con kilómetros del catálogo.
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Rutas favoritas</title>
</head>

<body>
    <h1>Rutas favoritas</h1>
    <!-- TODO: catálogo con formularios POST para añadir/quitar -->
    <?php foreach ($rutas as $indice => $ruta): ?>
        <p><?= h($ruta['nombre']) ?></p>
        <?php if (in_array($indice, $favoritos, true)): ?>
            <form action="accion.php" method="post" style="display:inline">
                <input type="hidden" name="accion" value="quitar">
                <input type="hidden" name="id" value="<?= $indice ?>">
                <button type="submit">Quitar</button>
            </form>
        <?php else: ?>
            <form action="accion.php" method="post" style="display:inline">
                <input type="hidden" name="accion" value="anadir">
                <input type="hidden" name="id" value="<?= $indice ?>">
                <button type="submit">Añadir</button>
            </form>
            <!-- Aquí va la vista de la partida -->
        <?php endif; ?>

    <?php endforeach; ?>
    <!-- TODO: favoritas, total, aviso de límite y formulario de vaciado -->
</body>

</html>