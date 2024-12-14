<?php
require_once("conexion.php");

class OrdenDetalle extends conexion
{
    public function obtenerOrdenDetalle($idMesa)
    {
        $this->conectar();
        $sql = "SELECT mi.nombre AS NombrePlato,mi.descripcion AS Descripcion, od.subtotal AS Subtotal, od.cantidad AS Cantidad, 
                co.idMesa AS Mesa, od.idOrden, co.idControlOrden FROM OrdenDetalles od 
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
        return $respuesta->fetch_all(MYSQLI_ASSOC);
    }

    public function insertarOrdenDetalle($comanda, $idOrden)
    {
        $this->conectar();
        $comanda = json_decode($comanda, true);

        if (!is_array($comanda)) {
            throw new Exception("La comanda no es válida o no se pudo decodificar.");
        }

        $values = [];

        foreach ($comanda as $item) {
            // Validar los datos del item
            if (isset($item['id'], $item['cantidad'], $item['subtotal'])) {
                $idItem = (int)$item['id'];
                $cantidad = (int)$item['cantidad'];
                $subtotal = (float)$item['subtotal'];

                // Agregar los valores en formato SQL
                $values[] = "($idItem, $cantidad, $idOrden, $subtotal)";
            } else {
                throw new Exception("Faltan datos en la comanda para uno de los items.");
            }
        }

        // Validar si hay valores para insertar
        if (empty($values)) {
            throw new Exception("No se encontraron valores válidos para insertar.");
        }

        $sql = "INSERT INTO OrdenDetalles (idItem, cantidad, idOrden, subtotal) VALUES " . implode(", ", $values);
        $respuesta = $this->conectar()->query($sql);
        if (!$respuesta) {
            throw new Exception("Error al insertar en OrdenDetalles: " . $this->conectar()->error);
        }

        $this->desconectar();
        return $respuesta;
    }

    public function obtenerOrdenPorId($id){
        $this->conectar();
        $sql = "SELECT mi.nombre AS NombrePlato,mi.descripcion AS Descripcion, od.subtotal AS Subtotal, od.cantidad AS Cantidad, 
                co.idMesa AS Mesa FROM OrdenDetalles od 
                INNER JOIN    Ordenes o ON od.idOrden = o.idOrden 
                INNER JOIN    ControlOrdenes co ON co.idOrden = o.idOrden
                INNER JOIN    MenuItems mi ON od.idItem = mi.idItem WHERE od.idOrden = $id";
        $respuesta = $this->conectar()->query($sql);
       
        return $respuesta->fetch_all(MYSQLI_ASSOC);
    }
}
