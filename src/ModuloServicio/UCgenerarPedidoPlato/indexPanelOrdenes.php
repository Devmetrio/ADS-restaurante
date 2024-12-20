<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/panelOrdenes.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/ControlOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/OrdenDetalle.php');
session_start();

if (!isset($_SESSION['autenticado']) || $_SESSION['rol'] !== 'anfitrion de servicio') {
  header('Location: /');
  exit();
}
 
$idUsuario = $_SESSION['id'];


$controlOrdenObject = new ControlOrden();
$controlOrdenes = $controlOrdenObject->obtenerOrdenControlPorUsuario($idUsuario);


$panelOrdenesObject = new panelOrdenes();
$panelOrdenesObject->panelOrdenesShow($controlOrdenes);
?>