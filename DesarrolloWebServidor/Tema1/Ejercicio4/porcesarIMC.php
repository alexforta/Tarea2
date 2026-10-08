<?php
// EJERCICIO 04. Recibe datos desde IMC.html.
// TODO 4: muestra los resultados con una presentación HTML legible.
// TODO 5: si algún dato falla, no realices cálculos y muestra un aviso.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO 1: exige POST y comprueba que los cuatro datos existen y son válidos.
    $nombre = trim((string) ($_POST['nombre'] ?? ''));
    $edad = (string) ($_POST['edad'] ?? '');
    $altura = filter_var($_POST['altura'] ?? null, FILTER_VALIDATE_FLOAT);
    $peso = filter_var($_POST['peso'] ?? null, FILTER_VALIDATE_FLOAT);
    


    //Nombre
    if (mb_strlen($nombre, "UTF-8") <= 20) {
        echo "<h1>" . htmlspecialchars(ucfirst($nombre), ENT_QUOTES, "UTF-8") . "</h1>";
    } else {
        echo "El nombre no puede tener más de 20 caracteres";
    }

    //Edades 
    if ($edad >= 0) {
        echo "<p>" . "La edad es: " . htmlspecialchars($edad, ENT_QUOTES, "UTF-8") . "</p>";
    } else {
        echo "<p>La edad no es válida</p>";
    }

    // TODO 2: convierte la altura desde centímetros a metros.
    if ($altura === false || $altura < 50 || $altura > 300) {
        echo "<p>Error: La altura debe ser un número válido entre 50 y 300 kilos.</p>";
    } else {
        // $resultado = ;
        echo "<p> La altura es: " . $altura / 100 . "</p>";
    }
    // TODO 3: calcula IMC y la estimación didáctica de pulsaciones máximas.
    if ($peso === false || $peso < 20 || $peso > 500) {
        echo "<p>Error: La peso debe ser un número válido entre 20 y 500 kilos.</p>";
    } else {
        $IMC = $peso / ($altura * $altura);
        $estimacionDidactica = 220 - $edad;
        echo "<p> El IMC es: $IMC" . "</p>";
        echo "<p> La estimacion didactica es: $estimacionDidactica" . "</p>";
    }
}
