<?php
require_once __DIR__ . '/componentes.php'; // Datos iniciales de opciones, precios y descuentos.

// EJERCICIO 06.
// TODO 1: comprueba el método POST y valida las cinco opciones obligatorias.

// TODO 3: calcula el precio unitario SIN IVA a partir de los precios proporcionados.
// TODO 4: multiplica por el número de vehículos y aplica el descuento, si es válido.
// TODO 5: calcula un IVA del 21 % sobre la base una vez descontada la rebaja.
// TODO 6: genera un resumen con opciones, importes, descuentos, IVA y total.
// Si el código de descuento no existe, indica que es inválido y no apliques rebaja.

function mostrar($texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

echo 'Pendiente de implementar el ejercicio 06.';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $modelo = $_POST['Modelo'] ?? '';
    $motor = $_POST['Motor'] ?? '';
    $color = $_POST['Color'] ?? '';
    $llantas = $_POST['Llantas'] ?? '';
    $equipamiento = $_POST['Equipamiento'] ?? '';

    $accesorios = $_POST['Accesorios'] ?? [];
    $cantidad = $_POST['cantidad'] ?? '';

    $seleccion = [];
    echo '<br>';

    /**
     * Si el valor es texto  y si existe como clave dentro del array $componentes
     */
    if (is_string($modelo) && array_key_exists($modelo, $componentes['Modelo'])) {
        echo ("Todo correcto");
        $precioModelo = $componentes['Modelo'][$modelo];
    } else {
        echo ("Selecciona un modelo");
    }

    echo '<br>';

    if (is_string($motor) && array_key_exists($motor, $componentes['Motor'])) {
        echo ("Todo correcto");
        $precioMotor = $componentes['Motor'][$motor];
    } else {
        echo ("Selecciona un motor");
    }

    echo '<br>';

    if (is_string($color) && array_key_exists($color, $componentes['Color'])) {
        echo ("Todo correcto");
        $precioColor = $componentes['Color'][$color];
    } else {
        echo ("Selecciona un color");
    }

    echo '<br>';

    if (is_string($llantas) && array_key_exists($llantas, $componentes['Llantas'])) {
        echo ("Todo correcto");
        $precioLlantas = $componentes['Llantas'][$llantas];
    } else {
        echo ("Selecciona una llanta");
    }
    echo '<br>';

    if (is_string($equipamiento) && array_key_exists($equipamiento, $componentes['Equipamiento'])) {
        echo ("Todo correcto");
        $precioEquipamiento = $componentes['Equipamiento'][$equipamiento];
    } else {
        echo ("Selecciona un equipamiento");
    }

    echo '<br>';

    // TODO 2: recoge los accesorios seleccionados (pueden ser cero) y la cantidad (1–5).

    // Si no es un array y el numero de accesorios es menor que 0 da error
    if (!is_array($accesorios)) {
        exit('Debe seleccionar algo');
    }

    //Si la cantidad es menor o mayor a 5 da error
    if ($cantidad < 1 || $cantidad > 5) {
        exit('Selecciona una cantidad valida');
    }

    /**
     * Por cada accesorio seleccionado comprueba si no es un string o si no existe en el array de Accesorios #componentes.php
     */
    foreach ($accesorios as $accesorio) {

        if (!is_string($accesorio) || !array_key_exists($accesorio, $componentes['Accesorios'])) {
            exit('Se ha enviado un accesorio no valido.');
        }
    }

    //Mostrar todos los productos con su precio

    echo '<!doctype html><html lang="es"><meta charset="utf-8"><title>Tu coche</title><body>';
    echo '<h1>Resumen de tu coche personalizado</h1><ul>';
    //Coger la pieza y buscar en el array la pieza que coincida y sacar su precio

    echo '<li>' . mostrar('Modelo') . ': ' . mostrar($modelo) . ' — ' . $precioModelo . ' €</li>';
    echo '<li>' . mostrar('Motor') . ': ' . mostrar($motor) . ' — ' . $precioMotor . ' €</li>';
    echo '<li>' . mostrar('Color') . ': ' . mostrar($color) . ' — ' . $precioColor . ' €</li>';
    echo '<li>' . mostrar('Llantas') . ': ' . mostrar($llantas) . ' — ' . $precioLlantas . ' €</li>';
    echo '<li>' . mostrar('Equipamiento') . ': ' . mostrar($equipamiento) . ' — ' . $precioEquipamiento . ' €</li>';
    echo '<li>' . mostrar('Equipamiento') . ': ' . mostrar($modelo) . ' — ' . $precioModelo . ' €</li>';
}
