<?php
require_once("conexion.php");

class Mesa extends conexion {

  public function obtenerMesas(){
    $this->conectar();
    $sql = "SELECT * FROM mesas";
    $respuesta = $this->conectar()->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return $respuesta;
  } 
  
  public function agregarMesa($capacidad,$idSeccion,$estado){
    $this->conectar();
    $sql = "INSERT INTO mesas (capacidad, idSeccion, idMesaEstado, estadoTecnico) VALUES ($capacidad, $idSeccion, 1, $estado)";
    $respuesta = $this->conectar()->query($sql);

    $this->desconectar();
  }

  public function actualizarEstadoTecnico($idMesa, $valorEstado){
    $this->conectar();
    $sql = "UPDATE mesas SET estadoTecnico = '$valorEstado' WHERE idMesa = $idMesa";
    $respuesta = $this->conectar()->query($sql);

    $this->desconectar();
  }

  public function actualizarEstadoSalon($idMesa, $valor){
    $this->conectar();
    $sql = "UPDATE mesas SET idMesaEstado = '$valor' WHERE idMesa = $idMesa";
    $respuesta = $this->conectar()->query($sql);

    $this->desconectar();
  }

}

?>