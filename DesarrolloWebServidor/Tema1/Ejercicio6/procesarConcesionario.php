<?php
require_once __DIR__ . '/componentes.php'; // Datos iniciales de opciones, precios y descuentos.

// EJERCICIO 06.
// TODO 1: comprueba el método POST y valida las cinco opciones obligatorias.

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

    $accesorios = $_POST['Accesorios'] ?? [];
    $cantidad = $_POST['cantidad'] ?? '';

    echo '<br>';

    /**
     * Si el valor es texto  y si existe como clave dentro del array $componentes
     */
    if (is_string($modelo) && array_key_exists($modelo, $componentes['Modelo'])) {
        echo ("Todo correcto");
    } else {
        echo ("Selecciona un modelo");
    }

    echo '<br>';

    if (is_string($motor) && array_key_exists($motor, $componentes['Motor'])) {
        echo ("Todo correcto");
    } else {
        echo ("Selecciona un motor");
    }

    echo '<br>';

    if (is_string($color) && array_key_exists($color, $componentes['Color'])) {
        echo ("Todo correcto");
    } else {
        echo ("Selecciona un color");
    }

    echo '<br>';

    if (is_string($llantas) && array_key_exists($llantas, $componentes['Llantas'])) {
        echo ("Todo correcto");
    } else {
        echo ("Selecciona una llanta");
    }
    echo '<br>';

    if (is_string($equipamiento) && array_key_exists($equipamiento, $componentes['Equipamiento'])) {
        echo ("Todo correcto");
    } else {
        echo ("Selecciona un equipamiento");
    }

    $motorValido        = is_string($motor) && array_key_exists($motor, $componentes['Motor']);
    $colorValido        = is_string($color) && array_key_exists($color, $componentes['Color']);
    $llantasValidas     = is_string($llantas) && array_key_exists($llantas, $componentes['Llantas']);
    $equipamientoValido = is_string($equipamiento) && array_key_exists($equipamiento, $componentes['Equipamiento']);

    echo '<br>';
    
    // TODO 2: recoge los accesorios seleccionados (pueden ser cero) y la cantidad (1–5).
    
    // Si no es un array y el numero de accesorios es menor que 0 da error
    if (!is_array($accesorios) ) {
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
}
