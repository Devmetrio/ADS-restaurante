<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/selecMesaPrin.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Mesa.php');
session_start();

// Verificar autenticación
if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
}
$fechaSeleccionada = $_GET['fecha'] ?? null;
$horaReserva = $_GET['hora'] ?? null;

$mesaObject = new Mesa();
$mesa = $mesaObject->obtenerEstadoMesasHora($fechaSeleccionada,$horaReserva);

$selecMesaPrinObject = new selecMesaPrin();
$selecMesaPrinObject->selecMesaPrinShow($fechaSeleccionada,$horaReserva,$mesa);

?>