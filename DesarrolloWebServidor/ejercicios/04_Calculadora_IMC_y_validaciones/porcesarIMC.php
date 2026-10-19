<?php

require_once '../formulario.php';

// Comprobamos que se haya accedido mediante POST.
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    exit('Accede desde el formulario mediante POST.');
}

// Recogemos y validamos los datos.
$nombre = trim((string) ($_POST['nombre'] ?? ''));

$edad = validarEntero('edad', 0, 130);
$alturaCm = validarEntero('altura', 50, 300);
$pesoKg = validarDecimal('peso', 20, 500);

// Validamos el nombre y comprobamos que los demás datos sean correctos.
if (
    $nombre === '' ||
    preg_match_all('/./us', $nombre) > 20 ||
    $edad === false ||
    $alturaCm === false ||
    $pesoKg === false
) {
    exit(
        'Revisa los campos: nombre (1–20 caracteres), edad (0–130), ' .
        'altura (50–300 cm) y peso (20–500 kg).'
    );
}

// Calculamos el IMC.
$alturaMetros = $alturaCm / 100;

$imc = round(
    $pesoKg / ($alturaMetros * $alturaMetros),
    2
);

// Estimación didáctica.
$pulsoEstimado = 220 - $edad;

// Escapamos el nombre antes de mostrarlo.
$nombreSeguro = htmlspecialchars(
    $nombre,
    ENT_QUOTES,
    'UTF-8'
);

// Generamos la página HTML.
imprimirCabecera('IMC');

echo '<h1>Resultados de ' . $nombreSeguro . '</h1>';

echo '<p>IMC calculado: '
    . number_format($imc, 2, ',', '.')
    . '</p>';

echo '<p>Estimación didáctica de pulsaciones máximas (220 − edad): '
    . $pulsoEstimado
    . ' pulsaciones/minuto.</p>';

echo '<p>Estos cálculos son ejemplos de programación, no una valoración médica.</p>';

imprimirPie();