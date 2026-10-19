<?php
require_once __DIR__ . '/datosPartidos.php';

// TODO 1: aceptar POST y validar censo entero entre 1 y 100000.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Este script solo acepta peticiones mediante el método POST.');
}

$censoRaw = $_POST['censo'] ?? '';
$censo = filter_var($censoRaw, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1, 'max_range' => 100000]
]);

if ($censo === false) {
    exit('El censo debe ser un número entero entre 1 y 100.000.');
}

// TODO 2: validar que votos[] contiene exactamente las claves de $partidos,
//          y que todos los votos, blancos y nulos son enteros >= 0.
$votosRecibidos = $_POST['votos'] ?? [];
$blancosRaw     = $_POST['blancos'] ?? '';
$nulosRaw       = $_POST['nulos'] ?? '';

if (!is_array($votosRecibidos)) {
    exit('El formato de los votos enviados no es válido.');
}

// Comprobar que estén todos los partidos configurados
$votosPartidos = [];
foreach ($partidos as $partido) {
    if (!array_key_exists($partido, $votosRecibidos)) {
        exit('Falta el recuento de votos para el partido ' . htmlspecialchars($partido, ENT_QUOTES, 'UTF-8') . '.');
    }

    $votoVal = filter_var($votosRecibidos[$partido], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 0]
    ]);

    if ($votoVal === false) {
        exit('Los votos del partido ' . htmlspecialchars($partido, ENT_QUOTES, 'UTF-8') . ' deben ser un entero mayor o igual a 0.');
    }

    $votosPartidos[$partido] = $votoVal;
}

// Validar votos en blanco y nulos
$blancos = filter_var($blancosRaw, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
if ($blancos === false) {
    exit('Los votos en blanco deben ser un número entero mayor o igual a 0.');
}

$nulos = filter_var($nulosRaw, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
if ($nulos === false) {
    exit('Los votos nulos deben ser un número entero mayor o igual a 0.');
}

// TODO 3: votos a candidaturas, votos válidos (candidaturas + blancos),
//          emitidos (válidos + nulos), abstención y participación.
$votosCandidaturas       = array_sum($votosPartidos);
$votosValidos            = $votosCandidaturas + $blancos;
$votosEmitidos           = $votosValidos + $nulos;
$abstencion              = $censo - $votosEmitidos;
$porcentajeParticipacion = round(($votosEmitidos / $censo) * 100, 2);

// TODO 4: rechazar votos emitidos > censo y recuentos de 0 emitidos.
if ($votosEmitidos === 0) {
    exit('El recuento no puede procesarse porque el total de votos emitidos es 0.');
}

if ($votosEmitidos > $censo) {
    exit('El total de votos emitidos (' . $votosEmitidos . ') no puede superar el censo (' . $censo . ').');
}

// TODO 5: calcular porcentajes de cada partido sobre VOTOS VÁLIDOS,
//          ordenar de más a menos votos e identificar empate en el primer puesto.

// Ordenar los partidos por número de votos de mayor a menor manteniendo claves
arsort($votosPartidos);

$resultadosPartidos     = [];
$partidosSuperanUmbral = 0;

foreach ($votosPartidos as $partido => $votos) {
    // Porcentaje sobre VOTOS VÁLIDOS (candidaturas + blancos)
    $porcentajeValidos = ($votosValidos > 0) ? round(($votos / $votosValidos) * 100, 2) : 0;

    // TODO 6: contar cuántos partidos alcanzan el umbral didáctico del 5 %.
    $superaUmbral = ($porcentajeValidos >= $umbralPorcentaje);
    if ($superaUmbral) {
        $partidosSuperanUmbral++;
    }

    $resultadosPartidos[$partido] = [
        'votos'         => $votos,
        'porcentaje'    => $porcentajeValidos,
        'supera_umbral' => $superaUmbral
    ];
}

// Identificar empate en el primer puesto
$votosPrimerPuesto = reset($votosPartidos);
$contPrimerPuesto  = 0;

foreach ($votosPartidos as $votos) {
    if ($votos === $votosPrimerPuesto) {
        $contPrimerPuesto++;
    }
}
$hayEmpatePrimerPuesto = ($contPrimerPuesto > 1);

// TODO 7: mostrar tabla HTML mediante vistas/resultados.php.
require __DIR__ . '/vistas/resultados.php';