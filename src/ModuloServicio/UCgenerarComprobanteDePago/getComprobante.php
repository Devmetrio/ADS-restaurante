<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/controlComprobante.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/panelGestionOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/ControlOrden.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/OrdenDetalle.php');
session_start();


// Declaracion de funciones
function validarBoton($boton)
{
  return isset($boton);
}

function validarAccion($accion)
{
  return isset($accion);
}


function validarCampos($campo)
{
  if ($campo == 0) {
    return false;
  }
  return true;
}


$idMesa = $_POST['idMesa'] ?? null;
$idControlOrden = $_POST['idControlOrden'] ?? null;
$idUsuario = $_POST['idUsuario'] ?? null;
$login = $_POST['login'] ?? null;

$btnOrdenMesa = $_POST['btnOrdenMesa'] ?? null;
$btnTransacciones = $_POST['btnTransacciones'] ?? null;
$btnComprobantes = $_POST['btnComprobantes'] ?? null;
$btnRegresarAlPanel = $_POST['btnRegresarAlPanel'] ?? null;
$btnRegresarAlPanelDesdeCobros = $_POST['btnRegresarAlPanelDesdeCobros'] ?? null;
$TipoComprobante= $_POST['tipoComprobante'] ?? null;
$btnImprimir = $_POST['btnImprimir'] ?? null;
$total = $_POST['total'] ?? null;


if (validarBoton($btnImprimir)) {
  if($TipoComprobante == 'factura'){

    $ruc = $_POST['ruc'] ?? null;
    $razonSocial = $_POST['razonSocial'] ?? null;
    $idMesa = $_POST['idMesa'] ?? null;
    $idControlOrden = $_POST['idControlOrden'] ?? null;
    $idUsuario = $_POST['idUsuario'] ?? null;
    $login = $_POST['login'] ?? null;
    $total = $_POST['total'] ?? null;
    
    $controlComprobanteObject = new controlComprobante();
    $controlComprobanteObject->insertarDatosEnFactura($idControlOrden, $ruc, $razonSocial, $total);

  }
}

  if (validarBoton($btnImprimir)) {
    if ($TipoComprobante == 'boleta') {
    
      $dni = $_POST['dni'] ?? null;
      $idMesa = $_POST['idMesa'] ?? null;
      $idControlOrden = $_POST['idControlOrden'] ?? null;
  
      echo $idControlOrden;
  
      $idUsuario = $_POST['idUsuario'] ?? null;
      $login = $_POST['login'] ?? null;
      $total = $_POST['total'] ?? null;
      
      $controlComprobanteObject = new controlComprobante();
      $controlComprobanteObject->insertarDatosEnBoleta($idControlOrden, $dni);
  
    }


}

if (validarBoton($btnOrdenMesa)) {
  if ($idMesa != null) {
    // Obtener los detalles de la orden
    $ordenDetallesObject = new OrdenDetalle();
    $ordenDetalles = $ordenDetallesObject->obtenerOrdenDetalle($idMesa);

    // Inicializar el total
    $total = 0;

    // Calcular la suma de los subtotales
    if ($ordenDetalles) {
        foreach ($ordenDetalles as $detalle) {
            $total += (float)$detalle['Subtotal']; // Acumula el subtotal de cada detalle
        }
    }
}
  $idMesa = $_POST['idMesa'];
  $idControlOrden = $_POST['idControlOrden'];
  $idUsuario = $_POST['idUsuario'];
  $login = $_POST['login'];

  $controlComprobanteObject = new controlComprobante();
  $controlComprobanteObject->desactivarEstadoControlOrden($idMesa, $idControlOrden, $login, $total);
}


if (validarBoton($btnTransacciones)) {
  $controlComprobanteObject = new controlComprobante();
  $controlComprobanteObject->obtenerComprobantesFaltosPago();
  exit;
}



if (validarBoton($btnRegresarAlPanel)) {
  if ($idMesa) {
    $controlComprobanteObject = new controlComprobante();
    $controlComprobanteObject->activarEstadoControlOrden($idMesa);
    exit;
  } else {
    $controlOrdenObject = new ControlOrden();
    $controlOrdenesActivas = $controlOrdenObject->obtenerOrdenControlActivas();

    $ordenDetalles = null;
    $idControl = null;

    if ($idMesa !== null) {
      $ordenDetallesObject = new OrdenDetalle();
      $ordenDetalles = $ordenDetallesObject->obtenerOrdenDetalle($idMesa);
      $idControl = $controlOrdenObject->obtenerIdControlPorMesa($idMesa);
    }

    $panelGestionOrdenObject = new panelGestionOrden();
    $panelGestionOrdenObject->panelGestionOrdenShow($controlOrdenesActivas, $ordenDetalles, $idMesa, $idControl);
  }
}


echo "No se presionó ningún botón válido.";
