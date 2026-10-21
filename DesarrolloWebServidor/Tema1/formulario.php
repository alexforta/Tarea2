<?php

function validarEntero(string $campo, int $min, int $max): int|false
{
    return filter_var(
        $_POST[$campo] ?? null,
        FILTER_VALIDATE_INT,
        [
            'options' => [
                'min_range' => $min,
                'max_range' => $max
            ]
        ]
    );
}

function validarDecimal(string $campo, float $min, float $max): float|false
{
    $valor = filter_var(
        $_POST[$campo] ?? null,
        FILTER_VALIDATE_FLOAT
    );

    if ($valor !== false && $valor >= $min && $valor <= $max) {
        return $valor;
    }

    return false;
}

function imprimirCabecera(string $titulo): void
{
    echo '<!doctype html>';
    echo '<html lang="es">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>' . htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') . '</title>';
    echo '</head>';
    echo '<body>';
}

function imprimirPie(): void
{
    echo '</body>';
    echo '</html>';
}