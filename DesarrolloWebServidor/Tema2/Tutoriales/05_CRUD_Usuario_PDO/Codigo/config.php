<?php
declare(strict_types=1);

/**
 * Devuelve conexion con MYSQL
 * @return PDO
 */
function conectar(): PDO
{
    return new PDO(
        'mysql:host=127.0.0.1;dbname=ud2_usuarios;charset=utf8mb4',
        //Usuario y contraseña
        'root',
        '',
        //Los errores lanzan excepciones
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
}
