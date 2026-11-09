<?php
declare(strict_types=1);

function obtenerUsuariosDemo(): array
{
    // Solo para aprendizaje local: en una aplicación real los hashes están almacenados.
    return [
        'ana@club.test' => [
            'nombre' => 'Ana',
            'hash' => password_hash('claveAna123', PASSWORD_DEFAULT)
        ],
        'luis@club.test' => [
            'nombre' => 'Luis',
            'hash' => password_hash('claveLuis123', PASSWORD_DEFAULT)
        ]
    ];
}

function autenticar(string $email, string $clave): ?string
{
    $cuentas = obtenerUsuariosDemo();
    //strtolower => Combierte el correo a minusculas
    //trim => Elimina los espacios al inicio y al final
    $email = strtolower(trim($email));
    /**
     * Si el email no existe en el array de cuentas devuelve null
     */
    if (!isset($cuentas[$email])) {
        return null;
    }
    /**
     * password_verify => Comprueba que la clave que se ha pasado coincida con el has generado automaticamente
     * Si no coincide devuelve return
     */
    if (!password_verify($clave, $cuentas[$email]['hash'])) {
        return null;
    }
    return $cuentas[$email]['nombre'];
}
