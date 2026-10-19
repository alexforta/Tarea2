<?php
function validarEntero($valor, $minimo, $maximo)
{
    $resultado = filter_var(
        $valor,
        FILTER_VALIDATE_INT,
        array(
            'options' => array(
                'min_range' => $minimo,
                'max_range' => $maximo
            )
        )
    );

    return $resultado;
}

function escapar($texto): string {
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}