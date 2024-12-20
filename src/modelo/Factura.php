<?php
require_once("conexion.php");

class Factura extends conexion
{

    // Función para obtener el último valor de serie
    public function obtenerUltimaSerieFactura()
    {
        $this->conectar();
        $sql = "SELECT MAX(serie) AS ultima_serie FROM Facturas";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();

        $fila = $resultado->fetch_assoc();
        return $fila['ultima_serie'] ?? 0; // Devuelve el valor máximo de serie o 0 si no hay datos
    }


    public function insertarFacturaDatos($idControlOrden, $ruc, $razonsocial)
    {
        $serie = $this->obtenerUltimaSerieFactura() + 1;
        $this->conectar();
        $sql = "INSERT INTO Facturas (RUC, RazonSocial,serie,estadoFactura,idControlOrden) 
                VALUES ($ruc, '$razonsocial', '$serie', 0, $idControlOrden)";
        $respuesta = $this->conectar()->query($sql);

        $this->desconectar();
        return $respuesta;
    }

    public function updateFacturaMontos($MontoEfectivo, $MontoVoucher, $idControlOrden)
    {
        $this->conectar();
        $sql = "UPDATE Facturas
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
