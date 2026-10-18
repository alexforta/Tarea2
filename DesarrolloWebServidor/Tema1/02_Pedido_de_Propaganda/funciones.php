<?php
// TODO: crea una función euros($numero) para mostrar cantidades con 2 decimales.
function euros($numero): string { return number_format($numero, 2, ',', '.') . ' €'; }
// TODO: crea una función escapar($texto) que use htmlspecialchars.
function escapar($texto): string {
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}
