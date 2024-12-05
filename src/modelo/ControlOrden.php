<?php
require_once("conexion.php");

class ControlOrden extends conexion
{
  public function obtenerOrdenControl()
  {
    $this->conectar();
    $sql = "SELECT * FROM controlordenes WHERE estadocontrolorden = true";
    $respuesta = $this->conectar()->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return $respuesta;
  }

  function insertarControlOrden()
  {
    $this->conectar();
    $sql = "SELECT * FROM controlordenes WHERE estadocontrolorden = true";
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
