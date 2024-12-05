<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/seleccionMesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/panelNumerico.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeValidacion.php');

// Declaracion de funciones
function validarBoton($boton)
{
  return isset($boton);
}

function validarAccion($accion){
  return isset($accion);
}

function redirigirIndexSeleccionMesas($id)
{
  header('Location: /src/ModuloServicio/UCgenerarPedidoPlato/indexSeleccionMesas.php?idMesa=' . $id);
}

function redirigirIndexPanelOrdenes()
{
  header('Location: /src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php?idMesa=' .  $_POST['btnOrdenMesa']);
}

function validarCampos($campo)
{
  if($campo !== 0){
    return true;
  } 
  return false;
}

function validarCantPersonas($cantidad, $capacidad)
{
  if ($cantidad <= $capacidad) {
    return true;
  }
  return false;
}

// Declaracion de variables 
$btnOrdenMesa = $_POST['btnOrdenMesa'] ?? null;
$btnMesaEnviada = $_POST['btnMesaEnviada'] ?? null;
$btnIniciarOrden = $_POST['btnIniciar'] ?? null;
$btnOK = $_GET['cantidad'] ?? null;
$accion = $_GET['opcion'] ?? null;

// Flujo principal
if (validarBoton($btnOrdenMesa)) {
  redirigirIndexPanelOrdenes();
} elseif (validarBoton($btnMesaEnviada)) {
  $idMesaEnviada = $_POST['idMesa'];
  $capacidadMesa = $_POST['capacidad'];
  if ($idMesaEnviada == 0) {
    $seleccionMesasObject = new seleccionMesas();
    $seleccionMesasObject->seleccionMesaShow();

    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Accion no permitida', 'Escoja un mesa en espera');
  } else {
    $seleccionMesasObject = new seleccionMesas();
    $seleccionMesasObject->seleccionMesaShow();

    $panelNumericoObject = new panelNumerico();
    $panelNumericoObject->panelNumericoShow($capacidadMesa, $idMesaEnviada);
  }
} elseif ($btnOK) {
  if (validarCampos($btnOK)) {
    $cantidadIngresada = intval($btnOK);
    $capacidadMesa = $_GET['capacidadMesa'];
    $idMesa = $_GET['id'];

    if (validarCantPersonas($cantidadIngresada, $capacidadMesa)) {
      redirigirIndexSeleccionMesas($idMesa);
    } else {
      $seleccionMesasObject = new seleccionMesas();
      $seleccionMesasObject->seleccionMesaShow();

      $viewMensajeValidacionObject = new viewMensajeValidacion();
      $viewMensajeValidacionObject->viewMensajeValidacionShow('info', 'Alerta', 'Se ha sobrepasado la capacidad de la mesa', $idMesa);
    }
  } else {
    $seleccionMesasObject = new seleccionMesas();
    $seleccionMesasObject->seleccionMesaShow();

    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Accion no permitida', 'Ingrese una cantidad valida de personas');
  }
} elseif(validarAccion($accion)){
  $idMesa = $_GET['idMesa'];
  if($accion=="aceptar"){
    redirigirIndexSeleccionMesas($idMesa);
  } else{
    $seleccionMesasObject = new seleccionMesas();
    $seleccionMesasObject->seleccionMesaShow();
  }
} elseif (validarBoton($btnIniciarOrden)){
  $controlPedidosObject = new controlPedidos();
} else {
  $seleccionMesasObject = new seleccionMesas();
  $seleccionMesasObject->seleccionMesaShow();


  $viewMensajeSistemaObject = new viewMensajeSistema();
  $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error', 'No se puede concretar la accion', '/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
}
