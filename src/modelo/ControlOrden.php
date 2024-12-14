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

  public function insertarControlOrden($idMesa, $idUsuario, $fecha, $hora)
  {
    $this->conectar();
    $sql = "INSERT INTO ControlOrdenes (idMesa, EstadoControlOrden, idUsuario, ControlFecha, ControlHora) 
              VALUES ($idMesa, 1, $idUsuario, '$fecha', '$hora')";
    $respuesta = $this->conectar()->query($sql);

    if ($respuesta) {
      // Obtener el último ID insertado con insert_id
      $ultimoId = $this->conectar()->insert_id;
    } else {
      $ultimoId = null;
    }

    $this->desconectar();
    return $ultimoId;
  }

  public function verificarOrden($id)
  {
    $this->conectar();
    $sql = "SELECT idOrden FROM ControlOrdenes WHERE idControlOrden = $id;";
    $respuesta = $this->conectar()->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $fila = $respuesta->fetch_assoc();
    $idOrden = $fila['idOrden'];

    $this->desconectar();
    return $idOrden;
  }

  public function actualizarOrden($idOrden, $idControl){
    $this->conectar();
    $sql = "UPDATE controlordenes SET idOrden = $idOrden WHERE idControlOrden = $idControl;";
    $respuesta = $this->conectar()->query($sql);

    $this->desconectar();
  }
}
