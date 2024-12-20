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
<?php
require_once("conexion.php");

class Reserva extends conexion {
    public function crearReserva($idMesa, $idEstado, $fecha, $hora, $cliente, $celular) {
        $this->conectar();
        $sql = "INSERT INTO reservas (idMesa, idEstado, fechaReserva, horaReserva, nombreCliente, celularCliente) 
                VALUES ('$idMesa', '$idEstado', '$fecha', '$hora', '$cliente', '$celular')";
        $this->conectar()->query($sql);
        $this->desconectar();
    }

    public function actualizarEstadoReserva($idReserva, $nuevoEstado) {
        $this->conectar();
        $sql = "UPDATE reservas SET idEstado = '$nuevoEstado' WHERE idReserva = $idReserva";
        $this->conectar()->query($sql);
        $this->desconectar();
    }
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


    public function obtenerDetalleReserva($idReserva)
{
    // Conectar a la base de datos
    $this->conectar();

    // Consulta SQL para obtener los detalles de la reserva
    $query = "
        SELECT 
            r.idReserva, 
            r.nombreCliente, 
            r.fechaReserva, 
            r.horaReserva, 
            r.celularCliente, 
            r.idMesa AS mesaPrincipal, 
            e.NombreEstado AS estado, 
            GROUP_CONCAT(ms.idMesa ORDER BY ms.idMesa SEPARATOR ', ') AS mesasSecundarias
        FROM reservas r
        INNER JOIN reservaestados e ON r.idEstado = e.idEstado
        LEFT JOIN mesasecundariareservas ms ON r.idReserva = ms.idReserva
        WHERE r.idReserva = ?
        GROUP BY r.idReserva";

    $stmt = $this->conectar()->prepare($query);

    // Validar que $stmt no sea nulo
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $this->conectar()->error);
    }

    // Vincular parámetros y ejecutar
    $stmt->bind_param("i", $idReserva);
    $stmt->execute();
    $result = $stmt->get_result();

    // Desconectar
    $this->desconectar();

    // Retornar los resultados
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

public function actualizarEstadoPorReserva($idReserva)
{
    $nuevoEstado = 2; // Estado "Realizado"
    $this->conectar();
    $sql = "UPDATE reservas SET idEstado = ? WHERE idReserva = ?";
    $stmt = $this->conectar()->prepare($sql);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $this->conectar()->error);
    }

    // Vincular parámetros
    $stmt->bind_param("ii", $nuevoEstado, $idReserva);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Estado actualizado correctamente a 'Realizado' para la reserva con ID: " . $idReserva;
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

    $stmt->close();
    $this->desconectar();
}









    

}


?>