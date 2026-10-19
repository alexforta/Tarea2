<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe del pacto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .bloque { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; max-width: 700px; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #e9ecef; }
        .exito { color: #198754; font-weight: bold; }
        .alerta { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Informe del pacto (simulación)</h1>

    <!-- TODO 1: nombre de la Asamblea, total escaños, umbral mayoría y socios. -->
    <div class="bloque">
        <h2>Datos del escenario</h2>
        <p><strong>Asamblea / Escenario:</strong> <?= htmlspecialchars((string)($escenarios[$escenario]['nombre'] ?? $escenario), ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Total de escaños de la asamblea:</strong> <?= htmlspecialchars((string)$escanosPorEscenario, ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Umbral de mayoría absoluta:</strong> <?= htmlspecialchars((string)$mayoriaAbsoluta, ENT_QUOTES, 'UTF-8') ?> escaños</p>
        <p><strong>Socios de la coalición inicial:</strong> 
            <?= htmlspecialchars(implode(', ', $socios), ENT_QUOTES, 'UTF-8') ?>
        </p>
    </div>

    <!-- TODO 2: escaños pactados y diagnóstico de mayoría, con diferencia. -->
    <div class="bloque">
        <h2>Resultado de la coalición</h2>
        <p><strong>Total de escaños sumados:</strong> <?= htmlspecialchars((string)$sumaEscaniosPartidos, ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Diagnóstico:</strong> 
            <span class="<?= $hayMayoria ? 'exito' : 'alerta' ?>">
                <?= htmlspecialchars($mensajeMayoria, ENT_QUOTES, 'UTF-8') ?>
            </span>
        </p>
    </div>

    <!-- TODO 3: tabla de partidos que quedan fuera y qué pasaría si se incorporasen. -->
    <h2>Posibles ampliaciones con partidos fuera del pacto</h2>
    <?php if (!empty($posiblesCoaliciones)): ?>
        <table>
            <thead>
                <tr>
                    <th>Partido</th>
                    <th>Escaños aportados</th>
                    <th>Escaños totales de la nueva coalición</th>
                    <th>¿Alcanzaría mayoría?</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posiblesCoaliciones as $partidoExtra => $datos): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($partidoExtra, ENT_QUOTES, 'UTF-8') ?></strong></td>
                        <td><?= htmlspecialchars((string)$datos['escanos_partido'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string)$datos['escanos_total'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <?php if ($datos['mayoria']): ?>
                                <span class="exito">Sí</span>
                            <?php else: ?>
                                <span class="alerta">No</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Todos los partidos disponibles forman parte del pacto inicial.</p>
    <?php endif; ?>

    <!-- TODO 4: informar del socio adicional válido de menor aportación, si existe. -->
    <div class="bloque" style="margin-top: 20px;">
        <h2>Socio adicional recomendado</h2>
        <?php if ($estadoSocioOptimo === 'ya_tiene_mayoria'): ?>
            <p class="exito">La coalición inicial ya tiene mayoría absoluta. No se requiere ningún socio adicional.</p>
        <?php elseif ($estadoSocioOptimo === 'socio_encontrado'): ?>
            <p>El socio óptimo fuera del pacto es <strong><?= htmlspecialchars((string)$socioOptimo, ENT_QUOTES, 'UTF-8') ?></strong>, ya que permite alcanzar la mayoría absoluta aportando la menor cantidad de escaños (<strong><?= htmlspecialchars((string)$escanosSocioOptimo, ENT_QUOTES, 'UTF-8') ?></strong> escaños).</p>
        <?php else: ?>
            <p class="alerta">Ningún partido individual fuera del pacto aporta escaños suficientes para alcanzar la mayoría absoluta por sí solo.</p>
        <?php endif; ?>
    </div>

    <p><a href="pactos.html">Analizar otro pacto</a></p>
</body>
</html>