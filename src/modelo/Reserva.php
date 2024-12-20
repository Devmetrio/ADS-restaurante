<?php
require_once("conexion.php");

class Reserva extends conexion {
    public function obtenerReservasPorEstadoYFecha($fecha, $estado){
        $this->conectar();
        $sql = "SELECT r.*, e.NombreEstado, GROUP_CONCAT(ms.idMesa ORDER BY ms.idMesa SEPARATOR ', ') AS mesasecundarias
                FROM reservas r
                INNER JOIN reservaestados e ON r.idEstado = e.idEstado
                LEFT JOIN mesasecundariareservas ms ON r.idReserva = ms.idReserva
                WHERE r.fechaReserva = '$fecha' AND e.NombreEstado = '$estado'
                GROUP BY r.idReserva
                ORDER BY r.horaReserva ASC"; // Filtramos solo las reservas con estado 'En curso'
        $respuesta = $this->conectar()->query($sql);
        $this->desconectar();
        return $respuesta;
    }
    
}
?>