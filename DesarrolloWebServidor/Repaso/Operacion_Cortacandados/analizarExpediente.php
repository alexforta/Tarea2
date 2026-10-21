<?php
require_once __DIR__ . '/datosRobo.php';

// TODO: Recuperar los datos y las claves de las pistas mostradas.
// TODO: Analizar cada decisión y compararla con el catálogo.
// TODO: Calcular el valor de investigación y la prioridad.
// TODO: Calcular el precio actualizado de la bicicleta.
// TODO: Crear dos funciones propias que DEVUELVAN resultados sin imprimir.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $barrio = $_POST['barrio'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $antiguedad = $_POST['antiguedad'] ?? '';
    $pistasMostradas = $_POST['pistasMostradas'] ?? [];
    $decisiones = $_POST['decisiones'] ?? [];

    function determinarPrioridad($valor) {
    if ($valor <= 2) {
        return 'BAJA';
    } elseif ($valor <= 5) {
        return 'MEDIA';
    } else {
        return 'ALTA';
    }
}

    $numeroDecisionesCorrectas = 0;
    $totalAumuladoDelValor = 0;
    $investigar = false;
    $recomendacion = "";
    $estado = "";
    $mensajeDeAviso = "";

    foreach ($pistasMostradas as $pista) {
        //comprobar si la pista es fiable o no
        $valorFiable = $pistas[$pista]['fiable'];
        //Comprobar que puso el usuario
        $valorPistaMostrada = $decisiones[$pista];

        //Determinar recomendacion
        if ($valorFiable == true) {
            $recomendacion = 'investigar';
        }else{
            $recomendacion = 'descartar';
        }

        //por si no hay una respuesta
        if ($valorPistaMostrada == '') {
            $estado = "sin decidir";
        }
    
        //comprobar si la pista es fiable y si el usuario puso la respuesta recomendada
        if ($valorFiable == true && $valorPistaMostrada == $recomendacion) {
            $numeroDecisionesCorrectas++;
            $totalAumuladoDelValor += $pistas[$pista]['valor'];
            if ($pista === 'gps' && $valorPistaMostrada === 'investigar') {
                $mensajeDeAviso = "Revisar la ubicación del rastreador GPS";
            }
        }

        determinarPrioridad($totalAumuladoDelValor);


    }

    $precioOriginal = $modelos[$modelo]['precio'];
    $descuento = $precioOriginal * $antiguedad * 0.10;
    $valorActual = $precioOriginal - $descuento;

}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Operación Cortacandados - Informe final</title>
</head>
<body>
    <h1>Expediente de robo</h1>
    <!-- TODO: Mostrar los datos del expediente. -->
    <p>Nombre: <?= htmlspecialchars($nombre ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    <p>Barrio: <?= htmlspecialchars($barrio ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    <p>Modelo de bicicleta: <?= htmlspecialchars($modelo ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    <p>Precio original: <?= htmlspecialchars($precioBici ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    <p>Antiguedad: <?= htmlspecialchars($antiguedad ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    <h1>Informe de investigación</h1>
    <!-- TODO: Mostrar la valoración, tabla de pistas y resumen del análisis. -->
    <p><a href="denuncia.html">Nuevo expediente</a></p>
</body>
</html>
