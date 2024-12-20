<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/ControlOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/panelCobros.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/formComprobantePago.php');
class controlComprobante
{
    public function desactivarEstadoControlOrden($idMesa)
    {
        echo "Ejecutando desactivarEstadoControlOrden<br>";
        $controlOrdenObject = new ControlOrden();
        $controlOrdenDesactivado = $controlOrdenObject->actualizarEstadoControlOrdenPorMesa($idMesa, 0);

        if ($controlOrdenDesactivado) {
            echo "Estado desactivado correctamente<br>";
            $formComprobantePagoObject = new formComprobantePago();
            $formComprobantePagoObject->formComprobantePagoShow($idMesa);
        } else {
            echo "Error al desactivar el estado<br>";
        }
    }

    public function obtenerComprobantesFaltosPago()
    {
        echo "Ejecutando desactivarEstadoControlOrden<br>";
        $controlOrdenObject = new ControlOrden();
        $controlOrdenFaltosPago = $controlOrdenObject->obtenerOrdenControlFaltosPago();

        if ($controlOrdenFaltosPago) {
            echo "Estado desactivado correctamente<br>";
            $panelCobrosObject = new panelCobros();
            $panelCobrosObject->panelCobrosShow();
        } else {
            echo "No se obtuvieron los comprobantes faltos pago<br>";
        }
    }
}   
