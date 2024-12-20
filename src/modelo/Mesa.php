<?php
require_once("conexion.php");

class Mesa extends conexion
{

  public function obtenerMesas()
  {
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

  public function agregarMesa($capacidad, $idSeccion, $estado)
  {
    $this->conectar();
    $sql = "INSERT INTO mesas (capacidad, idSeccion, idMesaEstado, estadoTecnico) VALUES ($capacidad, $idSeccion, 1, $estado)";
    $respuesta = $this->conectar()->query($sql);

    $this->desconectar();
  }

  public function actualizarEstadoTecnico($idMesa, $valorEstado)
  {
    $this->conectar();
    $sql = "UPDATE mesas SET estadoTecnico = '$valorEstado' WHERE idMesa = $idMesa";
    $respuesta = $this->conectar()->query($sql);

    $this->desconectar();
  }

  public function actualizarEstadoSalon($idMesa, $valor)
  {
    $this->conectar();
    $sql = "UPDATE mesas SET idMesaEstado = '$valor' WHERE idMesa = $idMesa";
    $respuesta = $this->conectar()->query($sql);

    $this->desconectar();
  }

  public function mandarMesas()
  {
    $this->conectar();
    $sql = "SELECT idMesa, capacidad, idMesaEstado FROM mesas WHERE estadoTecnico = 1";
    $respuesta = $this->conectar()->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return $respuesta;
  }

  public function obtenerSecundarias()
  {
    $this->conectar();
    $sql = "SELECT idMesa FROM mesas WHERE idMesa NOT IN (SELECT idMesa FROM controlordenes WHERE EstadoControlOrden = 1) AND idMesa NOT IN (
                SELECT idMesa FROM mesasecundarias) AND idMesaEstado = 3;";
    $respuesta = $this->conectar()->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return $respuesta->fetch_all(MYSQLI_ASSOC);
  }

  public function cambiarEstadoMesa($idMesa, $nuevoEstado)
{
    $this->conectar();
    $sql = "UPDATE mesas SET idMesaEstado = ? WHERE idMesa = ?";
    $stmt = $this->conectar()->prepare($sql);
    $stmt->bind_param("ii", $nuevoEstado, $idMesa);
    $stmt->execute();
    $stmt->close();
    $this->desconectar();
}

public function obtenerEstadoMesa($idMesa)
{
    $this->conectar();
    $sql = "SELECT idMesaEstado FROM mesas WHERE idMesa = ?";
    $stmt = $this->conectar()->prepare($sql);
    $stmt->bind_param('i', $idMesa);
    $stmt->execute();
    $result = $stmt->get_result();
    $estado = $result->fetch_assoc()['idMesaEstado'];
    $stmt->close();
    $this->desconectar();
    return $estado;
}

public function cambiarEstadoLibreAOcupado($idMesa)
{
    $this->conectar();
    
    // Verificar el estado actual de la mesa
    $sql = "SELECT idMesaEstado FROM mesas WHERE idMesa = ?";
    $stmt = $this->conectar()->prepare($sql);
    $stmt->bind_param('i', $idMesa);
    $stmt->execute();
    $result = $stmt->get_result();
    $estadoActual = $result->fetch_assoc()['idMesaEstado'];
    $stmt->close();

    // Permitir el cambio solo si el estado actual es "Libre" (idMesaEstado = 1)
    if ($estadoActual == 1) {
        $nuevoEstado = 3; // "Ocupado"

        // Actualizar el estado de la mesa
        $sqlUpdate = "UPDATE mesas SET idMesaEstado = ? WHERE idMesa = ?";
        $stmtUpdate = $this->conectar()->prepare($sqlUpdate);
        $stmtUpdate->bind_param('ii', $nuevoEstado, $idMesa);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        $this->desconectar();
        return true; // Cambio realizado con éxito
    }

    $this->desconectar();
    return false; // No se permitió el cambio
}


}
