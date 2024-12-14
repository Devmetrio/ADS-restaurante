<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/panelOrdenes.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/ControlOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/OrdenDetalle.php');
session_start();

if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
  }
 
$idMesa = $_GET['idMesa'] ?? null;
$ordenDetalles = null;

$controlOrdenObject = new ControlOrden();
$controlOrdenes = $controlOrdenObject->obtenerOrdenControl();

if($idMesa!= null){
    $ordenDetallesObject = new OrdenDetalle();
    $ordenDetalles = $ordenDetallesObject->obtenerOrdenDetalle($idMesa);
}

$panelOrdenesObject = new panelOrdenes();
$panelOrdenesObject->panelOrdenesShow($controlOrdenes, $ordenDetalles, $idMesa);
?>