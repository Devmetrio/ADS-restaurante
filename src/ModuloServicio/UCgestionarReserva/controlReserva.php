<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/formHoraReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Mesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Reserva.php');

class controlReserva
{
    public function verificarHoraCantidad($fechaSeleccionada, $horaReserva, $cantidadPersonas){
        $mesaObject = new Mesa();
        $capacidadTotalHora = $mesaObject->capacidadMesaDispo($fechaSeleccionada, $horaReserva);
        if($cantidadPersonas <= $capacidadTotalHora){
            $mesaObject = new Mesa();
            $mesaObject->obtenerEstadoMesasHora($fechaSeleccionada, $horaReserva);
            header('Location: /src/ModuloServicio/UCgestionarReserva/indexSelecMesaPrin.php?fecha=' . urlencode($fechaSeleccionada) . '&hora=' . urlencode($horaReserva));
        } else {
            $formHoraReservaObject = new formHoraReserva();
            $formHoraReservaObject->formHoraReservaShow($fechaSeleccionada);
            
            $viewMensajeSistemaObject = new viewMensajeSistema();
            $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Ocurrió un error', 'No hay suficientes mesas disponibles');
        }
    }

    public function procesarMesasSecundarias($fechaSeleccionada, $horaReserva, $mesaPrincipal, $mesasSecundarias){
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

    public function generarReservaFinal($fecha, $hora, $mesaPrincipal, $mesasSecundarias, $nombreCliente, $celularCliente) {


        $reservaModel = new Reserva();

        // Crear la reserva principal y obtener el ID
        $idReserva = $reservaModel->crearReserva($mesaPrincipal, $fecha, $hora, $nombreCliente, $celularCliente);

        // Si hay mesas secundarias, insertarlas
        if (!empty($mesasSecundarias)) {
            if (is_string($mesasSecundarias)) {
                $mesasSecundarias = explode(',', $mesasSecundarias);
            }
            foreach ($mesasSecundarias as $idMesaSecundaria) {
                $reservaModel->agregarMesaSecundaria($idReserva, $idMesaSecundaria);
            }
        }
        $calendarioReservaObject = new calendarioReserva();
        $calendarioReservaObject->calendarioReservaShow();
        // Mostrar mensaje de éxito
        $viewMensajeSistemaObject = new viewMensajeSistema();
        $viewMensajeSistemaObject->viewMensajeSistemaShow('success', 'Reserva Confirmada', 'La reserva se generó con éxito. Redirigiendo al calendario...');

        // Redirigir al calendario después de 3 segundos
        header('Refresh: 3; URL=/src/ModuloServicio/UCgestionarReserva/indexCalendarioReserva.php');
        exit();
    }
}<?php
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