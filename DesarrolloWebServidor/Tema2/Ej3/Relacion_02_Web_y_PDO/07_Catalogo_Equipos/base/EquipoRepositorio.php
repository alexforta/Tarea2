<?php
declare(strict_types=1);

class EquipoRepositorio
{
    public function __construct(private PDO $pdo) {}

    public function listar(): array
    {
        // Recupera los equipos en orden alfabético.
        return $this->pdo
            ->query('SELECT id, nombre, unidades FROM equipo ORDER BY id DESC')
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
        //Comprobacion datos validos
        if ($id < 1 || $unidades <= 0 ) {
            throw new InvalidArgumentException('Id o numero no válido.');
        }
        //Prepara la consulta para el cambio en la base de datos
        $sentencia = $this->pdo->prepare('UPDATE equipo SET unidades = ? WHERE id = ?');
        //Ejecuta esa conulta
        $sentencia->execute([$unidades, $id]);
    }

    public function eliminar(int $id): void
    {
        // Comprueba el equipo y elimínalo.
        if ($id < 1) {
            throw new InvalidArgumentException('Id no válido.');
        }
        //Prepara la consulta para la insercion en la base de datos 
        $sentencia = $this->pdo->prepare('DELETE FROM equipo WHERE id = ?');
        //Ejecucion de la consulta
        $sentencia->execute([$id]);
    }
}
