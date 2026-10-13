<?php
require_once __DIR__ . '/repositorioPreguntas.php';

// EJERCICIO 07 - PARTE A: GENERACIÓN.
// TODO 1: exige POST y valida asignatura y numeroDePreguntas (entre 1 y 5).
// TODO 2: elige al azar preguntas distintas del repositorio de esa asignatura.
// TODO 3: genera un formulario HTML POST dirigido a comprobarTest.php.
// TODO 4: incluye identificadores de preguntas y opciones de respuesta
//          (radios) para que el corrector pueda cotejar las respuestas.
// TODO 5: incorpora información suficiente para conocer qué asignatura
//          y qué preguntas se han mostrado, sin enviar al cliente las soluciones.

echo 'Pendiente de implementar la generación del ejercicio 07.';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $asignatura = $_POST['asignatura'] ?? '';
    $numeroPreguntas = $_POST['numeroPreguntas'] ?? '';

    //Compruebo la asignatura
    if ($asignatura === '' || !is_string($asignatura) ) {
        exit ("Selecciona un modelo");
    } 

    //Si el numero de preguntas es menor 1 o mayor a 5 da error
    if ($numeroPreguntas < 1 || $numeroPreguntas > 5) {
        exit('Selecciona numero de preguntas valido');
    }

    //Cogo de $repositorioPreguntas el array de la asignatura elegida
    $preguntasDisponibles = $repositorioPreguntas[$asignatura];

    //Devuelve las claves de $preguntasDisponibles sin las respuestas y ponemos la cantidad que queremos que coga
    $claves = (array) array_rand($preguntasDisponibles, $numeroPreguntas);
    foreach ($claves as $pregunta) {
        echo('<br>');
        echo htmlspecialchars($pregunta, ENT_QUOTES, 'UTF-8');
    }

    

}