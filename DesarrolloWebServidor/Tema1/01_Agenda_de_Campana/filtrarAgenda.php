<?php
require_once __DIR__ . '/datosActos.php';

// TODO 1: comprobar que la petición es GET.
// TODO 2: leer y validar provincia, partido, tipo y limite (1..10).
//          Permitir "Todas" / "Todos" para no filtrar ese campo.
// TODO 3: recorrer $actos y guardar todos los que cumplen LOS TRES filtros.
// TODO 4: calcular cantidad de coincidencias y aforo total coincidente.
// TODO 5: mostrar solo los primeros $limite actos usando una vista externa.


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $provincia = $_GET['provincia'] ?? '';
    $partido = $_GET['partido'] ?? '';
    $tipo = $_GET['tipo'] ?? '';
    $limite = $_GET['limite'] ?? '';

    if ($provincia === '' || !is_string($provincia)) {
        exit("Selecciona una provincia");
    }
    if ($partido === '' || !is_string($partido)) {
        exit("Selecciona una partido");
    }
    if ($tipo === '' || !is_string($tipo)) {
        exit("Selecciona una tipo");
    }
    if ($limite === '' || !is_string($limite)) {
        exit("Selecciona una limite");
    }

    $actosValidos = [];
    $limitePartidos = 0;
    foreach ($actos as $acto) {
        $esValido = true;
        foreach ($acto as $clave => $valor) {
            //Comparo si la clave no es todos o el valor marcado, y si no lo es marco como valido false
            if ($clave === 'provincia') {
                if ($provincia != 'Todas' && $valor != $provincia) {
                    $esValido = false;
                }
            }
            if ($clave === 'partido') {
                if ($partido != 'Todos' && $valor != $partido) {
                    $esValido = false;
                }
            }
            if ($clave === 'tipo') {
                if ($tipo != 'Todos' && $valor != $tipo) {
                    $esValido = false;
                }
            }
        }
            //Si ninguna a coincidido con que todas sean otro valor guardo el acto
        if ($esValido === true) {
            $actosValidos[] = $acto;
            $limitePartidos++;
            //Si llega al numero maximo de partidos a mostrar para 
            if ($limitePartidos >= $limite) {
                break;
            }
        }
    }

    $aforoTotal = 0;
    foreach ($actosValidos as $acto ) {
        $aforoTotal += $acto['aforo'];
    }
    require __DIR__ . '/vistas/agendaResultado.php';
}
