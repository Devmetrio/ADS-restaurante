<?php
include_once('C:/xampp/htdocs/src/modelo/Reserva.php');
include_once('C:/xampp/htdocs/src/ModuloServicio/UCgestionarIngresoClientes/verDetallesReserva.php');

session_start();

if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
}

// Capturar el ID de la reserva de la URL
$idReserva = $_GET['idReserva'] ?? null;

if (!$idReserva) {
    echo "Error: No se proporcionó un ID de reserva.";
    exit();
}

// Instanciar el objeto Reserva
$reservaObject = new Reserva();

// Obtener los detalles de la reserva
$detallesReserva = $reservaObject->obtenerDetalleReserva($idReserva);

if (!$detallesReserva) {
    echo "Error: No se encontró una reserva con el ID especificado.";
    exit();
}

// Instanciar y renderizar la vista
$verDetallesReservaObject = new verDetallesReserva();
$verDetallesReservaObject->mostrarDetalles($detallesReserva);
?>
