<?php

declare(strict_types=1);

class EquipoRepositorio
{
    public function __construct(private PDO $pdo) {}

    public function listarEquipos(): array
    {
        // Completa el listado y calcula las unidades disponibles.
        $resultado = [];
        //Guardo los equipos
        $equipos = $this->pdo
            ->query('SELECT id, nombre, unidades FROM equipo ORDER BY id DESC')->fetchAll();
        //Guardo el numero de devueltos = 0 de cada equipo, si un equipo no tiene prestamos no te aparece nada 
        $prestamosAbiertos = $this->pdo->query('SELECT equipo_id, COUNT(*) as pendiente FROM prestamo where devuelto = 0 group by equipo_id ')->fetchAll();
        foreach ($equipos as $equipo) {
            $pendiente = 0;
            foreach ($prestamosAbiertos as $prestamo) {
                if ($equipo['id'] === $prestamo['equipo_id']) {
                    $pendiente = $prestamo['pendiente'];
                }
            }
            $equipo['disponible'] = $equipo['unidades'] - $pendiente;
            $resultado[] = $equipo;
        }
        return $resultado;
    }

    public function listarPrestamos(): array
    {
        // Completa la consulta con INNER JOIN.
        return [];
    }

    public function prestar(int $equipoId, string $persona): void
    {
        // Comprueba equipo, disponibilidad y registra el préstamo.
    }

    public function devolver(int $prestamoId): bool
    {
        // Cambia el estado solamente si el préstamo sigue abierto.
        return false;
    }
}
