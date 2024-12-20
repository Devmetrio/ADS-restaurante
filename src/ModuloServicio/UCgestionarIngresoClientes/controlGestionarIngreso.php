<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Reserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarIngresoClientes/verDetallesReserva.php');
class controlGestionarIngreso
{
    public function confirmarLlegadaReserva($idReserva)
{
    $reservaObject = new Reserva();
    $reservaObject->actualizarEstadoPorReserva($idReserva);

    // Mensaje de confirmación
    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow(
        'success',
        'Confirmación',
        'El estado de la reserva ha sido cambiado a "Realizado".'
    );

    // Redirigir de vuelta al panel de reservas
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexGestionarReserva.php');
    exit();
}

}

