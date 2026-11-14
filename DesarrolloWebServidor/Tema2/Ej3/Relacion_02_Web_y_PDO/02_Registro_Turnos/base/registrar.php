<?php

declare(strict_types=1);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}
require_once __DIR__ . '/sesion.php';
exigirSesion();
$tipo = $_POST['tipo'] ?? null;
if (!is_string($tipo) || !in_array($tipo, ['entrada', 'salida'], true)) {
    http_response_code(400);
    exit('Movimiento desconocido.');
}
$movimientos = $_SESSION['movimientos'] ?? [];
$ultimo = count($movimientos) ? $movimientos[array_key_last($movimientos)]['tipo'] : null;
if (($ultimo === null && $tipo !== 'entrada') || $ultimo === $tipo) {
    $_SESSION['error'] = 'Debes comenzar con una entrada y alternar entradas y salidas.';
} else {
    $_SESSION['movimientos'][] = ['tipo' => $tipo, 'fecha' => date('Y-m-d H:i:s')];
}
header('Location: panel.php');
exit;
