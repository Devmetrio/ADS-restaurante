<?php
require_once("conexion.php");

class Orden extends conexion
{

    public function crearOrden($hora)
    {
        $this->conectar();
        $sql = "INSERT INTO orden (ordenHora) VALUES ($hora)";
        $respuesta = $this->conectar()->query($sql);

        // Verificar si la consulta se ejecutó correctamente
        if ($respuesta) {
            // Obtener el último ID insertado con insert_id
            $ultimoId = $this->conectar()->insert_id;
        } else {
            // Si la consulta no se ejecutó correctamente, devolver un error
            $ultimoId = null;
        }

        $this->desconectar();
        return $ultimoId;
    }
}
