<?php

declare(strict_types=1);
require_once __DIR__ . '/preguntas.php';
// TODO: iniciar sesión y tratar POST de inicio de cuestionario.
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Guardo alias
    $alias = trim((string) ($_POST['alias'] ?? ''));


    if (strlen($alias) < 2 || strlen($alias) > 30) {
        $error = "El alias esta mal";
    }

    //Guardo el indice de la pregunta que toca y los aciertos en la sesion
    if ($error === '') {
        $_SESSION['cuestionario'] = [
            'alias' => $alias,
            'indice' => 0,
            'aciertos' => 0,
        ];
        header('Location: index.php');
        exit();
    }
}
// TODO: mostrar inicio, pregunta actual o resultados según el estado.
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Cuestionario</title>
</head>

<body>
    <h1>Cuestionario por sesiones</h1>
    <!-- Alias -->
    <?php if ($error !== ''): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <?php if (!isset($_SESSION['cuestionario'])) : ?>
        <form action="index.php" method="post">
            <label>Alias
                <input name="alias" type="text" required>
            </label>
            <button type="submit">Comenzar</button>
        </form>
    <?php else: ?>
        <h2>Bienvenido, <?= $_SESSION['cuestionario']['alias'] ?></h2>
        <!-- Guardo el indice y la pregunta -->
        <?php
        $numeroIndice = $_SESSION['cuestionario']['indice'];
        $pregunta = $preguntas[$numeroIndice];
        ?>
        <p><?= htmlspecialchars($pregunta['texto'], ENT_QUOTES, 'UTF-8') ?></p>
        
    <?php endif; ?>


    <!-- TODO: formularios y vista adecuados al estado -->

</body>

</html>