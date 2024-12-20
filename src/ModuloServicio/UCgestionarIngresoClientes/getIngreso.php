<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarIngresoClientes/controlGestionarIngreso.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarIngresoClientes/viewMensajeSistema.php');

// Declaracion de funciones
function validarBoton($boton)
{
  return isset($boton);
}

function validarAccion($accion)
{
  return isset($accion);
} 

function redirigirindexGestionarReserva()
{
  header('Location: /src/ModuloServicio/UCgestionarReserva/indexGestionarReserva.php');
}

function redirigirindexSeleccionarMesa()
{
  header('Location: /src/ModuloServicio/UCgestionarIngresoClientes/indexSeleccionarMesa.php?idMesa=' .  $_POST['btnSeleccionarMesa']);
}

function redirigirindexverDetallesReserva($idReserva)
{
    header('Location: /src/ModuloServicio/UCgestionarIngresoClientes/indexverDetallesReserva.php?idReserva=' . $idReserva);
    exit; // Asegúrate de salir después de un header para evitar la ejecución de código adicional.
}


function validarCampos($campo)
{
  if ($campo !== 0) {
    return true;
  }
  return false;
}



// Declaración de variables 
$btnSeleccionarMesa = $_POST['btnSeleccionarMesa'] ?? null;
$btnRegresarPanel = $_POST['btnRegresarPanel'] ?? null;
$btnverDetalles = $_POST['btnverDetalles'] ?? null;
$btnConfirmarReserva = $_POST['btnConfirmarReserva'] ?? null;
// Flujo principal
if (validarBoton($btnSeleccionarMesa)) {
    redirigirindexSeleccionarMesa();
} elseif (validarBoton($btnRegresarPanel)) {
    redirigirindexGestionarReserva();
} elseif (validarBoton($btnverDetalles)) {
    $idReserva = $_POST['idReserva'] ?? null;
    if ($idReserva) {
        redirigirindexverDetallesReserva($idReserva);
    } else {
        echo "Error: No se proporcionó un ID de reserva.";
    }
} if (validarBoton($btnConfirmarReserva)) {
  $idReserva = intval($_GET['idReserva']); // Captura el ID de la reserva desde la URL
  $controlGestionarIngresoObject = new controlGestionarIngreso();
  $controlGestionarIngresoObject->confirmarLlegadaReserva($idReserva);
}










  
?>