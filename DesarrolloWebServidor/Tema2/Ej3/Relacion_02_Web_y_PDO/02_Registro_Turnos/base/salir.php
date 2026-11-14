<?php

declare(strict_types=1);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}
require_once __DIR__ . '/sesion.php';
cerrarSesion();
header('Location: acceso.php');
exit;
