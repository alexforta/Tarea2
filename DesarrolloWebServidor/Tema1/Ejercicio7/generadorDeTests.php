<?php
require_once __DIR__ . '/repositorioPreguntas.php';

// EJERCICIO 07 - PARTE A: GENERACIÓN.
// TODO 1: exige POST y valida asignatura y numeroDePreguntas (entre 1 y 5).
// TODO 2: elige al azar preguntas distintas del repositorio de esa asignatura.

// TODO 4: incluye identificadores de preguntas y opciones de respuesta
//          (radios) para que el corrector pueda cotejar las respuestas.
// TODO 5: incorpora información suficiente para conocer qué asignatura
//          y qué preguntas se han mostrado, sin enviar al cliente las soluciones.

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
    //Guardo la pregunta con la respuesta
    $clavesConRespuesta=[];
    //Guarda la pregunta con la respuesta
    foreach ($claves as $clave) {
        $clavesConRespuesta[$clave] = $repositorioPreguntas[$asignatura][$clave];
    }

    echo "<form action='comprobarTest.php' method='POST'>";
    echo "<input type='hidden' name='asignatura' value='$asignatura'>";
    /**
     * Poner las preguntas 
     * Recorrer las respuestas y ponerlas en un radio
     */
    $contador = 0;
    foreach ($clavesConRespuesta as $pregunta => $respuestas) {
        echo "<br>";
        echo "$pregunta";
        echo "<input type='hidden' name='preguntas[$contador]' value='" . htmlspecialchars($pregunta, ENT_QUOTES) . "'>";
        foreach ($respuestas as $respuesta) {
            echo"<br>";
            echo "<label>";
            echo "<input type='radio' name='respuestas[$contador]' value='" . htmlspecialchars($respuesta, ENT_QUOTES) . "' required> $respuesta";
            echo "</label><br>";
        }
        $contador++;
    }
    
    
    echo "<br><button type='submit'>Comprobar test</button>";
    echo "</form>";
}
?>
