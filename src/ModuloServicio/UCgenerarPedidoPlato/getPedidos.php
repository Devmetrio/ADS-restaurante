<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/controlPedidos.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/seleccionMesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/panelNumerico.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/ordenMesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarPedidoPlato/modalJuntarMesa.php');
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

function redirigirIndexSeleccionMesas($id, $mesasSeleccionadas = [])
{
    // Construir la URL base
    $url = '/src/ModuloServicio/UCgenerarPedidoPlato/indexSeleccionMesas.php?idMesa=' . $id;

    // Agregar mesas secundarias si existen
    if (!empty($mesasSeleccionadas) && is_array($mesasSeleccionadas)) {
        $mesasQuery = implode(',', $mesasSeleccionadas);
        $url .= '&mesasSecundarias=' . $mesasQuery;
    }

    // Redirigir
    header('Location: ' . $url);
    exit;
}

function redirigirIndexPanelOrdenes()
{
  header('Location: /src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php?idMesa=' .  $_POST['btnOrdenMesa']);
}

function validarCampos($campo)
{
  if ($campo == 0) {
    return false;
  }
  return true;
}

function validarCantPersonas($cantidad, $capacidad)
{
  if ($cantidad <= $capacidad) {
    return true;
  }
  return false;
}

function validarMesaSeleccionada($idMesa) {
  if ($idMesa ==0){
    return true;
  }
  return false;
}

function validarMesasSeleccionadas($mesa1, $mesa2, $mesa3) {
  // Retorna true si al menos uno de los valores no está vacío
  return !empty($mesa1) || !empty($mesa2) || !empty($mesa3);
}

// Declaracion de variables 
$btnOrdenMesa = $_POST['btnOrdenMesa'] ?? null;
$btnSeleccionarMesa = $_POST['btnSeleccionarMesa'] ?? null;
$btnMesaEnviada = $_POST['btnMesaEnviada'] ?? null;
$btnCancelarSelec = $_POST['btnCancelarSelec'] ?? null;
$btnJuntarMesas = $_POST['btnJuntarMesas'] ?? null;
$btnIniciarOrden = $_POST['btnIniciar'] ?? null;
$btnEnviar = $_POST['btnEnviar'] ?? null;
$btnOK = $_GET['btnOK'] ?? null;
$btnAceptarJuntar = $_POST['btnAceptarJuntar'] ?? null;
$accion = $_GET['opcion'] ?? null;

// Flujo principal
if (validarBoton($btnOrdenMesa)) {
  $idMesa = $_POST['idMesa'];
  $controlPedidosObject = new controlPedidos();
  $controlPedidosObject->mostrarOrdenDetalles($idMesa);
} elseif(validarBoton($btnSeleccionarMesa)) {
  header('Location: /src/ModuloServicio/UCgenerarPedidoPlato/indexSeleccionMesas.php');
} elseif (validarBoton($btnMesaEnviada)) {
  $idMesaEnviada = $_POST['idMesa'];
  $valorMesa = $_POST['btnMesaEnviada'];
  $capacidadMesa = $_POST['capacidad'];

  if (validarMesaSeleccionada($valorMesa)) {
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
  $cantidadIngresada = $_GET['cantidad'];
  $capacidadMesa = $_GET['capacidadMesa'];
  $idMesa = $_GET['id'];

  if (validarCampos($cantidadIngresada)) {
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
} elseif (validarBoton($btnCancelarSelec)) {
  header('Location: /src/ModuloServicio/UCgenerarPedidoPlato/indexSeleccionMesas.php');
} elseif (validarBoton($btnJuntarMesas)) {
  $idMesa = $_POST['idMesa'];
  $controlPedidosObject = new controlPedidos();
  $controlPedidosObject->juntarMesas($idMesa);
} elseif(validarBoton($btnAceptarJuntar)){
  $mesaSecundaria1 = $_POST['mesaSecundaria1'];
  $mesaSecundaria2 = $_POST['mesaSecundaria2'];
  $mesaSecundaria3 = $_POST['mesaSecundaria3'];

  if (validarMesasSeleccionadas($mesaSecundaria1, $mesaSecundaria2, $mesaSecundaria3)) {
    $mesaPrincipal = $_POST['mesaPrincipal'];
    $mesasSeleccionadas = [];
    if (!empty($mesaSecundaria1)) {
        $mesasSeleccionadas[] = $mesaSecundaria1;
    }
    if (!empty($mesaSecundaria2)) {
        $mesasSeleccionadas[] = $mesaSecundaria2;
    }
    if (!empty($mesaSecundaria3)) {
        $mesasSeleccionadas[] = $mesaSecundaria3;
    }

    redirigirIndexSeleccionMesas($mesaPrincipal, $mesasSeleccionadas);
  } else{
    $seleccionMesasObject = new seleccionMesas();
    $seleccionMesasObject->seleccionMesaShow();
  
    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error', '!Ingrese mesas secundarias!');
  }

} elseif (validarBoton($btnIniciarOrden)) {
  $idUsuario = $_SESSION['id'];
  $idMesa = $_POST['idMesa'];
  $mesasSecundarias = $_POST['mesasSecundarias'];
  $controlPedidosObject = new controlPedidos();
  $controlPedidosObject->iniciarControlOrden($idMesa, $idUsuario, $mesasSecundarias);
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
    $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error', 'La lista de la orden esta vacia, ingrese platos a la orden', '/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
  } else {
    $controlPedidosObject = new controlPedidos();
    $controlPedidosObject->enviarOrden($comanda, $idControl, $idMesa);
  }
} else {
  $panelOrdenesObject = new panelOrdenes();
  $panelOrdenesObject->panelOrdenesShow();

  $viewMensajeSistemaObject = new viewMensajeSistema();
  $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error', 'No se puede concretar la accion', '/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
}
