<?php
require_once("conexion.php");

class MesaSecundaria extends Conexion
{
    public function insertarMesasSecundarias($idControl, $array)
    {
        // Convertir $array en un array si es una cadena
        if (is_string($array)) {
            $array = explode(',', $array);
        }
        $this->conectar();
        $values = [];
        foreach ($array as $idMesa) {
            $values[] = "($idControl, $idMesa)";
        }

        // Unir los valores en un solo string
        $valuesString = implode(',', $values);

        $sql = "INSERT INTO mesaSecundarias (idControlOrden, idMesa) VALUES $valuesString";

        $respuesta = $this->conectar()->query($sql);
        $this->desconectar();
        return $respuesta;
    }

    public function obtenerMesaSecundaria($id)
    {
      $this->conectar();
      $sql = "  SELECT idControlOrden, idMesa FROM mesaSecundarias WHERE idControlOrden = $id";
      $respuesta = $this->conectar()->query($sql);
  
      // Verificar si se encontró alguna fila
      if ($respuesta->num_rows == 0) {
        $this->desconectar();
        return null;
      }
  
      $this->desconectar();
      return $respuesta->fetch_all(MYSQLI_ASSOC);
    }
}
