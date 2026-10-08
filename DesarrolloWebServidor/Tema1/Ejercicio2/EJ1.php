<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Covirán</title>
</head>

<body>
    <h1>Ticket de compra</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Producto</th>
                <th>Precio ud.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
        // Datos iniciales: productos y precios CON el IVA del 21 % ya incluido.
        $productos = [
            'Maritoñi' => 2.50,
            'Puleva de fresa' => 1.75,
            'Pipas granaínas' => 0.75,
            'Alhambra roja' => 1.25,
            'Salailla' => 0.50,
        ];
        // Cada cantidad corresponde al producto de la misma posición.
        $cantidadesCompradas = [2, 2, 1, 0, 0];

        // TODO 1: recorre los productos y enlaza cada precio con su cantidad.
        $cantidadesCompradasCopia = $cantidadesCompradas;
        foreach ($productos as $producto => $precio) {
            echo "$producto: $precio €<br>";
            $cantidad = $cantidadesCompradasCopia[0];
            $resultado = $precio * $cantidad;
            echo "$resultado €<br>";
            array_shift($cantidadesCompradasCopia);
            }
            
            // TODO 2: calcula el subtotal de cada producto y acumula el total.
            $total = "0";
            foreach ($productos as $producto => $precio) {
                $total += $precio;
                }
                echo "Total: $total";
                
        // TODO 3: muestra únicamente los productos de los que se ha comprado alguna unidad.
        $cantidadesCompradasCopia = $cantidadesCompradas;
        foreach ($productos as $producto => $precio) {
        $cantidad = $cantidadesCompradasCopia[0];
        
        if ($cantidad > "0") {
            echo "<tr><th>$cantidad</th><th>$producto</th><th>$precio</th></tr>";
        }
        array_shift($cantidadesCompradasCopia);
        }
        

        // TODO 4: muestra la fila TOTAL y calcula el IVA incluido en ese total.
        ?>
        </tbody>
    </table>
</body>

</html>