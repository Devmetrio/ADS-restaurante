<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');

function validarBoton($boton)
{
  return isset($boton);
}

function redirigirIndexPanelOrdenes()
{
  header('Location: /src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php?idMesa=' . $_POST['btnMesa']);
}

$btnMesa = $_POST['btnMesa'];

if(validarBoton($btnMesa)){
    redirigirIndexPanelOrdenes();
} else{
    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('error','Erorr', 'No se puede concretar la accion', '/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
}

?>