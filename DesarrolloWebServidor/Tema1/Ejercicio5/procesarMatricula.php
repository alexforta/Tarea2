<?php
require_once __DIR__ . '/horario.php'; // Datos de días, tramos horarios y asignaturas.

// EJERCICIO 05.
// TODO 1: acepta únicamente POST; recupera y valida asignaturas[].
// TODO 2: para cada asignatura elegida, muestra sus días e intervalos de clase.
// TODO 3: suma la duración semanal de TODOS sus intervalos (hay días con dos tramos).
// TODO 4 (ampliación): genera una tabla de lunes a viernes y colorea las celdas
//    de los tramos que correspondan a las asignaturas seleccionadas.
// En horario.php están los datos iniciales; la lógica debes escribirla aquí.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asignaturas = $_POST['asignaturas'] ?? [];
    $a = $horario;

    if (empty($asignaturas)) {
        echo "<p>No has seleccionado ninguna asignaturas.</p>";
    } else {
        echo "<ul>";
        foreach ($asignaturas as $asignaruta) {
            echo "<li>" . htmlspecialchars($asignaruta, ENT_QUOTES, "UTF-8") . "</li>";
            foreach ($horario as $asignaturaHorario) {
                if ($asignaturaHorario == $asignaruta) {
                    echo " - $dia de " . $horas[$i] . " a " . $horas[$i + 1];
                }
            }
        }
        echo "</ul>";
    }
}
