<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/calendarioReserva.php');
session_start();

// Verificar autenticación
if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
}

// Instanciar y mostrar el calendario
$calendarioReservaObject = new calendarioReserva();
$calendarioReservaObject->calendarioReservaShow();
?>