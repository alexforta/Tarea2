<?php
require_once __DIR__ . "/Ventana.php";
class Puerta
{
    private bool $abierta;
    private Ventana $ventana;

    function __construct()
    {
        $this->abierta = false;
        $this->ventana = new Ventana();
    }

    /**
     * Get the value of abierta
     */
    public function getAbierta()
    {
        return $this->abierta;
    }


    //metodos abrir cerrar puertas
    public function abrir(): void
    {
        $this->abierta = true;
    }
    public function cerrar(): void
    {
        $this->abierta = false;
    }

    public function getVentana(): void
    {
        $this->ventana;
    }
}
