<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/controlPedidos.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/seleccionMesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/panelNumerico.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/ordenMesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeValidacion.php');

// Declaracion de funciones
function validarBoton($boton)
{
  return isset($boton);
}

function validarAccion($accion)
{
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
  if ($campo !== 0) {
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
$btnCancelarSelec = $_POST['btnCancelarSelec'] ?? null;
$btnIniciarOrden = $_POST['btnIniciar'] ?? null;
$btnEnviar = $_POST['btnEnviar'] ?? null;
$btnOK = $_GET['btnOK'] ?? null;
$accion = $_GET['opcion'] ?? null;

// Flujo principal
if (validarBoton($btnOrdenMesa)) {
  redirigirIndexPanelOrdenes();
} elseif (validarBoton($btnMesaEnviada)) {
  $idMesaEnviada = $_POST['idMesa'];
  $valorMesa = $_POST['btnMesaEnviada'];
  $capacidadMesa = $_POST['capacidad'];
  if ($valorMesa == 0) {
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
    $cantidadIngresada = $_GET['cantidad'];
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
} elseif (validarAccion($accion)) {
  $idMesa = $_GET['idMesa'];
  if ($accion == "aceptar") {
    redirigirIndexSeleccionMesas($idMesa);
  } else {
    $seleccionMesasObject = new seleccionMesas();
    $seleccionMesasObject->seleccionMesaShow();
  }
} elseif(validarBoton($btnCancelarSelec)){
  header('Location: /src/ModuloServicio/UCgenerarPedidoPlato/indexSeleccionMesas.php');
} elseif (validarBoton($btnIniciarOrden)) {
  $idUsuario = $_SESSION['id'];
  $idMesa = $_POST['idMesa'];
  $controlPedidosObject = new controlPedidos();
  $controlPedidosObject->iniciarControlOrden($idMesa, $idUsuario);
} elseif (validarBoton($btnEnviar)) {
  $idControl = $_POST['idControl'];
  $idMesa = $_POST['idMesa'];
  $comanda = $_POST['comanda'];
  $comandaArray = json_decode($comanda, true);

  // Verificar si la comanda está vacía
  if (empty($comandaArray)) {
    $ordenMesaObject = new ordenMesa();
    $ordenMesaObject->ordenMesaShow();

    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error', 'La lista de la orden esta vacia, ingrese platos a la orden', '/src/ModuloServicio/UCgenerarPedidoPlato/indexOrdenMesa.php');
  } else {
    $controlPedidosObject = new controlPedidos();
    $controlPedidosObject->enviarOrden($comanda, $idControl, $idMesa);
  }
} else {
  $seleccionMesasObject = new seleccionMesas();
  $seleccionMesasObject->seleccionMesaShow();

  $viewMensajeSistemaObject = new viewMensajeSistema();
  $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error', 'No se puede concretar la accion', '/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
}
?>