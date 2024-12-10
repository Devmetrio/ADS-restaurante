<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/ControlOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Orden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Mesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/OrdenDetalle.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/panelOrdenes.php');
date_default_timezone_set('America/Lima');
class controlPedidos
{
    function iniciarControlOrden($idMesa, $idUsuario)
    {

        $fechaActual = date('Y-m-d'); // Formato: 2024-12-08
        $horaActual = date('H:i:s'); // Formato: 14:30:00
        $controlOrdenObject = new ControlOrden();
        $respuesta = $controlOrdenObject->insertarControlOrden($idMesa, $idUsuario, $fechaActual, $horaActual);

        if ($respuesta) {
            header('Location: /src/ModuloServicio/UCgenerarPedidoPlato/indexOrdenMesa.php?idControl=' . $respuesta. '&idMesa='. $idMesa);
        } else {
            $panelOrdenesObject = new panelOrdenes();
            $panelOrdenesObject->panelOrdenesShow();

            $viewMensajeSistemaObject = new viewMensajeSistema();
            $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error', 'No se pudo iniciar la orden', '/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
        }
    }

    function enviarOrden($comanda, $idControlOrden, $idMesa)
    {
        $controlOrdenObject = new ControlOrden();
        $resultado = $controlOrdenObject->verificarOrden($idControlOrden);

        if ($resultado == null) {
            $horaActual = date('H:i:s'); 
            $ordenObject = new Orden();
            $idOrden = $ordenObject->crearOrden($horaActual);

            $controlOrdenObject->actualizarOrden($idOrden, $idControlOrden);
        }

        $ordenDetalleObject = new OrdenDetalle();
        $respuesta = $ordenDetalleObject->insertarOrdenDetalle($comanda, $idControlOrden);

        if ($respuesta != null) {
            $mesaObject = new Mesa();
            $mesaObject->actualizarEstadoSalon($idMesa, 3);

            $panelOrdenesObject = new panelOrdenes();
            $panelOrdenesObject->panelOrdenesShow();

            $viewMensajeSistemaObject = new viewMensajeSistema();
            $viewMensajeSistemaObject->viewMensajeSistemaShow('succes', 'Mensaje', '¡Se mando envió la orden a produccion!', '/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
        } else{
            $panelOrdenesObject = new panelOrdenes();
            $panelOrdenesObject->panelOrdenesShow();

            $viewMensajeSistemaObject = new viewMensajeSistema();
            $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error', 'Hubo un error al momento de mandar la orden', '/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
        }
    }
}
