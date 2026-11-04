<?php
abstract class Envio { /* TODO: constructor con peso positivo y calcularPrecio abstracto */ 
    protected float $pesoKg;

    // public Envio(float $pesoKg){
    //     if ($pesoKg <= 0) {
    //         throw new Exception("El peso debe ser mayor que 0", 1);
            
    //     }
    // }
    public abstract calcularPrecio(): float{}
}
