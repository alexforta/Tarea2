<?php
declare(strict_types=1);
class EquipoRepositorio {
    public function __construct(private PDO $pdo) {}
    public function listarEquipos(): array {
        // TODO: SELECT y disponibilidad agregada.
        // Recupera los equipos en orden alfabético.
        return $this->pdo
            ->query('SELECT id, nombre, unidades FROM equipo ORDER BY id DESC')
            ->fetchAll();
    }
    public function listarPrestamos(): array {
        // TODO: JOIN y orden de préstamos.
        throw new LogicException('Pendiente de implementar');
    }
    public function prestar(int $equipoId, string $persona): int {
        // TODO: transacción, bloqueo de equipo y comprobación de disponibilidad.
        throw new LogicException('Pendiente de implementar');
    }
    public function devolver(int $prestamoId): bool {
        // TODO: actualizar solo los préstamos abiertos.
        throw new LogicException('Pendiente de implementar');
    }
}
