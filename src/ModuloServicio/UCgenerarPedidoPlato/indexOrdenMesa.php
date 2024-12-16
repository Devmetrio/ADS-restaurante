<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/ordenMesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Categoria.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/MenuItem.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/OrdenDetalle.php');


$NumeroCategoria = $_GET['categoria'] ?? null;
$idControl = $_GET['idControl'] ?? null;
$idMesa = $_GET['idMesa'] ?? null;
$idOrden = $_GET['orden'] ?? null;
$menu = null;
$ordenArray = null;

if ($NumeroCategoria != null) {
    $menuItemsObject = new MenuItem();
    $menu = $menuItemsObject->obtenerMenu($NumeroCategoria);
}

if ($idOrden != null) {
    $ordenObject = new OrdenDetalle();
    $ordenArray = $ordenObject->obtenerOrdenPorId($idOrden);
}

$categoriaObject = new Categoria();
$categoria = $categoriaObject->obtenerCategoria();

$ordenMesaObject = new ordenMesa();
$ordenMesaObject->ordenMesaShow($categoria, $menu, $idControl, $idMesa, $ordenArray, $idOrden);
