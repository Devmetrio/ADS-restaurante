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
  public function capacidadMesaDispo($fecha, $hora){
    $this->conectar();
    $sql = "SELECT
                SUM(m.capacidad) AS CapacidadTotal
            FROM mesas m
            LEFT JOIN reservas r 
                ON m.idMesa = r.idMesa
                AND r.fechaReserva = '$fecha'
                AND r.horaReserva BETWEEN SUBTIME('$hora', '02:00:00') 
                                      AND ADDTIME('$hora', '02:00:00')
            LEFT JOIN mesasecundariareservas msr
                ON m.idMesa = msr.idMesa
                AND msr.idReserva IN (
                    SELECT idReserva
                    FROM reservas
                    WHERE fechaReserva = '$fecha'
                      AND horaReserva BETWEEN SUBTIME('$hora', '02:00:00') 
                                          AND ADDTIME('$hora', '02:00:00')
                )
            WHERE r.idReserva IS NULL AND msr.idReserva IS NULL;"; // Filtramos solo las reservas con estado 'En curso'
    $respuesta = $this->conectar()->query($sql);
    $this->desconectar();
    $fila = $respuesta->fetch_assoc();
    $cantidad= $fila['CapacidadTotal'];
    return $cantidad;
  }

  public function obtenerEstadoMesasHora($fecha, $hora){
    $this->conectar();
    $sql = "SELECT 
              m.idMesa, 
              m.capacidad, 
              m.idSeccion, 
              m.idMesaEstado, 
              m.estadoTecnico,
              IF(r.idReserva IS NOT NULL OR msr.idReserva IS NOT NULL, 'Ocupada', 'Libre') AS EstadoReserva
          FROM mesas m
          LEFT JOIN reservas r 
              ON m.idMesa = r.idMesa
              AND r.fechaReserva = '$fecha'
              AND r.horaReserva BETWEEN SUBTIME('$hora', '02:00:00') 
                                    AND ADDTIME('$hora', '02:00:00')
          LEFT JOIN mesasecundariareservas msr
              ON m.idMesa = msr.idMesa
              AND msr.idReserva IN (
                  SELECT idReserva
                  FROM reservas
                  WHERE fechaReserva = '$fecha'
                    AND horaReserva BETWEEN SUBTIME('$hora', '02:00:00') 
                                        AND ADDTIME('$hora', '02:00:00')
              )
          WHERE r.idReserva IS NULL 
              OR r.idReserva IS NOT NULL
          ORDER BY m.idMesa
          LIMIT 0, 1000;"; // Filtramos solo las reservas con estado 'En curso'
    $respuesta = $this->conectar()->query($sql);
    $this->desconectar();
    return $respuesta;
  }

  public function obtenerMesasSecundariasHora($fecha, $hora, $mesaPrincipal = null)
{
    $this->conectar();

    // Construcción dinámica de la condición para excluir mesa principal
    $mesaPrincipalCondition = '';
    if (!empty($mesaPrincipal) && is_numeric($mesaPrincipal)) {
        $mesaPrincipalCondition = "AND m.idMesa != $mesaPrincipal";
    }

    // Query ajustado para incluir EstadoReserva y filtrar solo "Libre"
    $sql = "SELECT 
                m.idMesa, 
                m.capacidad, 
                m.idSeccion, 
                m.idMesaEstado, 
                m.estadoTecnico,
                IF(r.idReserva IS NOT NULL OR msr.idReserva IS NOT NULL, 'Ocupada', 'Libre') AS EstadoReserva
            FROM mesas m
            LEFT JOIN reservas r 
                ON m.idMesa = r.idMesa
                AND r.fechaReserva = '$fecha'
                AND r.horaReserva BETWEEN SUBTIME('$hora', '02:00:00') 
                                      AND ADDTIME('$hora', '02:00:00')
            LEFT JOIN mesasecundariareservas msr
                ON m.idMesa = msr.idMesa
                AND msr.idReserva IN (
                    SELECT idReserva
                    FROM reservas
                    WHERE fechaReserva = '$fecha'
                      AND horaReserva BETWEEN SUBTIME('$hora', '02:00:00') 
                                          AND ADDTIME('$hora', '02:00:00')
                )
            WHERE (r.idReserva IS NULL AND msr.idReserva IS NULL) 
              $mesaPrincipalCondition
            ORDER BY m.idMesa
            LIMIT 0, 1000;";

    $respuesta = $this->conectar()->query($sql);

    if (!$respuesta) {
        throw new mysqli_sql_exception("Error en la consulta: " . $this->conectar()->error);
    }

    $this->desconectar();
    return $respuesta->fetch_all(MYSQLI_ASSOC);
}
  
}
?>