<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgenerarComprobanteDePago/controlComprobante.php');
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

function redirigirIndexPanelGestionOrden()
{
  header('Location: /src/ModuloServicio/UCgenerarComprobanteDePago/indexPanelGestionOrden.php?idMesa=' .  $_POST['btnOrdenMesa']);
}

function validarCampos($campo)
{
  if ($campo == 0) {
    return false;
  }
  return true;
}

$btnOrdenMesa = $_POST['btnOrdenMesa'] ?? null;
$login = $_POST['login'] ?? null;
$btnTransacciones = $_POST['btnTransacciones'] ?? null;
$btnComprobantes = $_POST['btnComprobantes'] ?? null;

if (validarBoton($btnOrdenMesa)) {
    redirigirIndexPanelGestionOrden();
  }
if (validarBoton($btnComprobantes)) {

  $idMesa = $_POST['idMesa'];
  $controlComprobanteObject = new controlComprobante();
  $controlComprobanteObject->desactivarEstadoControlOrden($idMesa);
  } else {
    echo "No se aproetó el boton comprobantes";
  }

  if (validarBoton($btnTransacciones)) {
    echo "Transacciones pendientes<br>";
    $controlComprobanteObject = new controlComprobante();
    $controlComprobanteObject->obtenerComprobantesFaltosPago();
    } else {
      echo "Error al apretar boton transacacciones<br>";
    }