<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/ControlOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/panelCobros.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/formComprobantePago.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/panelGestionOrden.php');
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

    public function activarEstadoControlOrden($idMesa)
    {
        echo "Ejecutando desactivarEstadoControlOrden<br>";
        $controlOrdenObject = new ControlOrden();
        $controlOrdenActivado = $controlOrdenObject->actualizarEstadoControlOrdenPorMesa($idMesa, 1);
        if ($controlOrdenActivado) {
            echo "Se logró update<br>";
            
        } else {
            echo "Error al hacer update a activado<br>";
        }
        $controlOrdenesActivas = $controlOrdenObject->obtenerOrdenControlActivas();

        if ($controlOrdenesActivas) {
            echo "Se llamo a control orden activas<br>";
            $panelGestionOrdenObject = new panelGestionOrden();
            $panelGestionOrdenObject->panelGestionOrdenShow($controlOrdenesActivas, null, null, null);
        } else {
            echo "Error al llamar mesas activas<br>";
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
