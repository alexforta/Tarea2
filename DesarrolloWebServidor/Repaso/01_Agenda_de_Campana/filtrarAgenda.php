<?php
require_once __DIR__ . '/datosActos.php';

// TODO 1: comprobar que la petición es GET.
// TODO 2: leer y validar provincia, partido, tipo y limite (1..10).
//          Permitir "Todas" / "Todos" para no filtrar ese campo.
// TODO 3: recorrer $actos y guardar todos los que cumplen LOS TRES filtros.
// TODO 4: calcular cantidad de coincidencias y aforo total coincidente.
// TODO 5: mostrar solo los primeros $limite actos usando una vista externa.

// 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $provincia = $_GET['provincia'] ?? '';
    $partido = $_GET['partido'] ?? '';
    $tipo = $_GET['tipo'] ?? '';
    $limite = $_GET['limite'] ?? '';

    if (!in_array($provincia, $provincias) && $provincia != "Todas" || !is_string($provincia) || $provincia === '') {
        exit('Añade una provincia valida');
    }
    if (!in_array($partido, $partidos) && $partido != "Todos" || !is_string($partido) || $partido === '') {
        exit('Añade un partido valido');
    }
    if (!in_array($tipo, $tipos) && $tipo != "Todos" || !is_string($tipo) || $tipo === '') {
        exit('Añade un tipo valido');
    }

    $actosAceptados = [];
    
    foreach ($actos as $acto) {
        $requisitosAceptados = true;
        foreach ($acto as $clave => $valor) {

            if ($clave === 'provincia') {
                if ($valor != $provincia && $provincia != "Todas") {
                    $requisitosAceptados = false;
                }
            }
            if ($clave === 'partido') {
                if ($valor != $partido && $partido != 'Todos') {
                    $requisitosAceptados = false;
                }
            }
            if ($clave === 'tipo') {
                if ($valor != $tipo && $tipo != 'Todos') {
                    $requisitosAceptados = false;
                }
            }
        }
        if ($requisitosAceptados === true) {
            $actosAceptados[] = $acto;
        }
    }
    $aforoTotal = 0;
    foreach ($actosAceptados as $clave) {
        $aforoTotal += $clave['aforo'];
    }
    $numeroCoincidencias = count($actosAceptados);
    require __DIR__ . '/vistas/agendaResultado.php';
}
