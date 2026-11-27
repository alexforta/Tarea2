<?php
declare(strict_types=1);

class EquipoRepositorio
{
    public function __construct(private PDO $pdo)
    {
    }

    public function listarEquipos(): array
    {
        $equipos = $this->pdo->query(
            'SELECT id, nombre, unidades FROM equipo ORDER BY nombre'
        )->fetchAll();

        $prestamosAbiertos = $this->pdo->query(
            'SELECT equipo_id FROM prestamo WHERE devuelto = 0'
        )->fetchAll();

        $resultado = [];

        foreach ($equipos as $equipo) {
            $abiertos = 0;
            foreach ($prestamosAbiertos as $prestamo) {
                if ((int) $prestamo['equipo_id'] == (int) $equipo['id']) {
                    $abiertos++;
                }
            }
            $equipo['disponibles'] = (int) $equipo['unidades'] - $abiertos;
            $resultado[] = $equipo;
        }

        return $resultado;
    }

    public function listarPrestamos(): array
    {
        $prestamos = $this->pdo->query(
            'SELECT p.id, e.nombre AS equipo, p.persona, p.devuelto 
            FROM prestamo p INNER JOIN equipo e ON p.equipo_id = e.id
            ORDER BY p.id DESC'

        )->fetchAll();
        return $prestamos;
    }

    public function prestar(int $equipoId, string $persona): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO prestamo (equipo_id, persona, devuelto) VALUES (?, ?, 0)'
        );
        $stmt->execute([$equipoId, $persona]);
    }

    public function devolver(int $prestamoId): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE prestamo SET devuelto = 1 WHERE id = ? AND devuelto = 0'
        );
        $stmt->execute([$prestamoId]);
        return true;
    }
}
