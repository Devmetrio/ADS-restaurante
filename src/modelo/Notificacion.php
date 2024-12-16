<?php
require_once("conexion.php");

class Notificacion extends Conexion {
    public function obtenerNotificaciones() {
        $conexion = $this->conectar();
        $sql = "SELECT * FROM notificaciones WHERE procesado = 0";
        $result = mysqli_query($conexion, $sql);

        if (!$result) {
            die("Error al ejecutar consulta: " . mysqli_error($conexion));
        }

        $notificaciones = [];
        while ($fila = mysqli_fetch_assoc($result)) {
            $notificaciones[] = $fila;
        }

        return $notificaciones;
    }

    public function marcarNotificaciones() {
        $conexion = $this->conectar();
        $sql = "UPDATE notificaciones SET procesado = 1 WHERE procesado = 0";
        if (!mysqli_query($conexion, $sql)) {
            die("Error al actualizar notificaciones: " . mysqli_error($conexion));
        }
    }
}