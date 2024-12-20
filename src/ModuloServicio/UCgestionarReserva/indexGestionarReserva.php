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
