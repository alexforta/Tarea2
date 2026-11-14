<?php
declare(strict_types=1);

class UsuarioRepositorio
{
    //Recibe el pdo y lo guarda en propiedad privada
    public function __construct(private PDO $pdo) {}

    /**
     * Ejecuta un select y devuelve un array con id, email, nombre
     * @return array
     */
    public function listar(): array
    {
        return $this->pdo
            ->query('SELECT id, email, nombre FROM usuario ORDER BY id DESC')
            ->fetchAll();
    }

    /**
     * Funcion para crear usuario en la tabla sql
     * @param string $email Valida correo
     * @param string $nombre Comprueba que nombre no este vacio
     * @param string $password Contraseña de al menos 8 caracteres
     * @throws InvalidArgumentException
     * @return void
     */
    public function crear(string $email, string $nombre, string $password): void
    {
        $email = strtolower(trim($email));
        $nombre = trim($nombre);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)
            || $nombre === '' || strlen($nombre) > 120 || strlen($password) < 8) {
            throw new InvalidArgumentException('Datos incorrectos; clave de al menos 8 caracteres.');
        }
        //Combierte la contraseña en codigo hash
        $hash = password_hash($password, PASSWORD_DEFAULT);
        //Añade un usuario, los 3 ? son huecos para el correo, el nombre y el hash
        $sql = 'INSERT INTO usuario(email, nombre, clave_hash) VALUES (?, ?, ?)';
        //Prepara la consulta SQL y la guarda para usarla despues
        $sentencia = $this->pdo->prepare($sql);
        //Ejecuta la consulta usando $email para el primer ?, $nombre para el segundo y $hash para el tercero.
        $sentencia->execute([$email, $nombre, $hash]);
    }

    /**
     * Funcion para cambiar el nombre de un usuario por un id que le pases
     * @param int $id id a utilizar 
     * @param string $nombre nombre a cambiar 
     * @throws InvalidArgumentException
     * @return void
     */
    public function renombrar(int $id, string $nombre): void
    {
        //quita espacios
        $nombre = trim($nombre);
        //Comprobacion datos validos
        if ($id < 1 || $nombre === '' || strlen($nombre) > 120) {
            throw new InvalidArgumentException('Id o nombre no válido.');
        }
        //Prepara la consulta para el cambio en la base de datos
        $sentencia = $this->pdo->prepare('UPDATE usuario SET nombre = ? WHERE id = ?');
        //Ejecuta esa conulta
        $sentencia->execute([$nombre, $id]);
    }

    /**
     * Funcion para borrar un usuario en la base de datos
     * @param int $id id de la persona a buscar
     * @throws InvalidArgumentException
     * @return void
     */
    public function borrar(int $id): void
    {
        if ($id < 1) {
            throw new InvalidArgumentException('Id no válido.');
        }
        //Prepara la consulta para la insercion en la base de datos 
        $sentencia = $this->pdo->prepare('DELETE FROM usuario WHERE id = ?');
        //Ejecucion de la consulta
        $sentencia->execute([$id]);
    }
}
