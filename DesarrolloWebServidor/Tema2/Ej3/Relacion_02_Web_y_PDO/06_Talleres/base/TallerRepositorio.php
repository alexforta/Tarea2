<?php

declare(strict_types=1);

class TallerRepositorio
{
    public function __construct(private PDO $pdo) {}

    public function listarTalleres(): array
    {
        $talleres = $this->pdo->query(
            'SELECT id, titulo, plazas FROM taller'
        )->fetchAll();

        $inscripcionesConfirmadas = $this->pdo->query(
            'SELECT taller_id FROM inscripcion WHERE estado = "CONFIRMADA"'
        )->fetchAll();

        $inscripcionesEspera = $this->pdo->query(
            'SELECT taller_id FROM inscripcion WHERE estado = "ESPERA"'
        )->fetchAll();

        foreach ($talleres as &$taller) {
            $abiertos = 0;
            $cerradas = 0;
            foreach ($inscripcionesConfirmadas as $inscripcion) {
                if ((int) $inscripcion['taller_id'] == (int) $taller['id']) {
                    $abiertos++;
                }
            }
            foreach ($inscripcionesEspera as $inscripcion) {
                if ((int) $inscripcion['taller_id'] == (int) $taller['id']) {
                    $cerradas++;
                }
            }
            $taller['confirmadas'] = (int) $abiertos;
            $taller['cerradas'] = (int) $cerradas;
        }

        return $talleres;
    }

    public function listarInscripciones(): array
    {

        $inscripciones = $this->pdo->query(
            'SELECT i.id, t.titulo AS taller, i.nombre, i.email 
            FROM inscripcion i INNER JOIN taller t ON i.taller_id = t.id
            ORDER BY i.id DESC'

        )->fetchAll();
        return $inscripciones;
    }

    public function inscribir(int $tallerId, string $nombre, string $email): string
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO inscripcion (taller_id, nombre, email, estado) VALUES (?, ?, ?, "CONFIRMADA")'
        );
        $stmt->execute([$tallerId, $nombre, $email]);
        return '';
    }

    public function cancelar(int $inscripcionId): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM inscripcion WHERE id = ?'
        );
        $stmt->execute([$inscripcionId]);
        return true;
    }
}
