<?php
require_once("conexion.php");

class MenuItem extends conexion
{

    public function obtenerMenu($Idcategoria)
    {
        $this->conectar();
        $sql = "SELECT * FROM menuItems WHERE idCategoria = $Idcategoria";
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