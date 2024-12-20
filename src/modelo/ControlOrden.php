<?php
require_once("conexion.php");

class ControlOrden extends conexion
{
  // obtenerControlOrdenPorUsuario
  public function obtenerOrdenControlPorUsuario($id)
  public function obtenerOrdenControlPorUsuario($id)
  {
    $this->conectar();
    $sql = "SELECT * FROM controlordenes WHERE estadocontrolorden = true AND idUsuario = $id";
    $respuesta = $this->conectar()->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return $respuesta;
  }

  public function obtenerIdControlPorMesa($idMesa)
  {
    $this->conectar();
    $sql = "SELECT idControlOrden FROM controlordenes WHERE idMesa = '$idMesa' AND estadocontrolorden = true";

    $respuesta = $this->conectar()->query($sql);

    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $registro = $respuesta->fetch_assoc();
    $idControl = $registro['idControlOrden'];

    $this->desconectar();
    return $idControl;
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

  public function actualizarOrden($idOrden, $idControl)
  {
    $this->conectar();
    $sql = "UPDATE controlordenes SET idOrden = $idOrden WHERE idControlOrden = $idControl;";
    $respuesta = $this->conectar()->query($sql);

    $this->desconectar();
  }

  public function obtenerOrdenPorId($id)
  {
    $this->conectar();
    $sql = "SELECT co.ControlFecha, co.ControlHora, o.OrdenHora, me.nombre AS NombrePlato, me.descripcion AS Descripcion, od.cantidad AS Cantidad, od.subtotal AS Subtotal
            FROM ControlOrdenes co
            JOIN Ordenes o ON co.idOrden = o.idOrden
            JOIN OrdenDetalles od ON o.idOrden = od.idOrden
            JOIN menuItems me ON me.idItem = od.idItem WHERE o.idOrden = $id;";
    $respuesta = $this->conectar()->query($sql);

    return $respuesta->fetch_all(MYSQLI_ASSOC);
  }

  //ControlFecha = CURDATE() AND  |
  // obtenerControlOrdenActivas
  public function obtenerOrdenControlActivas()
{
    $this->conectar();
    $sql = "SELECT co.idMesa, co.idControlOrden, u.idUsuario, u.login 
            FROM controlordenes co 
            JOIN usuarios u ON co.idUsuario = u.idUsuario 
            WHERE co.EstadoControlOrden = 1;";
    $respuesta = $this->conectar()->query($sql);

    if ($respuesta->num_rows == 0) {
        $this->desconectar();
        return [];
    }

    $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
    $this->desconectar();
    return $resultado;
}

  public function actualizarEstadoControlOrdenPorMesa($idMesa, $EstadoControlOrden)
  {
    $this->conectar();
    $sql = "UPDATE controlordenes SET EstadoControlOrden = $EstadoControlOrden WHERE idMesa = $idMesa;";
    $respuesta = $this->conectar()->query($sql);
    $this->desconectar();
    return $respuesta;
  }
  
  
  public function obtenerOrdenControlFaltosPago()
  {
    $this->conectar();
    $sql = "SELECT co.idMesa, u.login
            FROM ControlOrdenes co
            LEFT JOIN Boletas b ON co.idControlOrden = b.idControlOrden
            LEFT JOIN Facturas f ON co.idControlOrden = f.idControlOrden
            JOIN usuarios u ON co.idUsuario = u.idUsuario 
            WHERE (b.estadoBoleta = 0 OR f.estadoFactura = 0)";
    $respuesta = $this->conectar()->query($sql);

    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return [];
    }
    $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
    $this->desconectar();
    return $resultado;
  }
}
