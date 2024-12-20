<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/ControlOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Factura.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/panelCobros.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/formComprobantePago.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/panelGestionOrden.php');
class controlComprobante
{
    public function desactivarEstadoControlOrden($idMesa, $idControlOrden, $login, $total)
    {
        $controlOrdenObject = new ControlOrden();
        $controlOrdenDesactivado = $controlOrdenObject->actualizarEstadoControlOrdenPorMesa($idMesa, 0);
        echo "idControlOrden recibido: " . htmlspecialchars($_POST['idControlOrden']);
        if ($controlOrdenDesactivado) {
            echo "Estado desactivado correctamente<br>";
            $formComprobantePagoObject = new formComprobantePago();
            // Incluye $total en la llamada
            $formComprobantePagoObject->formComprobantePagoShow($idMesa, $idControlOrden, $login, $total);
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
        echo "Ejecutando query para traer mesas faltas de pago<br>";
        $controlOrdenObject = new ControlOrden();
        $controlOrdenFaltosPago = $controlOrdenObject->obtenerOrdenControlFaltosPago();
    
        $panelCobrosObject = new panelCobros();
        $panelCobrosObject->panelCobrosShow($controlOrdenFaltosPago);
    }

    public function insertarDatosEnFactura($idControlOrden, $ruc, $razonsocial, $total)
    {
        echo "ejecutando insert a factura<br>";
        $facturaObject = new Factura();
        $facturaObject->insertarFacturaDatos($idControlOrden, $ruc, $razonsocial, $total);

        if ($facturaObject) {
            echo "Se insertó correctamente<br>";
            $controlComprobanteObject = new controlComprobante();
            $controlComprobanteObject->obtenerComprobantesFaltosPago();
        } else {
            echo "Error al insertar<br>";
        }
    }
}
