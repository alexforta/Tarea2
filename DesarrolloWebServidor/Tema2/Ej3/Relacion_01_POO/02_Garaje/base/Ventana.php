<?php
class Ventana { /* TODO: estado privado, abrir, cerrar, estaAbierta */ 
    private bool $abierta;

    //Constructor para cuando hagan una ventana por defecto este cerrada
    public function __construct()
    {
        $this->abierta = false;
    }

    //Metodos para abrir y cerrar puertas
    public function abrir(): void {
        $this->abierta = true;
    }
    public function cerrar(): void {
        $this->abierta = false;
    }

    //Metodo para comprobar si esta abierta o cerrada
    public function comprobarEstado(): bool {
        return $this->abierta;
    }
}
