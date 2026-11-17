<?php
declare(strict_types=1);

class EquipoRepositorio
{
    public function __construct(private PDO $pdo) {}

    public function listar(): array
    {
        // Recupera los equipos en orden alfabético.
        return $this->pdo
            ->query('SELECT nombre, unidades FROM equipo ORDER BY id DESC')
            ->fetchAll();
    }

    public function crear(string $nombre, int $unidades): void
    {
        // Comprueba los datos e inserta un equipo.

        $nombre = trim($nombre);
        $unidades = $unidades;
        if ( $nombre === '' || strlen($nombre) > 120 || $unidades < 0) {
            throw new InvalidArgumentException('Datos incorrectos; clave de al menos 8 caracteres.');
        }
        //Añade un usuario, los 3 ? son huecos para el correo, el nombre y el hash
        $sql = 'INSERT INTO equipo(nombre, unidades) VALUES (?, ?)';
        //Prepara la consulta SQL y la guarda para usarla despues
        $sentencia = $this->pdo->prepare($sql);
        //Ejecuta la consulta usando $email para el primer ?, $nombre para el segundo y $hash para el tercero.
        $sentencia->execute([$nombre, $unidades]);
    }

    public function actualizarUnidades(int $id, int $unidades): void
    {
        // Comprueba el equipo y actualiza las unidades.
    }

    public function eliminar(int $id): void
    {
        // Comprueba el equipo y elimínalo.
    }
}
