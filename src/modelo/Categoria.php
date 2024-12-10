<?php
require_once("conexion.php");

class Categoria extends conexion
{

    public function obtenerCategoria()
    {
        $this->conectar();
        $sql = "SELECT * FROM categoria";
        $respuesta = $this->conectar()->query($sql);

        // Verificar si se encontró alguna fila
        if ($respuesta->num_rows == 0) {
            $this->desconectar();
            return null;
        }

        $this->desconectar();
        return $respuesta;
    }
}
?>