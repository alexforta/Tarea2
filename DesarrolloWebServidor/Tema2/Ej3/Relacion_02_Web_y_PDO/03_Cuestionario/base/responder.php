<?php
declare(strict_types=1);
require_once __DIR__ . '/preguntas.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); exit;
}
// TODO: validar sesión y opción, registrar un solo acierto y avanzar.

//Comprobacion que haya una partida guardada
if (!isset($_SESSION['cuestionario'])) {
    header('Location: index.php');
    exit;
}

$indice = $_SESSION['cuestionario']['indice'];

//Compruebo que siga una pregunta en curso
if ($indice >= count($preguntas)) {
    header('Location: index.php');
    exit;
}

$opcion = filter_var($_POST['respuesta'] ?? '', FILTER_VALIDATE_INT);
$error = '';
/**
 * Comprueba que hayas seleccionado una opcion
 */
if ($opcion === false) {
    $error = 'No has seleccionado ninguna respuesta';
    header('Location: index.php');
    exit;
}else {
    //Añade una posicion al indice y comprueba que la opcion sea la correcta
    $_SESSION['cuestionario']['indice']++;
    if ($opcion === $preguntas[$indice]['correcta']) {
        $_SESSION['cuestionario']['aciertos']++;
    }
    header('Location: index.php');
    exit;
}

// TODO: redirigir a index.php sin generar HTML.
