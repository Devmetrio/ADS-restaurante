<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/formHoraReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Mesa.php');
class controlReserva
{
    public function verificarHoraCantidad($fechaSeleccionada,$horaReserva,$cantidadPersonas){
        $mesaObject = new Mesa();
        $capacidadTotalHora = $mesaObject->capacidadMesaDispo($fechaSeleccionada, $horaReserva);
        if($cantidadPersonas<=$capacidadTotalHora){
            $mesaObject = new Mesa();
            $mesaObject->obtenerEstadoMesasHora($fechaSeleccionada,$horaReserva);
            header('Location: /src/ModuloServicio/UCgestionarReserva/indexSelecMesaPrin.php?fecha=' . urlencode($fechaSeleccionada) . '&hora=' . urlencode($horaReserva));
        } else {
            $formHoraReservaObject = new formHoraReserva();
            $formHoraReservaObject->formHoraReservaShow($fechaSeleccionada);
            
            $viewMensajeSistemaObject = new viewMensajeSistema();
            $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Ocurrió un error', 'No hay suficientes mesas disponibles');
        }
    }
}
?>