<?php
require_once __DIR__ . '/datosRobo.php';

// TODO: Recibir los datos del formulario inicial.
// TODO: Validarlos y obtener una selección aleatoria de pistas sin repetir.
// TODO: Preparar las variables necesarias para el HTML.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim((string) ($_POST['nombre'] ?? ''));
    $barrio = $_POST['barrio'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $antiguedad = filter_var($_POST['antiguedad'] ?? null, FILTER_VALIDATE_FLOAT);;
    $cantidad = filter_var($_POST['cantidad'] ?? null, FILTER_VALIDATE_FLOAT);;


    if ($barrio === '' || !is_string($barrio)) {
        exit("Introduce un bgarrio");
    }
    if ($modelo === '' || !is_string($modelo)) {
        exit("Introduce un modelo");
    }

    $pistasMostradas = (array) array_rand($pistas, $cantidad);
    
}
?>
<!-- // array_rand devuelve claves distintas del catálogo.
$pistasMostradas = array_rand($pistas, $cantidad);
?> -->
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Operación Cortacandados - Expediente</title>
</head>
<body>
    <h1>Expediente de robo</h1>
    <p>Nombre: <?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></p>
    <p>Barrio: <?= htmlspecialchars($barrios[$barrio], ENT_QUOTES, 'UTF-8') ?></p>
    <p>Modelo: <?= htmlspecialchars($modelos[$modelo]['nombre'], ENT_QUOTES, 'UTF-8') ?></p>
    <p>Antigüedad: <?= $antiguedad ?> años</p>
    <p>Número de pistas a revisar: <?= $cantidad ?></p>
    <form action="analizarExpediente.php" method="post">
        <input type="hidden" name="nombre" value="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="barrio" value="<?= htmlspecialchars($barrio, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="modelo" value="<?= htmlspecialchars($modelo, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="antiguedad" value="<?= $antiguedad ?>">

        <?php foreach ($pistasMostradas as $clave): ?>
            <fieldset>
                <legend><?= htmlspecialchars($clave, ENT_QUOTES, 'UTF-8') ?></legend>
                <p><?= htmlspecialchars($pistas[$clave]['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
                <!-- El campo oculto conserva la pista aunque no se marque ningún radio. -->
                <input type="hidden" name="pistasMostradas[]" value="<?= htmlspecialchars($clave, ENT_QUOTES, 'UTF-8') ?>">
                <label><input type="radio" name="decisiones[<?= htmlspecialchars($clave, ENT_QUOTES, 'UTF-8') ?>]" value="investigar"> Investigar</label>
                <label><input type="radio" name="decisiones[<?= htmlspecialchars($clave, ENT_QUOTES, 'UTF-8') ?>]" value="descartar"> Descartar</label>
            </fieldset>
        <?php endforeach; ?>

        <p><button type="submit">Analizar expediente</button></p>
    </form>
</body>
</html>
