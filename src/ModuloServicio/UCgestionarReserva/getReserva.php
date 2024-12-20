<?php
session_start();

// Incluir los archivos necesarios
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/calendarioReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/gestionarReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/formHoraReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/controlReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');

// Variables para manejo de errores
$nombreCampoErroneo = '';
$mensajeError = '';

// Función para validar si se ha enviado el formulario (botón de seleccionar fecha)
function validarBoton($boton)
{
    return isset($boton);
}
// Función para validar la fecha seleccionada
function validarFecha($fechaSeleccionada)
{
    global $nombreCampoErroneo, $mensajeError;
    $today = date('Y-m-d'); // Fecha actual

    // Verificar si la fecha está vacía
    if (empty($fechaSeleccionada)) {
        $nombreCampoErroneo = 'Fecha';
        $mensajeError = 'Este campo no puede estar vacío.';
        return false;
    }
    // Permitir la fecha de hoy
    if ($fechaSeleccionada < $today) {
        $nombreCampoErroneo = 'Fecha';
        $mensajeError = 'La fecha seleccionada no puede ser anterior a la fecha actual.';
        return false;
    }
    return true;
}
function validarFormHora($horaReserva) {
    global $nombreCampoErroneo, $mensajeError;

    // Convertir las horas límite a formato timestamp
    $horaInicio = strtotime("12:00");
    $horaFin = strtotime("20:00");

    // Convertir la hora ingresada a formato timestamp
    $horaIngresada = strtotime($horaReserva);

    // Validar si está dentro del rango permitido
    if ($horaIngresada < $horaInicio || $horaIngresada > $horaFin) {
        $mensajeError = 'Hora no permitida. Debe estar entre las 12:00 y las 20:00.';
        return false;
    }
    return true;
}

// Obtener parámetros desde la URL
$fechaSeleccionada = $_POST['fechaSeleccionada'] ?? null;
$btnSeleccionarFecha = $_POST['btnSeleccionarFecha'] ?? null;
$btnAgregarReserva = $_POST['btnAgregarReserva'] ?? null;
$horaReserva = $_POST['horaReserva'] ?? null;
$cantidadPersonas = $_POST['cantidadPersonas'] ?? null;
$btnHoraCantidad = $_POST['btnHoraCantidad'] ?? null;

if (validarBoton($btnSeleccionarFecha)) {
    if(validarFecha($fechaSeleccionada)){
        header('Location: /src/ModuloServicio/UCgestionarReserva/indexGestionarReserva.php?fecha=' . $fechaSeleccionada);
    } else{
        $calendarioReservaObject = new calendarioReserva();
        $calendarioReservaObject->calendarioReservaShow();

        $viewMensageSistemaObject = new viewMensajeSistema();
        $viewMensageSistemaObject->viewMensajeSistemaShow('error', 'Fecha inválida', $mensajeError);
    } 
} elseif(validarBoton($btnAgregarReserva)){
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexFormHoraReserva.php?fecha=' . $fechaSeleccionada);
} elseif(validarBoton($btnHoraCantidad)){
    if(validarFormHora($horaReserva)){
        $controlReservaObject = new controlReserva();
        $controlReservaObject->verificarHoraCantidad($fechaSeleccionada,$horaReserva,$cantidadPersonas);
    } else{
        $formHoraReservaObject = new formHoraReserva();
        $formHoraReservaObject->formHoraReservaShow($fechaSeleccionada);

        $viewMensageSistemaObject = new viewMensajeSistema();
        $viewMensageSistemaObject->viewMensajeSistemaShow('error', 'Fecha inválida', $mensajeError);
    }
} else {
    $calendarioReservaObject = new calendarioReserva();
    $calendarioReservaObject->calendarioReservaShow();

    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Acceso denegado', 'Error, no se pudo completar la acción');
} 
?>