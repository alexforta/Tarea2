<?php
require_once __DIR__ . '/catalogo.php';
require_once __DIR__ . '/funciones.php';

// TODO 1: aceptar solo POST y validar partido, pack, transporte, unidades (1..8).
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Este script solo acepta peticiones mediante el método POST.');
}

$partido     = $_POST['partido'] ?? '';
$pack        = $_POST['pack'] ?? '';
$transporte  = $_POST['transporte'] ?? '';
$unidadesRaw = $_POST['unidades'] ?? '';

if (!in_array($partido, $partidos, true)) {
    exit('El partido seleccionado no es válido.');
}

if (!array_key_exists($pack, $packs)) {
    exit('El pack seleccionado no es válido.');
}

if (!array_key_exists($transporte, $transportes)) {
    exit('El tipo de transporte seleccionado no es válido.');
}

$unidades = filter_var($unidadesRaw, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1, 'max_range' => 8]
]);

if ($unidades === false) {
    exit('Las unidades deben ser un número entero entre 1 y 8.');
}

// TODO 2: recuperar extras[] (puede no existir), validar sus valores y eliminar duplicados.
$extrasRecibidos = $_POST['extras'] ?? [];

if (!is_array($extrasRecibidos)) {
    $extrasRecibidos = [];
}

// Eliminar posibles valores duplicados
$extrasSeleccionados = array_unique($extrasRecibidos);

// Validar que todos los extras elegidos existan en el catálogo
foreach ($extrasSeleccionados as $nombreExtra) {
    if (!array_key_exists($nombreExtra, $extras)) {
        exit('Se ha seleccionado un extra no válido.');
    }
}

$codigo = trim($_POST['codigo'] ?? '');

// TODO 3: calcular precio unitario = pack + suma de extras.
$precioPack = $packs[$pack]['precio'];
$precioExtrasTotal = 0;

foreach ($extrasSeleccionados as $nombreExtra) {
    $precioExtrasTotal += $extras[$nombreExtra]['precio'];
}

$precioUnitario = $precioPack + $precioExtrasTotal;

// TODO 4: mercancía = precio unitario * unidades; aplicar código si es válido.
//          Un código inválido NO da descuento; el transporte NO se descuenta.
$mercancia = $precioUnitario * $unidades;

// Verificar si el código ingresado existe en la lista de códigos válidos
$porcentajeDescuento = $codigos[$codigo] ?? $codigos['SIN_CODIGO'];
$descuentoEuros = round($mercancia * ($porcentajeDescuento / 100), 2);
$subtotalMercancia = $mercancia - $descuentoEuros;

// TODO 5: calcular base con transporte, IVA 21 % y total final.
$costeTransporte = $transportes[$transporte];
$baseImponible = $subtotalMercancia + $costeTransporte;
$cuotaIva = round($baseImponible * ($ivaPorcentaje / 100), 2);
$totalFinal = $baseImponible + $cuotaIva;

// TODO 6: indicar si total final supera 500 €, y preparar desglose en la vista.
$superaPresupuesto = ($totalFinal > $presupuestoMaximo);

// Cargar la vista encargada de mostrar el ticket HTML
require __DIR__ . '/vistas/ticket.php';