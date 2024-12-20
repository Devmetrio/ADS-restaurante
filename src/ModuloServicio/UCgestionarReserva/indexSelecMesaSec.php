<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/selecMesaSec.php');
session_start();

// Verificar autenticación
if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
}
?>