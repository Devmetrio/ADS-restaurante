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
$idUsuario = $_SESSION['id'];
$idControl = null;

$controlOrdenObject = new ControlOrden();
$controlOrdenes = $controlOrdenObject->obtenerOrdenControlPorUsuario($idUsuario);
$arrayMesaSec = null;
if($idMesa!= null){
    $ordenDetallesObject = new OrdenDetalle();
    $ordenDetalles = $ordenDetallesObject->obtenerOrdenDetalle($idMesa);

    $idControl = $controlOrdenObject->obtenerIdControlPorMesa($idMesa);
}

$panelOrdenesObject = new panelOrdenes();
$panelOrdenesObject->panelOrdenesShow($controlOrdenes, $ordenDetalles, $idMesa, $idControl, $arrayMesaSec);
?>