<?php
// TODO: función calcularMayoria($totalEscanos) que devuelva intdiv($totalEscanos, 2) + 1.
// TODO: función escapar($valor) para mostrar texto seguro en HTML.


/**
 * Calcula el umbral de la mayoría absoluta (mitad + 1) mediante división entera.
 *
 * @param int $totalEscanos Número total de escaños de la asamblea.
 * @return int Número exacto de escaños requeridos para la mayoría absoluta.
 */
function calcularMayoria($totalEscanos)
{
    return intdiv($totalEscanos, 2) + 1;
}

/**
 * Escapa un valor para su renderizado seguro en HTML previniendo ataques XSS.
 *
 * @param mixed $valor Texto o número a escapar.
 * @return string Cadena saneada con entidades HTML convertidas.
 */
function escapar($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}