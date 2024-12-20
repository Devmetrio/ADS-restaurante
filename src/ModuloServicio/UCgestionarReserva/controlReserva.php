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
    
    public function procesarMesasSecundarias($fechaSeleccionada, $horaReserva, $mesaPrincipal, $mesasSecundarias)
{
    // Convertir en un arreglo si es una cadena
    if (is_string($mesasSecundarias)) {
        $mesasSecundarias = explode(',', $mesasSecundarias);
    }

    // Validar que sea un arreglo antes de usar implode
    if (is_array($mesasSecundarias)) {
        $mesasSecundariasString = implode(',', $mesasSecundarias);
    } else {
        $mesasSecundariasString = ''; // O manejar el caso de error aquí
    }

    // Redirigir de vuelta a selecMesaPrin con las mesas seleccionadas
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexSelecMesaPrin.php?fecha=' . urlencode($fechaSeleccionada) .
           '&hora=' . urlencode($horaReserva) .
           '&mesaPrin=' . urlencode($mesaPrincipal) .
           '&mesasSecundarias=' . urlencode($mesasSecundariasString));
    exit();
}
    
}
?>