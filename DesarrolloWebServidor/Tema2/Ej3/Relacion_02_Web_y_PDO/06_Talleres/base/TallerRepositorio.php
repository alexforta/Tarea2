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
        $resultado = [];

        foreach ($talleres as &$taller) {
            foreach ($inscripcionesConfirmadas as $inscripcion) {
                # code...
            }
        }

        return $talleres;
    }

    public function listarInscripciones(): array
    {
        // Completa la consulta con INNER JOIN.
        return [];
    }

    public function inscribir(int $tallerId, string $nombre, string $email): string
    {
        // Comprueba los datos y devuelve confirmada o espera.
        return '';
    }

    public function cancelar(int $inscripcionId): bool
    {
        // Elimina la inscripción y, si procede, cubre la plaza libre.
        return false;
    }
}
