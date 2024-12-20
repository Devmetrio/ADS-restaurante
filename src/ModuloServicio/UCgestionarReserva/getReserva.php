<?php
session_start();

// Incluir los archivos necesarios
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/calendarioReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/gestionarReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/formHoraReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/controlReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/selecMesaPrin.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/selecMesaSec.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/ultimoFormReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');

// Variables para manejo de errores
$nombreCampoErroneo = '';
$mensajeError = '';

// **Funciones**
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

function validarNombreCliente($nombreCliente)
{
    global $mensajeError;

    if (strlen($nombreCliente) < 6) {
        $mensajeError = 'El nombre debe tener al menos 6 caracteres.';
        return false;
    }
    return true;
}

function validarNumeroCelular($numeroCelular)
{
    global $mensajeError;

    if (!preg_match('/^9\d{8}$/', $numeroCelular)) {
        $mensajeError = 'El número de celular debe tener 9 dígitos y comenzar con 9.';
        return false;
    }
    return true;
}

// Inicializar variables
$idMesaPrincipal = $_POST['idMesaSeleccionada'] ?? $_GET['mesaPrin'] ?? null;
$fechaSeleccionada = $_POST['fechaSeleccionada'] ?? null;
$horaReserva = $_POST['horaReserva'] ?? null;
$btnSeleccionarFecha = $_POST['btnSeleccionarFecha'] ?? null;
$btnAgregarReserva = $_POST['btnAgregarReserva'] ?? null;
$btnHoraCantidad = $_POST['btnHoraCantidad'] ?? null;
$btnMesaPrincipal = $_POST['btnMesaPrincipal'] ?? null;
$btnAgregarMesasSecundarias = $_POST['btnAgregarMesasSecundarias'] ?? null;
$btnConfirmarMesasSecundarias = $_POST['btnConfirmarMesasSecundarias'] ?? null;
$btnUltimoForm = $_POST['btnUltimoForm'] ?? null;
$btnGenerarReserva = $_POST['btnGenerarReserva'] ?? null;
$mesasSecundariasSeleccionadas = $_POST['mesasSecundariasSeleccionadas'] ?? [];

// Verificar y convertir mesasSecundariasSeleccionadas en array si es necesario
if (!is_array($mesasSecundariasSeleccionadas)) {
    $mesasSecundariasSeleccionadas = explode(',', $mesasSecundariasSeleccionadas);
}

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
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexSelecMesaPrin.php?fecha=' . urlencode($fechaSeleccionada) . '&hora=' . urlencode($horaReserva) . '&mesaPrin=' . urlencode($idMesaPrincipal));
    exit();
} elseif (validarBoton($btnAgregarMesasSecundarias)) {
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexSelecMesaPrin.php?fecha=' . urlencode($fechaSeleccionada) . '&hora=' . urlencode($horaReserva) . '&mesaPrin=' . urlencode($idMesaPrincipal) . '&mostrarMesasSecundarias=true');
    exit();
} elseif (validarBoton($btnConfirmarMesasSecundarias)) {
    $controlReservaObject = new controlReserva();
    $controlReservaObject->procesarMesasSecundarias($fechaSeleccionada, $horaReserva, $idMesaPrincipal, $mesasSecundariasSeleccionadas);

    // Redirigir de vuelta a selecMesaPrin
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexSelecMesaPrin.php?fecha=' . urlencode($fechaSeleccionada) .
           '&hora=' . urlencode($horaReserva) .
           '&mesaPrin=' . urlencode($idMesaPrincipal) .
           '&mesasSecundarias=' . urlencode(implode(',', $mesasSecundariasSeleccionadas)));
    exit();
} elseif (validarBoton($btnUltimoForm)) { // Validación de btnUltimoForm
    if ($idMesaPrincipal) {
        $mesasSecundarias = implode(',', $mesasSecundariasSeleccionadas);
        header('Location: /src/ModuloServicio/UCgestionarReserva/indexUltimoFormReserva.php?fecha=' . urlencode($fechaSeleccionada) .
               '&hora=' . urlencode($horaReserva) .
               '&mesaPrin=' . urlencode($idMesaPrincipal) .
               '&mesasSecundarias=' . urlencode($mesasSecundarias));
        exit();
    } else {
        $selecMesaPrinObject = new selecMesaPrin();
        $selecMesaPrinObject->selecMesaPrinShow($fechaSeleccionada, $horaReserva, $mesa, $idMesaPrincipal, $mesasSecundariasSeleccionadas);
        $viewMensajeSistemaObject = new viewMensajeSistema();
        $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Selección incompleta', 'Debe seleccionar una mesa principal antes de continuar.');
    }
} elseif (validarBoton($btnGenerarReserva)) {
    $fecha = $_POST['fecha'] ?? null;
    $hora = $_POST['hora'] ?? null;
    $mesaPrincipal = $_POST['mesaPrincipal'] ?? null;
    $mesasSecundariasSeleccionadas = $_POST['mesasSecundariasSeleccionadas'] ?? null;
    $cliente = $_POST['cliente'] ?? null;
    $celular = $_POST['celular'] ?? null;
    
    if (validarNombreCliente($cliente) && validarNumeroCelular($celular)) {
        $controlReservaObject = new controlReserva();
        $controlReservaObject->generarReservaFinal(
            $fecha,
            $hora,
            $mesaPrincipal,
            $mesasSecundariasSeleccionadas,
            $cliente,
            $celular
        );

    } else {
        // Mostrar error si hay datos faltantes
        $mensajeError = 'Por favor, complete todos los campos correctamente.';
        $ultimoFormReservaObject = new ultimoFormReserva();
        $ultimoFormReservaObject->ultimoFormReservaShow(
            $fechaSeleccionada,
            $horaReserva,
            $idMesaPrincipal,
            explode(',', $mesasSecundariasSeleccionadas)    
        );

        $viewMensajeSistemaObject = new viewMensajeSistema();
        $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error en la reserva', $mensajeError);
    }
} else {
    $calendarioReservaObject = new calendarioReserva();
    $calendarioReservaObject->calendarioReservaShow();

    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Acceso denegado', 'Error, no se pudo completar la acción');
}
?>
