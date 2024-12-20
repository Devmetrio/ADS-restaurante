<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/formHoraReserva.php');
session_start();

// Verificar autenticación
if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
}
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;

$formHoraReservaObject = new formHoraReserva();
$formHoraReservaObject->formHoraReservaShow($fecha);
?>