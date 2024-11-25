<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ModuloAdministracion/UCgestionarMesas/panelGestionarMesas.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelo/Mesa.php');
session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}
$mesasObject = new Mesa();
$mesas = $mesasObject->obtenerMesas(); 

$panelMesasObject = new panelGestionarMesas();
$panelMesasObject->gestionarMesasShow($mesas);