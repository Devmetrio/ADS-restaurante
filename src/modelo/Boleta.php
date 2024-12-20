<?php
require_once("conexion.php");

class Boleta extends conexion
{
    public function obtenerUltimaSerieBoleta()
    {
        $this->conectar();
        $sql = "SELECT MAX(serie) AS ultima_serie FROM Boletas";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();

        $fila = $resultado->fetch_assoc();
        return $fila['ultima_serie'] ?? 0; // Devuelve el valor máximo de serie o 0 si no hay datos
    }

    public function insertarBoletaDatos($dni, $idControlOrden)
    {
        $dni = (int)$dni;
        $idControlOrden = (int)$idControlOrden;
        $serie = (int)$this->obtenerUltimaSerieBoleta() + 1;
        var_dump($dni, $idControlOrden);
        $this->conectar();
        $sql = "INSERT INTO Boletas (DNI, serie, estadoBoleta, idControlOrden) 
                VALUES ($dni, $serie, 0,$idControlOrden)";
        $respuesta = $this->conectar()->query($sql);

        $this->desconectar();
        return $respuesta;
    }

    public function updateBoletaMontos($MontoEfectivo, $MontoVoucher, $idControlOrden)
    {
        $this->conectar();
        $sql = "UPDATE Boletas
                SET 
                MontoEfectivo = $MontoEfectivo,
                MontoVoucher = $MontoVoucher,
                estadoFactura = 1
                WHERE idControlOrden = $idControlOrden";
        $respuesta = $this->conectar()->query($sql);
        $this->desconectar();
        return $respuesta;
    }

}
?>