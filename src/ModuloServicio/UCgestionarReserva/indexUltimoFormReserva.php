<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/ultimoFormReserva.php');
session_start();

// Verificar autenticación
if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
}

// Obtener datos desde la URL
$fecha = $_GET['fecha'] ?? null;
$hora = $_GET['hora'] ?? null;
$mesaPrincipal = $_GET['mesaPrin'] ?? null;
$mesasSecundarias = $_GET['mesasSecundarias'] ?? '';

// Instanciar y mostrar el formulario final
$ultimoFormReservaObject = new ultimoFormReserva();
$ultimoFormReservaObject->ultimoFormReservaShow($fecha, $hora, $mesaPrincipal, $mesasSecundarias);
?>
