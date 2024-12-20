<?php
require_once("conexion.php");

class Reserva extends conexion {
    public function obtenerReservasPorEstadoYFecha($fecha, $estado) {
        $this->conectar();
        $sql = "SELECT r.*, e.NombreEstado, GROUP_CONCAT(ms.idMesa ORDER BY ms.idMesa SEPARATOR ', ') AS mesasecundarias
                FROM reservas r
                INNER JOIN reservaestados e ON r.idEstado = e.idEstado
                LEFT JOIN mesasecundariareservas ms ON r.idReserva = ms.idReserva
                WHERE r.fechaReserva = ? AND e.NombreEstado = ?
                GROUP BY r.idReserva
                ORDER BY r.horaReserva ASC";
        $stmt = $this->conectar()->prepare($sql);
        $stmt->bind_param('ss', $fecha, $estado);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $this->desconectar();
        return $resultado;
    }

    public function crearReserva($idMesa, $fecha, $hora, $nombreCliente, $celularCliente) {
        $this->conectar();
        $sql = "INSERT INTO reservas (idMesa, fechaReserva, horaReserva, nombreCliente, celularCliente, idEstado)
                VALUES (?, ?, ?, ?, ?, 1)";
        $stmt = $this->conectar()->prepare($sql);
        $stmt->bind_param("isssi", $idMesa, $fecha, $hora, $nombreCliente, $celularCliente);
        $stmt->execute();

        $idReserva = $stmt->insert_id;
        $stmt->close();
        $this->desconectar();

        return $idReserva;
    }

    public function agregarMesaSecundaria($idReserva, $idMesaSecundaria) {
        $this->conectar();
        $sql = "INSERT INTO mesasecundariareservas (idReserva, idMesa) VALUES (?, ?)";
        $stmt = $this->conectar()->prepare($sql);
        $stmt->bind_param("ii", $idReserva, $idMesaSecundaria);
        $stmt->execute();
        $stmt->close();
        $this->desconectar();
    }
}
?>
