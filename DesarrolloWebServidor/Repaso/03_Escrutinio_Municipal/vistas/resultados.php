<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del escrutinio</title>
</head>
<body>
    <h1>Resultado ficticio del escrutinio</h1>

    <!-- TODO 2: censo, emitidos, válidos, nulos, blancos, abstención y participación. -->
    <div class="resumen">
        <h2>Datos generales de participación</h2>
        <ul>
            <li><strong>Censo electoral:</strong> <?= htmlspecialchars((string)$censo, ENT_QUOTES, 'UTF-8') ?> electores</li>
            <li><strong>Votos emitidos:</strong> <?= htmlspecialchars((string)$votosEmitidos, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars((string)$porcentajeParticipacion, ENT_QUOTES, 'UTF-8') ?> % de participación)</li>
            <li><strong>Votos válidos:</strong> <?= htmlspecialchars((string)$votosValidos, ENT_QUOTES, 'UTF-8') ?></li>
            <li><strong>Votos a candidaturas:</strong> <?= htmlspecialchars((string)$votosCandidaturas, ENT_QUOTES, 'UTF-8') ?></li>
            <li><strong>Votos en blanco:</strong> <?= htmlspecialchars((string)$blancos, ENT_QUOTES, 'UTF-8') ?></li>
            <li><strong>Votos nulos:</strong> <?= htmlspecialchars((string)$nulos, ENT_QUOTES, 'UTF-8') ?></li>
            <li><strong>Abstención:</strong> <?= htmlspecialchars((string)$abstencion, ENT_QUOTES, 'UTF-8') ?> electores</li>
        </ul>
    </div>

    <!-- TODO 1: tabla de partidos por votos (descendente) y porcentaje sobre válidos. -->
    <h2>Resultados por candidatura</h2>
    <table>
        <thead>
            <tr>
                <th>Partido</th>
                <th>Votos</th>
                <th>Porcentaje (% sobre válidos)</th>
                <th>¿Supera el umbral (<?= htmlspecialchars((string)$umbralPorcentaje, ENT_QUOTES, 'UTF-8') ?> %)?</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultadosPartidos as $partido => $datos): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($partido, ENT_QUOTES, 'UTF-8') ?></strong></td>
                    <td><?= htmlspecialchars((string)$datos['votos'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars((string)$datos['porcentaje'], ENT_QUOTES, 'UTF-8') ?> %</td>
                    <td>
                        <?php if ($datos['supera_umbral']): ?>
                            <span class="exito">Sí</span>
                        <?php else: ?>
                            <span class="alerta">No</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- TODO 3: ganador o empate; número de partidos que alcanzan el 5 %. -->
    <div class="resumen">
        <h2>Diagnóstico del escrutinio</h2>
        <?php 
        // Obtener la clave (nombre) del primer partido en el array ya ordenado
        $ganadorProvisional = array_key_first($resultadosPartidos);
        ?>

        <?php if ($hayEmpatePrimerPuesto): ?>
            <p class="alerta">Se ha producido un <strong>EMPATE EN EL PRIMER PUESTO</strong> con <?= htmlspecialchars((string)$resultadosPartidos[$ganadorProvisional]['votos'], ENT_QUOTES, 'UTF-8') ?> votos.</p>
        <?php else: ?>
            <p class="exito">La candidatura más votada es <strong><?= htmlspecialchars($ganadorProvisional, ENT_QUOTES, 'UTF-8') ?></strong> con <?= htmlspecialchars((string)$resultadosPartidos[$ganadorProvisional]['votos'], ENT_QUOTES, 'UTF-8') ?> votos (<?= htmlspecialchars((string)$resultadosPartidos[$ganadorProvisional]['porcentaje'], ENT_QUOTES, 'UTF-8') ?> % de los votos válidos).</p>
        <?php endif; ?>

        <p><strong>Candidaturas que superan el umbral mínimo del <?= htmlspecialchars((string)$umbralPorcentaje, ENT_QUOTES, 'UTF-8') ?> %:</strong> <?= htmlspecialchars((string)$partidosSuperanUmbral, ENT_QUOTES, 'UTF-8') ?> candidatura(s).</p>
    </div>

    <p><a href="escrutinio.html">Nuevo recuento</a></p>
</body>
</html>