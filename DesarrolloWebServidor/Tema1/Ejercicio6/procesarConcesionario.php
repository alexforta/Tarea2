<?php
require_once __DIR__ . '/componentes.php'; // Datos iniciales de opciones, precios y descuentos.

// EJERCICIO 06.
// TODO 1: comprueba el método POST y valida las cinco opciones obligatorias.
// TODO 2: recoge los accesorios seleccionados (pueden ser cero) y la cantidad (1–5).
// TODO 3: calcula el precio unitario SIN IVA a partir de los precios proporcionados.
// TODO 4: multiplica por el número de vehículos y aplica el descuento, si es válido.
// TODO 5: calcula un IVA del 21 % sobre la base una vez descontada la rebaja.
// TODO 6: genera un resumen con opciones, importes, descuentos, IVA y total.
// Si el código de descuento no existe, indica que es inválido y no apliques rebaja.

echo 'Pendiente de implementar el ejercicio 06.';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelo = $_POST['Modelo'] ?? '';
    $motor = $_POST['Motor'] ?? '';
    $color = $_POST['Color'] ?? '';
    $llantas = $_POST['Llantas'] ?? '';
    $equipamiento = $_POST['Equipamiento'] ?? '';

/**
 * Si el valor es texto  y si existe como clave dentro del array $componentes
 */
if (is_string($modelo) && array_key_exists($modelo, $componentes['Modelo'])) {
    echo("Todo correcto");
} else {
    echo("Selecciona algo");
}

$motorValido        = is_string($motor) && array_key_exists($motor, $componentes['Motor']);
$colorValido        = is_string($color) && array_key_exists($color, $componentes['Color']);
$llantasValidas     = is_string($llantas) && array_key_exists($llantas, $componentes['Llantas']);
$equipamientoValido = is_string($equipamiento) && array_key_exists($equipamiento, $componentes['Equipamiento']);
}