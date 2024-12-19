<?php
require_once("conexion.php");

class Orden extends conexion
{

    public function crearOrden($hora)
    {
        $this->conectar();
        $sql = "INSERT INTO ordenes (ordenHora) VALUES ('$hora')";
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

    function actualizarOrden($idOrden, $hora){
        $this->conectar();
        $sql = "UPDATE ordenes SET OrdenHora = '$hora' WHERE idOrden = $idOrden;";
        $respuesta = $this->conectar()->query($sql);
    
        $this->desconectar();
    }
}
