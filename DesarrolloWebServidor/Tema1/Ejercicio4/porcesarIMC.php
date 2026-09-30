<?php
// EJERCICIO 04. Recibe datos desde IMC.html.
// TODO 2: convierte la altura desde centímetros a metros.
// TODO 3: calcula IMC y la estimación didáctica de pulsaciones máximas.
// TODO 4: muestra los resultados con una presentación HTML legible.
// TODO 5: si algún dato falla, no realices cálculos y muestra un aviso.

echo 'Pendiente de implementar el ejercicio 04.';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO 1: exige POST y comprueba que los cuatro datos existen y son válidos.
    $nombre = trim((string) ($_POST['nombre'] ?? ''));
    $edad = (string) ($_POST['edad'] ?? '');
    $altura = (string) ($_POST['altura'] ?? '');
    $peso = (string) ($_POST['peso'] ?? '');

    $edadesValidas = [
        "Menos de 20 años",
        "Entre 20 y 39 años",
        "Entre 40 y 59 años",
        "60 años o más"
    ];

    //Nombre
    if (mb_strlen($nombre, "UTF-8") <= 20) {
        if (mb_strlen($apellidos, "UTF-8") <= 20) {
            echo "<h1>" . htmlspecialchars(ucfirst($nombre), ENT_QUOTES, "UTF-8") . " " . htmlspecialchars(ucwords($apellidos), ENT_QUOTES, "UTF-8") . "</h1>";
        } else {
            echo "El apellido no puede tener más de 20 caracteres";
        }
    } else {
        echo "El nombre no puede tener más de 20 caracteres";
    }

    //Edades 
    if (in_array($edad, $edadesValidas)) {
        echo "<p>" . htmlspecialchars($edad, ENT_QUOTES, "UTF-8") . "</p>";
    } else {
        echo "<p>La edad no es válida</p>";
    }
}