<?php
require_once __DIR__ . '/catalogo.php';
require_once __DIR__ . '/funciones.php';

// TODO 1: aceptar solo POST y validar partido, pack, transporte, unidades (1..8).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $partido = $_POST['partido'] ?? '';
    $pack = $_POST['pack'] ?? '';
    $transporte = $_POST['transporte'] ?? '';
    $unidades = $_POST['unidades'] ?? '';
    // TODO 2: recuperar extras[] (puede no existir), validar sus valores y eliminar duplicados.
    $extra = $_POST['extras'] ?? [];
    $codigo = $_POST['codigo'] ?? '';
    
    // TODO 3: calcular precio unitario = pack + suma de extras.
    $precioUnitario = 0;
    //Sacar es precio del pack
    $precioPack = $packs[$pack]['precio'];
    $precioExtras = 0;
    //Sacar el precio por cada extra
    foreach ($extra as $nombreExtra) {
        $precioExtras += $extras[$nombreExtra]['precio'];
    }
    $precioUnitario += $precioPack + $precioExtras;
    
    // TODO 4: mercancía = precio unitario * unidades; aplicar código si es válido.
    //          Un código inválido NO da descuento; el transporte NO se descuenta.
    $mercancia = $precioUnitario * $unidades;
    //Calcular descuento
    $descuentoPorcentaje = $codigos[$codigo] ?? 0;
    $rebaja = round($mercancia * $descuentoPorcentaje / 100, 2);
    $precioConDescuento = $mercancia - $rebaja;
    // TODO 5: calcular base con transporte, IVA 21 % y total final.
    $precioTransporte = $transportes[$transporte] ?? 0;
    $iva = round($precioConDescuento * .21, 2);

    //Calculo final
    $precioFinal = $precioConDescuento + $precioTransporte + $iva;
    echo euros($precioFinal);

    // TODO 6: indicar si total final supera 500 €, y preparar desglose en la vista.
    if ($precioFinal >= 500) {
        echo "Son mas de 500€";
    }

    require __DIR__ . '/vistas/ticket.php';
}
