<?php
require_once __DIR__ . '/datosEscenarios.php';
require_once __DIR__ . '/funciones.php';

// TODO 1: exigir POST, validar escenario y socios[] (array de 1 a 3 partidos).
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Este archivo requiere el método POST.');
}

$escenario = $_POST['escenario'] ?? '';
$socios = $_POST['socios'] ?? [];

// Validar que el escenario existe en $escenarios
if (!is_string($escenario) || !array_key_exists($escenario, $escenarios)) {
    exit('El escenario seleccionado no es válido.');
}

// Validar que $socios es un array con un número de elementos entre 1 y 3
if (!is_array($socios) || count($socios) < 1 || count($socios) > 3) {
    exit('Debes seleccionar entre 1 y 3 partidos para formar un pacto.');
}

// TODO 2: rechazar socios repetidos y nombres ajenos a la lista del escenario.

// 1. Validar que no hay elementos duplicados en $socios
if (count($socios) !== count(array_unique($socios))) {
    exit('No se pueden seleccionar partidos repetidos en la coalición.');
}

// 2. Validar que cada socio pertenece a la lista de partidos del escenario elegido
$partidosDisponibles = $escenarios[$escenario]['partidos'];
foreach ($socios as $socio) {
    if (!is_string($socio) || !array_key_exists($socio, $partidosDisponibles)) {
        exit('El partido ' . htmlspecialchars((string)$socio, ENT_QUOTES, 'UTF-8') . ' no existe en el escenario seleccionado.');
    }
}

// TODO 3: sumar escaños y calcular mayoría absoluta (mitad + 1).
$escanosPorEscenario = $escenarios[$escenario]['escanos'];

// Suma directa de escaños de los socios seleccionados
$sumaEscaniosPartidos = 0;
foreach ($socios as $socio) {
    $sumaEscaniosPartidos += $partidosDisponibles[$socio];
}

// División entera sin decimales para calcular la mayoría absoluta exactas (ej: 41 / 2 = 20 + 1 = 21)
$mayoriaAbsoluta = intdiv($escanosPorEscenario, 2) + 1;

// TODO 4: indicar mayoría sí/no, y cuántos escaños sobran o faltan.
$hayMayoria = ($sumaEscaniosPartidos >= $mayoriaAbsoluta);

if ($hayMayoria) {
    $escanosSobrantes = $sumaEscaniosPartidos - $mayoriaAbsoluta;
    $mensajeMayoria = "El pacto alcanza la mayoría absoluta. Sobran " . $escanosSobrantes . " escaño(s) respecto al umbral.";
} else {
    $escanosFaltantes = $mayoriaAbsoluta - $sumaEscaniosPartidos;
    $mensajeMayoria = "El pacto NO alcanza la mayoría absoluta. Faltan " . $escanosFaltantes . " escaño(s) para conseguirla.";
}

// TODO 5: para cada partido que NO forme parte del pacto, calcular
//          cuántos escaños tendría la coalición SI se uniera.
//          Marcar cuáles de esas coaliciones alcanzarían la mayoría.
$posiblesCoaliciones = [];

foreach ($partidosDisponibles as $nombrePartido => $cantidad) {
    // Si el partido NO forma parte de la lista de socios
    if (!in_array($nombrePartido, $socios, true)) {
        $escanosConExtra = $sumaEscaniosPartidos + $cantidad;
        $alcanzaMayoria  = ($escanosConExtra >= $mayoriaAbsoluta);

        $posiblesCoaliciones[$nombrePartido] = [
            'escanos_partido' => $cantidad,
            'escanos_total'   => $escanosConExtra,
            'mayoria'         => $alcanzaMayoria
        ];
    }
}

// TODO 6: indicar qué partido fuera del pacto permitiría llegar a
//          la mayoría aportando la MENOR cantidad de escaños.
//          Si el pacto ya tiene mayoría, no se necesita socio adicional.
//          Si ninguno sirve por sí solo, indicarlo.
$socioOptimo = null;
$escanosSocioOptimo = null;
$estadoSocioOptimo = '';

if ($hayMayoria) {
    $estadoSocioOptimo = 'ya_tiene_mayoria';
} else {
    foreach ($posiblesCoaliciones as $nombrePartido => $datos) {
        // Evaluar solo los partidos que sí permiten llegar a la mayoría
        if ($datos['mayoria']) {
            $escanosAportados = $datos['escanos_partido'];

            // Buscar el partido que aporta la menor cantidad de escaños
            if ($socioOptimo === null || $escanosAportados < $escanosSocioOptimo) {
                $socioOptimo = $nombrePartido;
                $escanosSocioOptimo = $escanosAportados;
            }
        }
    }

    if ($socioOptimo !== null) {
        $estadoSocioOptimo = 'socio_encontrado';
    } else {
        $estadoSocioOptimo = 'ninguno_sirve';
    }
}

// TODO 7: construir el informe en vistas/informe.php.
require __DIR__ . '/vistas/informe.php';