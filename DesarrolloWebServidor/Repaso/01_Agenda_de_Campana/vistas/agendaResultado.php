<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultados de agenda</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <h1>Actos encontrados</h1>
    <!-- TODO: mostrar los filtros, el total de coincidencias y el aforo acumulado. -->
    <p><?= htmlspecialchars($provincia ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    <p>Coincidencias: <?= htmlspecialchars((string)($numeroCoincidencias ?? 0), ENT_QUOTES, 'UTF-8') ?></p>
    <p>Aforo: <?= htmlspecialchars((string)($aforoTotal ?? 0), ENT_QUOTES, 'UTF-8') ?></p>
    <!-- TODO: tabla con fecha, hora, provincia, partido, tipo, lugar y aforo. -->
     <!-- Compruebo su $actosActivos esta vacio, si lo esta salta un error y no muestra la tabla -->
    <?php if (!empty($actosAceptados)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Provincia</th>
                    <th>Partido</th>
                    <th>Tipo</th>
                    <th>Lugar</th>
                    <th>Aforo</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($actosAceptados as $acto): ?>
                    <tr>
                        <td><?= htmlspecialchars($acto['fecha'] ?? '') ?></td>
                        <td><?= htmlspecialchars($acto['hora'] ?? '') ?></td>
                        <td><?= htmlspecialchars($acto['provincia'] ?? '') ?></td>
                        <td><?= htmlspecialchars($acto['partido'] ?? '') ?></td>
                        <td><?= htmlspecialchars($acto['tipo'] ?? '') ?></td>
                        <td><?= htmlspecialchars($acto['lugar'] ?? '') ?></td>
                        <td><?= htmlspecialchars($acto['aforo'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <!-- TODO: si no hay coincidencias, indicar que la búsqueda no tiene resultados. -->
    <p><a href="agenda.html">Nueva búsqueda</a></p>
</body>

</html>