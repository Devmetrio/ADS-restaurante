<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Reserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarIngresoClientes/verDetallesReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/gestionarReserva.php');
class controlGestionarIngreso
{
    public function confirmarLlegadaReserva($idReserva)
{
    $reservaObject = new Reserva();
    $reservaObject->actualizarEstadoPorReserva($idReserva);
    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('success', 'Confirmación', 'El estado de la reserva ha sido cambiado a "Realizado".', '/src/ModuloServicio/UCgestionarReserva/indexGestionarReserva.php'
    );

    // Redirigir de vuelta al panel de reservas
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexGestionarReserva.php');
    exit();
}

public function cambiarEstadoMesa($idMesa, $nuevoEstado) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Mesa.php');

    $mesaObject = new Mesa();
    $mesaObject->actualizarEstadoSalon($idMesa, $nuevoEstado);

    // Opcional: Añade un mensaje de éxito si usas una vista de notificación
    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('success', 'Estado actualizado', 'El estado de la mesa se cambió correctamente.', '/src/ModuloServicio/UCgestionarIngresoClientes/indexSeleccionarMesa.php');
    

}

public function cambiarEstadoLibreAOcupado($idMesa)
{
    include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Mesa.php');
    
    $mesaObject = new Mesa();
    $resultado = $mesaObject->cambiarEstadoLibreAOcupado($idMesa);

    if ($resultado) {
        // Mensaje de éxito
        $seleccionarMesasObject = new seleccionarMesa();
        $seleccionarMesasObject->panelseleccionarMesaShow();
        $viewMensajeSistemaObject = new viewMensajeSistema();
        $viewMensajeSistemaObject->viewMensajeSistemaShow('success', 'Estado actualizado', 'La mesa ahora está ocupada.', '/src/ModuloServicio/UCgestionarIngresoClientes/indexSeleccionarMesa.php');
    } else {
        // Mensaje de error
        $seleccionarMesasObject = new seleccionarMesa();
        $seleccionarMesasObject->panelseleccionarMesaShow();
        $viewMensajeSistemaObject = new viewMensajeSistema();
        $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Acción no permitida', 'El estado de la mesa no permite este cambio.', '/src/ModuloServicio/UCgestionarIngresoClientes/indexSeleccionarMesa.php');
    }
}



}