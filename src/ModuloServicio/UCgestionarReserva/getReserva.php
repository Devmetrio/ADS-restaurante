<?php
session_start();

// Incluir los archivos necesarios
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/calendarioReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/gestionarReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/formHoraReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/controlReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/selecMesaPrin.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/selecMesaSec.php');
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

function validarFormHora($horaReserva)
{
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

// Obtener parámetros desde la URL o POST
$fechaSeleccionada = $_POST['fechaSeleccionada'] ?? null;
$btnSeleccionarFecha = $_POST['btnSeleccionarFecha'] ?? null;
$btnAgregarReserva = $_POST['btnAgregarReserva'] ?? null;
$horaReserva = $_POST['horaReserva'] ?? null;
$cantidadPersonas = $_POST['cantidadPersonas'] ?? null;
$btnHoraCantidad = $_POST['btnHoraCantidad'] ?? null;
$btnMesaPrincipal = $_POST['btnMesaPrincipal'] ?? null;
$btnAgregarMesasSecundarias = $_POST['btnAgregarMesasSecundarias'] ?? null;
$btnConfirmarMesasSecundarias = $_POST['btnConfirmarMesasSecundarias'] ?? null;
$mesasSecundariasSeleccionadas = $_POST['mesasSecundariasSeleccionadas'] ?? [];
$noMesasSecundarias = $_POST['noMesasSecundarias'] ?? null;

// Instanciar el modelo Mesa y obtener el estado de las mesas
if ($fechaSeleccionada && $horaReserva) {
    $mesaObject = new Mesa();
    $mesa = $mesaObject->obtenerEstadoMesasHora($fechaSeleccionada, $horaReserva);
} else {
    $mesa = null; // Si no hay fecha u hora, inicializa $mesa como null
}

// Validación de acciones
if (validarBoton($btnSeleccionarFecha)) {
    if (validarFecha($fechaSeleccionada)) {
        header('Location: /src/ModuloServicio/UCgestionarReserva/indexGestionarReserva.php?fecha=' . $fechaSeleccionada);
    } else {
        $calendarioReservaObject = new calendarioReserva();
        $calendarioReservaObject->calendarioReservaShow();

        $viewMensageSistemaObject = new viewMensajeSistema();
        $viewMensageSistemaObject->viewMensajeSistemaShow('error', 'Fecha inválida', $mensajeError);
    }
} elseif (validarBoton($btnAgregarReserva)) {
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexFormHoraReserva.php?fecha=' . $fechaSeleccionada);
} elseif (validarBoton($btnHoraCantidad)) {
    if (validarFormHora($horaReserva)) {
        $controlReservaObject = new controlReserva();
        $controlReservaObject->verificarHoraCantidad($fechaSeleccionada, $horaReserva, $cantidadPersonas);
    } else {
        $formHoraReservaObject = new formHoraReserva();
        $formHoraReservaObject->formHoraReservaShow($fechaSeleccionada);

        $viewMensageSistemaObject = new viewMensajeSistema();
        $viewMensageSistemaObject->viewMensajeSistemaShow('error', 'Fecha inválida', $mensajeError);
    }
} elseif (validarBoton($btnMesaPrincipal)) {
    $idMesaPrincipal = $_POST['idMesaSeleccionada'];
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexSelecMesaPrin.php?fecha=' . urlencode($fechaSeleccionada) . '&hora=' . urlencode($horaReserva) . '&mesaPrin=' . urlencode($idMesaPrincipal));
    exit();
} elseif (validarBoton($btnAgregarMesasSecundarias)) {
    $idMesaPrincipal = $_POST['mesaPrincipal'];
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexSelecMesaPrin.php?fecha=' . urlencode($fechaSeleccionada) . '&hora=' . urlencode($horaReserva) . '&mesaPrin=' . urlencode($idMesaPrincipal) . '&mostrarMesasSecundarias=true');
    exit();
} elseif (validarBoton($btnConfirmarMesasSecundarias)) {
    $idMesaPrincipal = $_POST['mesaPrincipal'];
    $controlReservaObject = new controlReserva();
    $controlReservaObject->procesarMesasSecundarias($fechaSeleccionada, $horaReserva, $idMesaPrincipal, $mesasSecundariasSeleccionadas);

    // Redirigir de vuelta a selecMesaPrin
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexSelecMesaPrin.php?fecha=' . urlencode($fechaSeleccionada) . '&hora=' . urlencode($horaReserva) . '&mesaPrin=' . urlencode($idMesaPrincipal));
    exit();
} else {
    $calendarioReservaObject = new calendarioReserva();
    $calendarioReservaObject->calendarioReservaShow();

    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Acceso denegado', 'Error, no se pudo completar la acción');
}
?>
