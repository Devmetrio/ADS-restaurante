<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/ordenMesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Categoria.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/MenuItem.php');




$NumeroCategoria = $_GET['categoria'] ?? null;
$idControl = $_GET['idControl'] ?? null;
$idMesa = $_GET['idMesa'] ?? null;
$menu = null;

if ($NumeroCategoria != null) {
    $menuItemsObject = new MenuItem();
    $menu = $menuItemsObject->obtenerMenu($NumeroCategoria);
}

$categoriaObject = new Categoria();
$categoria = $categoriaObject->obtenerCategoria();

$ordenMesaObject = new ordenMesa();
$ordenMesaObject->ordenMesaShow($idMesa, $categoria, $menu, $idControl);