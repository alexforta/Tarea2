<?php
require_once __DIR__ . '/datosRobo.php';

// TODO: Recuperar los datos y las claves de las pistas mostradas.
// TODO: Analizar cada decisión y compararla con el catálogo.
// TODO: Calcular el valor de investigación y la prioridad.
// TODO: Calcular el precio actualizado de la bicicleta.
// TODO: Crear dos funciones propias que DEVUELVAN resultados sin imprimir.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function formatearEuros($cantidad) {
    return number_format($cantidad, 2, ',', '.') . ' €';
}

function determinarPrioridad($valor) {
    if ($valor <= 2) {
        return 'BAJA';
    } elseif ($valor <= 5) {
        return 'MEDIA';
    } else {
        return 'ALTA';
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Debes enviar los datos desde el formulario.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $barrio = $_POST['barrio'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $antiguedad = $_POST['antiguedad'] ?? '';
    $pistasMostradas = $_POST['pistasMostradas'] ?? [];
    $decisiones = $_POST['decisiones'] ?? [];

    // Comprobar los datos antes de utilizarlos.
    if (!is_string($nombre) || trim($nombre) === '') {
        exit('Introduce un nombre válido.');
    }
    $nombre = trim($nombre);

    if (!is_string($barrio) || !array_key_exists($barrio, $barrios)) {
        exit('El barrio no es válido.');
    }

    if (!is_string($modelo) || !array_key_exists($modelo, $modelos)) {
        exit('El modelo no es válido.');
    }

    $antiguedad = filter_var($antiguedad, FILTER_VALIDATE_INT);

    if ($antiguedad === false || $antiguedad < 0 || $antiguedad > 5) {
        exit('La antigüedad debe ser un número entero entre 0 y 5.');
    }

    if (!is_array($pistasMostradas) ||
        count($pistasMostradas) < 3 ||
        count($pistasMostradas) > 5) {
        exit('Debes recibir entre 3 y 5 pistas.');
    }

    if (!is_array($decisiones)) {
        exit('Las decisiones no tienen un formato válido.');
    }

    // Comprobar que todas las pistas existen en el catálogo.
    foreach ($pistasMostradas as $pista) {
        if (!is_string($pista) || !array_key_exists($pista, $pistas)) {
            exit('Se ha recibido una pista no válida.');
        }
    }

    if (count(array_unique($pistasMostradas)) !== count($pistasMostradas)) {
        exit('No se pueden repetir pistas.');
    }

    // Solo admitir decisiones válidas sobre las pistas mostradas.
    foreach ($decisiones as $pista => $decision) {
        if (!in_array($pista, $pistasMostradas, true) ||
            !in_array($decision, ['investigar', 'descartar'], true)) {
            exit('Se ha recibido una decisión no válida.');
        }
    }

    $decisionesCorrectas = 0;
    $valorInvestigacion = 0;
    $avisoGPS = false;
    $informe = [];

    foreach ($pistasMostradas as $pista) {
        // Comprobar si la pista es fiable o no.
        $valorFiable = $pistas[$pista]['fiable'];

        // Guardar el valor de la pista, si el usuario no respondió, guardar una cadena vacía.
        $valorPistaMostrada = $decisiones[$pista] ?? '';

        // Si el valor es fiable y pusiste investigar
        if ($valorFiable == true && $valorPistaMostrada == 'investigar') {
            $decisionesCorrectas++;
            $valorInvestigacion += $pistas[$pista]['valor'];

            //
            if ($pista === 'gps') {
                $avisoGPS = true;
            }
        } elseif ($valorFiable == false && $valorPistaMostrada == 'descartar') {
            // Descartar una pista no fiable también es correcto.
            $decisionesCorrectas++;
        }

        // Preparar la recomendación para mostrarla en la tabla.
        if ($valorFiable) {
            $recomendacion = 'investigar';
        } else {
            $recomendacion = 'descartar';
        }

        // Preparar el texto de la decisión del usuario.
        if ($valorPistaMostrada === '') {
            $decisionTexto = 'Sin decidir';
        } else {
            $decisionTexto = ucfirst($valorPistaMostrada);
        }

        if ($valorPistaMostrada === $recomendacion) {
            $resultado = 'Coincide';
        } else {
            $resultado = 'No coincide';
        }

        // Guardar los datos de esta pista para mostrarlos después.
        $informe[] = [
            'descripcion' => $pistas[$pista]['descripcion'],
            'decision' => $decisionTexto,
            'recomendacion' => ucfirst($recomendacion),
            'resultado' => $resultado
        ];
    }

    $totalPistas = count($pistasMostradas);
    $prioridad = determinarPrioridad($valorInvestigacion);

    // Descontar un 10 % del precio original por cada año.
    $precioBici = $modelos[$modelo]['precio'];
    $porcentajeDepreciacion = $antiguedad * 10;
    $descuento = $precioBici * $antiguedad * 0.10;
    $valorActual = $precioBici - $descuento;
}
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Operación Cortacandados - Informe final</title>
</head>

<body>
    <h1>Expediente de robo</h1>

    <p>Nombre: <?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></p>
    <p>Barrio: <?= htmlspecialchars($barrios[$barrio], ENT_QUOTES, 'UTF-8') ?></p>
    <p>Modelo de bicicleta: <?= htmlspecialchars($modelos[$modelo]['nombre'], ENT_QUOTES, 'UTF-8') ?></p>

    <h2>Valoración económica</h2>

    <p>Precio original: <?= formatearEuros($precioBici) ?></p>
    <p>Antigüedad: <?= $antiguedad ?> años</p>
    <p>Porcentaje de depreciación: <?= $porcentajeDepreciacion ?> %</p>
    <p>Importe descontado: <?= formatearEuros($descuento) ?></p>
    <p>Valor actual estimado: <?= formatearEuros($valorActual) ?></p>

    <h1>Informe de investigación</h1>

    <table>
        <thead>
            <tr>
                <th>Pista</th>
                <th>Decisión del usuario</th>
                <th>Recomendación</th>
                <th>Resultado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($informe as $fila): ?>
            <tr>
                <td><?= htmlspecialchars($fila['descripcion'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($fila['decision'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($fila['recomendacion'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($fila['resultado'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>Decisiones correctas: <?= $decisionesCorrectas ?> de <?= $totalPistas ?></p>
    <p>Valor de investigación: <?= $valorInvestigacion ?></p>
    <p>Prioridad: <?= $prioridad ?></p>

    <?php if ($avisoGPS): ?>
    <p>Revisar la ubicación del rastreador GPS</p>
    <?php endif; ?>

    <p><a href="denuncia.html">Nuevo expediente</a></p>
</body>

</html>