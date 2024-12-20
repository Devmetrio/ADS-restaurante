<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/ControlOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Orden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/ControlOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Mesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/MesaSecundaria.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/OrdenDetalle.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/panelOrdenes.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/seleccionMesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/modalJuntarMesa.php');
date_default_timezone_set('America/Lima');
class controlPedidos
{
    function mostrarOrdenDetalles($idMesa)
    {
        $idUsuario = $_SESSION['id'];
        $controlOrdenObject = new ControlOrden();
        $controlOrdenes = $controlOrdenObject->obtenerOrdenControlPorUsuario($idUsuario);
        $idControl = $controlOrdenObject->obtenerIdControlPorMesa($idMesa);

        $ordenDetallesObject = new OrdenDetalle();
        $ordenDetalles = $ordenDetallesObject->obtenerOrdenDetalle($idControl);

        $panelOrdenesObject = new panelOrdenes();
        $panelOrdenesObject->panelOrdenesShow($controlOrdenes, $ordenDetalles, $idMesa, $idControl);
    }
    
    function juntarMesas($idMesa)
    {
        $mesaObject = new Mesa();
        $posiblesMesas = $mesaObject->obtenerSecundarias();
        $seleccionMesasObject = new seleccionMesas();

        if ($posiblesMesas != null) {
            $seleccionMesasObject->seleccionMesaShow($idMesa);

            $modalJuntarMesasObject = new modalJuntarMesa();
            $modalJuntarMesasObject->modalJuntarMesaShow($idMesa, $posiblesMesas);
        } else {
            $seleccionMesasObject->seleccionMesaShow($idMesa);
            $viewMensajeSistemaObject = new viewMensajeSistema();
            $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error', 'No se pudo encontrar mesas disponibles para juntar');
        }
    }

    function iniciarControlOrden($idMesa, $idUsuario, $mesasSecundarias = null)
    {
        $fechaActual = date('Y-m-d'); // Formato: 2024-12-08
        $horaActual = date('H:i:s'); // Formato: 14:30:00
        $controlOrdenObject = new ControlOrden();
        $respuesta = $controlOrdenObject->insertarControlOrden($idMesa, $idUsuario, $fechaActual, $horaActual);

        if ($respuesta) {
            $mesaObject = new Mesa();
            $mesaObject->actualizarEstadoSalon($idMesa, 3);

            if ($mesasSecundarias != null) {
                $mesaSecundariaObject = new MesaSecundaria();
                $mesaSecundariaObject->insertarMesasSecundarias($respuesta, $mesasSecundarias);
            }

            header('Location: /src/ModuloServicio/UCgenerarPedidoPlato/indexOrdenMesa.php?idControl=' . $respuesta . '&idMesa=' . $idMesa . '&mesasSecundarias=' . $mesasSecundarias);
        } else {
            $panelOrdenesObject = new panelOrdenes();
            $panelOrdenesObject->panelOrdenesShow();

            $viewMensajeSistemaObject = new viewMensajeSistema();
            $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error', 'No se pudo iniciar la orden', '/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
        }
    }

    function enviarOrden($comanda, $idControlOrden, $idMesa)
    {
        $horaActual = date('H:i:s');
        $controlOrdenObject = new ControlOrden();
        $idOrden = $controlOrdenObject->verificarOrden($idControlOrden);

        if ($idOrden == null) {
            $ordenObject = new Orden();
            $idOrden = $ordenObject->crearOrden($horaActual);

            $controlOrdenObject->actualizarOrden($idOrden, $idControlOrden);
        } else {
            $ordenObject = new Orden();
            $ordenObject->actualizarOrden($idOrden, $horaActual);
        }

        $ordenDetalleObject = new OrdenDetalle();
        $respuesta = $ordenDetalleObject->insertarOrdenDetalle($comanda, $idOrden);

        if ($respuesta != null) {
            $panelOrdenesObject = new panelOrdenes();
            $panelOrdenesObject->panelOrdenesShow();

            $viewMensajeSistemaObject = new viewMensajeSistema();
            $viewMensajeSistemaObject->viewMensajeSistemaShow('success', 'Mensaje', '¡Se mando envió la orden a produccion!', '/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
        } else {
            $panelOrdenesObject = new panelOrdenes();
            $panelOrdenesObject->panelOrdenesShow();

            $viewMensajeSistemaObject = new viewMensajeSistema();
            $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error', 'Hubo un error al momento de mandar la orden', '/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
        }
    }
}
