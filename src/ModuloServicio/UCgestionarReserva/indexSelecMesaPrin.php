<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/selecMesaPrin.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/selecMesaSec.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Mesa.php');
session_start();

// Verificar autenticación
if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
}
$fechaSeleccionada = $_GET['fecha'] ?? null;
$horaReserva = $_GET['hora'] ?? null;
$idMesaSeleccionada = !empty($_GET['mesaPrin']) && is_numeric($_GET['mesaPrin']) ? $_GET['mesaPrin'] : null;
$mesasSecundariasSeleccionadas = isset($_GET['mesasSecundarias']) ? explode(',', $_GET['mesasSecundarias']) : [];

$mesaObject = new Mesa();
$mesa = $mesaObject->obtenerEstadoMesasHora($fechaSeleccionada,$horaReserva);

$selecMesaPrinObject = new selecMesaPrin();
$selecMesaPrinObject->selecMesaPrinShow($fechaSeleccionada, $horaReserva, $mesa, $idMesaSeleccionada, $mesasSecundariasSeleccionadas);

if (isset($_GET['mostrarMesasSecundarias']) && $_GET['mostrarMesasSecundarias'] === 'true') {
    $mesasSecundariasDisponibles = $mesaObject->obtenerMesasSecundariasHora($fechaSeleccionada, $horaReserva, $idMesaSeleccionada);
    $selecMesaSecObject = new selecMesaSec();
    $selecMesaSecObject->selecMesaSecShow($fechaSeleccionada, $horaReserva, $idMesaSeleccionada, $mesasSecundariasDisponibles);
}

?><?php
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