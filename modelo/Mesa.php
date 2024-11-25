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
  
  public function añadirMesa($capacidad,$idSeccion,$estado){
    $this->conectar();
    $sql = "INSERT INTO (capacidad, idSeccion, idMesaEstado, estadoTecnico) mesas VALUES ($capacidad, $idSeccion, 1, $estado)";
    $respuesta = $this->conectar()->query($sql);

    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return $respuesta;
  }

  public function actualizarEstado($idMesa, $valorEstado){
    $this->conectar();
    $sql = "UPDATE mesa SET estadoTecnico = '$valorEstado' WHERE idMesa = $idMesa";
    $respuesta = $this->conectar()->query($sql);

    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return $respuesta;
  }

}

?>