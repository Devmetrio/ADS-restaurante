<?php
require_once("conexion.php");

class OrdenDetalle extends conexion
{
    public function obtenerOrdenDetalle($idMesa)
    {
        $this->conectar();
        $sql = "SELECT mi.nombre AS NombrePlato,mi.descripcion AS Descripcion, mi.precio AS Precio, od.cantidad AS Cantidad, 
                co.idMesa AS Mesa FROM OrdenDetalles od 
                INNER JOIN    Ordenes o ON od.idOrden = o.idOrden 
                INNER JOIN    ControlOrdenes co ON co.idOrden = o.idOrden
                INNER JOIN    MenuItems mi ON od.idItem = mi.idItem WHERE co.idMesa = $idMesa";
        $respuesta = $this->conectar()->query($sql);

        // Verificar si se encontró alguna fila
        if ($respuesta->num_rows == 0) {
            $this->desconectar();
            return null;
        }

        $this->desconectar();
        return $respuesta;
    }

    public function insertarOrdenDetalle($comanda, $idOrden)
    {
        $this->conectar();
        $values = [];

        foreach ($comanda as $item) {
            $idItem = (int)$item['id'];
            $cantidad = (int)$item['cantidad'];
            $subtotal = (float)$item['subtotal'];
            
            // Agregar los valores en formato SQL
            $values[] = "($idItem, $cantidad, $idOrden, $subtotal)";
        }
    
        // Crear la consulta SQL
        $sql = "INSERT INTO OrdenDetalles (idItem, cantidad, idOrden, subtotal) VALUES " . implode(", ", $values);

        $respuesta = $this->conectar()->query($sql);
        $this->desconectar();
        return $respuesta;
    }
}
