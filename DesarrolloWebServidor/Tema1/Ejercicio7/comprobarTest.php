<?php
require_once __DIR__ . '/repositorioPreguntas.php';

// EJERCICIO 07 - PARTE B: CORRECCIÓN.
// TODO 1: exige POST y recupera asignatura, preguntas y respuestas.
// TODO 2: comprueba que las preguntas enviadas pertenecen a la asignatura,
//          no están repetidas y que cada respuesta pertenece a sus opciones.
// TODO 3: consulta el mapa de soluciones que has completado en el repositorio.
// TODO 4: cuenta aciertos y fallos (incluidas las preguntas en blanco).
// TODO 5: calcula una nota entre 0 y 10 y muestra el resultado en HTML.

echo 'Pendiente de implementar la corrección del ejercicio 07.';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asignatura = $_POST['asignatura'] ?? '';
    $arrayPreguntas = $_POST['preguntas'] ?? [];
    $arrayRespuestas = $_POST['respuestas'] ?? [];
    echo "<br>";
    $contadorAciertos = 0;

    // Recorremos solo el array de las preguntas que le tocaron al alumno
foreach ($arrayPreguntas as $indice => $pregunta) {
    
    // 1. Buscamos qué contestó el alumno a ESTA pregunta concreta (usando el $indice)
    // Usamos ?? null por si el alumno dejó la pregunta en blanco
    $respuestaDelAlumno = $arrayRespuestas[$indice] ?? null;
    
    // 2. Buscamos cuál es la solución oficial en nuestro repositorio
    $solucionOficial = $repositorioRespuestas[$asignatura][$pregunta];
    
    // 3. Comparamos directamente
    if ($respuestaDelAlumno === $solucionOficial) {
        echo "<p>Pregunta: $pregunta -> <b>Bien hecho</b></p>";
        $contadorAciertos++;
    } else {
        echo "<p>Pregunta: $pregunta -> <b>Mal</b> (Era $solucionOficial)</p>";
    }
    }
    echo "El numero de aciertos es: $contadorAciertos";
    echo "<br>";
    echo "El numero de fallos es:" . count($arrayRespuestas) -$contadorAciertos ;
}