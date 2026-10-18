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
    <h2>Resumen:</h2>

    <!-- Compruebo su $actosActivos esta vacio, si lo esta salta un error y no muestra la tabla -->
    <?php if (!empty($actosValidos)): ?>
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
                <?php foreach ($actosValidos as $acto): ?>
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

    <p><a href="agenda.html">Nueva búsqueda</a></p>
</body>

</html>