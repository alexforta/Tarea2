<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket del pedido</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <h1>Ticket de material electoral</h1>
    <!-- TODO: tabla o lista con partido, pack, unidades, extras y transporte. -->
    <table border="1">
        <thead>
            <tr>
                <th>partido</th>
                <th>pack</th>
                <th>unidades</th>
                <th>extras</th>
                <th>transporte</th>
            </tr>
            <tr>
                <th><?= htmlspecialchars($partido ?? '') ?></th>
                <th><?= htmlspecialchars($pack ?? '') ?></th>
                <th><?= htmlspecialchars($unidades ?? '') ?></th>
                <td>
                    <?php if (!empty($extra)): ?>
                        <!-- implode() une los elementos del array con una coma -->
                        <?= htmlspecialchars(implode(', ', $extra)) ?>
                    <?php else: ?>
                        Ninguno
                    <?php endif; ?>
                </td>
                <th><?= htmlspecialchars($transporte ?? '') ?></th>
            </tr>
        </thead>
    </table>
    <!-- TODO: mostrar subtotal, descuento, transporte, base, IVA y total. -->
    <!-- TODO: mensaje distinto dependiendo de si se superan los 500 €. -->
    <p><a href="pedido.html">Volver al formulario</a></p>
</body>

</html>