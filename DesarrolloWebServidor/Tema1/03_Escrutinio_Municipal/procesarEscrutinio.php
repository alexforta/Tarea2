<?php
require_once __DIR__ . '/datosPartidos.php';
require_once __DIR__ . '/funciones.php';


// TODO 4: rechazar votos emitidos > censo y recuentos de 0 emitidos.
// TODO 5: calcular porcentajes de cada partido sobre VOTOS VÁLIDOS,
//          ordenar de más a menos votos e identificar empate en el primer puesto.
// TODO 6: contar cuántos partidos alcanzan el umbral didáctico del 5 %.
// TODO 7: mostrar tabla HTML mediante vistas/resultados.php.

// require __DIR__ . '/vistas/resultados.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // TODO 1: aceptar POST y validar censo entero entre 1 y 100000.
    $censo = $_POST['censo'] ?? '';
    $censoValidado = validarEntero($censo, 1, 100000);
    if ($censoValidado === false) {
        exit('Debes poner una cantidad valida');
    }

    // TODO 2: validar que votos[] contiene exactamente las claves de $partidos,
    //          y que todos los votos, blancos y nulos son enteros >= 0.
    $votos = $_POST['votos'] ?? [];
    $blancos = $_POST['blancos'] ?? '';
    $nulos = $_POST['nulos'] ?? '';


    foreach ($partidos as $partido) {
        //Si no existe el partido en el array de votos salta el mensaje
        if (!array_key_exists($partido, $votos)) {
            exit('Falta la candidatura: ' . escapar($partido));
        }
    }

    if ($blancos < 0 || $nulos < 0) {
        exit("Debe ser un numero entero");
    }


    // TODO 3: votos a candidaturas, votos válidos (candidaturas + blancos),
    //          emitidos (válidos + nulos), abstención y participación.
    $votosValidos = 0;
    foreach ($votos as $voto => $numeroVotos) {
        $votosValidos += $numeroVotos;
    }
    $votosValidos += $blancos;

    $emitidos= 0;
    $emitidos = $votosValidos + $nulos;
    echo $emitidos;
}
