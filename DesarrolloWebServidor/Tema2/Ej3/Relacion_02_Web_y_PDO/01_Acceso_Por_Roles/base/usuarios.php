<?php
declare(strict_types=1);
// Cuentas disponibles para el ejercicio. No modificar los hashes.
function obtenerUsuarios(): array
{
    return [
        'alba@centro.test' => [
            'nombre' => 'Alba',
            'perfil' => 'coordinacion',
            'hash' => '$2y$12$6e8iI6DnlSALXZudEdv0x.wFUwiUQ7q.vo6mB3G1iSNhQ/x5G7oUu'
        ],
        'marcos@centro.test' => [
            'nombre' => 'Marcos',
            'perfil' => 'tecnico',
            'hash' => '$2y$12$8LbrFwZ./rd1yXjgC2fONOOBlHDs15Yr2JR2.MN6278taBBEN/c7.'
        ]
    ];
}
function autenticar(string $email, string $clave): ?string
{
    $cuentas = obtenerUsuarios();
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
