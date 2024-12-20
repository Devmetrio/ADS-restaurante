<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/gestionarReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Reserva.php');
session_start();

// Verificar autenticación
if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
}

// Obtener la fecha desde la URL
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;

if ($fecha) {
    // Obtener las reservas para la fecha seleccionada
    $reservaArraysObject = new Reserva();
    $reservaPorFecha = $reservaArraysObject->obtenerReservasPorEstadoYFecha($fecha, 'En curso');
}

// Instanciar y mostrar el gestionar reserva
$gestionarReservaObject = new gestionarReserva();
$gestionarReservaObject->gestionarReservaShow($reservaPorFecha, $fecha);
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/gestionarReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Reserva.php');
session_start();

// Verificar autenticación
if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
}

date_default_timezone_set('America/Lima');

// Obtener la fecha desde la URL
$fecha = $_GET['fecha'] ?? date('Y-m-d');

// Obtener las reservas del día
if ($fecha) {
    $reservaArraysObject = new Reserva();
    $reservaPorFecha = $reservaArraysObject->obtenerReservasPorEstadoYFecha($fecha, 'En curso');

    // Guardar solo reservas en estado "En curso" en la sesión
    if ($reservaPorFecha instanceof mysqli_result) {
        $_SESSION['reservasDelDia'] = array_filter($reservaPorFecha->fetch_all(MYSQLI_ASSOC), function ($reserva) {
            return $reserva['NombreEstado'] === 'En curso';
        });
    } else {
        $_SESSION['reservasDelDia'] = [];
    }
}

// Obtener resultados de búsqueda
$resultadoBusqueda = null;
if (isset($_SESSION['resultadoBusqueda'])) {
    $resultadoBusqueda = array_filter($_SESSION['resultadoBusqueda'], function ($reserva) {
        return $reserva['NombreEstado'] === 'En curso';
    });
    unset($_SESSION['resultadoBusqueda']); // Limpiar después de usar
}

// Pasar siempre un array al gestionarReservaShow
$datosMostrar = $resultadoBusqueda ?? $_SESSION['reservasDelDia'];

// Instanciar y mostrar el gestionar reserva
$gestionarReservaObject = new gestionarReserva();
$gestionarReservaObject->gestionarReservaShow($datosMostrar, $fecha);
?>
