<?php
declare(strict_types=1);
require_once __DIR__ . '/incidencias.php';
session_start();
// TODO: permitir solamente POST; comprobar autenticación.
// TODO: validar el ID frente al catálogo y marcarlo una sola vez.
// TODO: redirigir al panel.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idIncidencia = (int) ($_POST['id'] ?? '');
    if (isset($incidencias[$idIncidencia])) {
        var_dump($idIncidencia);
        $_SESSION['revisadas'][] = $idIncidencia;
        header('Location: panel.php');
    }
}
