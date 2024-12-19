<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/panelGestionOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/ControlOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/OrdenDetalle.php');
session_start();

if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
  }

$idMesa = $_GET['idMesa'] ?? null;
$ordenDetalles = null;
$idControl = null;

$controlOrdenObject = new ControlOrden();
$controlOrdenes = $controlOrdenObject->obtenerOrdenControlActivas();

if($idMesa!= null){
    $ordenDetallesObject = new OrdenDetalle();
    $ordenDetalles = $ordenDetallesObject->obtenerOrdenDetalle($idMesa);

    $idControl = $controlOrdenObject->obtenerIdControlPorMesa($idMesa);
}

$panelGestionOrdenObject = new panelGestionOrden();
$panelGestionOrdenObject->panelGestionOrdenShow($controlOrdenes, $ordenDetalles, $idMesa, $idControl);
?>