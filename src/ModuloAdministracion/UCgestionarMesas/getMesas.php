<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarMesas/controlGestionMesas.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeValidacion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarMesas/panelGestionarMesas.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarMesas/formMesas.php');

$btnHabilitar = $_POST['btnHabilitar'] ?? null;
$btnDeshabilitar = $_POST['btnDeshabilitar'] ?? null;
$opcion = $_GET['opcion'] ?? null;
$accion = $_GET['accion'] ?? null;

$AgregarAceptar = $_POST['AbtnAceptar'] ?? null;
$AgregarCancelar = $_POST['AbtnCancelar'] ?? null;

$mesasObject = new Mesa();
$mesas = $mesasObject->obtenerMesas();

$nombreCampoErroneo = '';
$mensajeError = '';

function validarBoton($boton)
{
  return isset($boton);
}

function validarDatos($capacidad, $idSeccion, $habilitado){
  global $nombreCampoErroneo, $mensajeError;
  if(!is_int($capacidad)) {
    $nombreCampoErroneo = 'capacidad';
    $mensajeError = 'El campo de ' . $nombreCampoErroneo . ' debe tener un valor adecuado';
    return false;
  } elseif(!is_int($idSeccion)){
    $nombreCampoErroneo = 'seccion';
    $mensajeError = 'El campo de ' . $nombreCampoErroneo . ' debe ser un campo válido';
    return false;
  } elseif(!is_int($habilitado)){
    $nombreCampoErroneo = 'habilitado';
    $mensajeError = 'El campo de ' . $nombreCampoErroneo . ' debe ser un campo válido';
    return false;
  }
    return true;
}


if (validarBoton($AgregarAceptar)) {
  $capacidad = intval($_POST['capacidad']);
  $habilitado = intval($_POST['habilitado']);
  $idSeccion = intval($_POST['seccion']);
  if(validarDatos($capacidad,$idSeccion,$habilitado)){
    $controlGestionMesasObject = new controlGestionMesas();
    $controlGestionMesasObject->crearMesa($capacidad,$idSeccion,$habilitado);
  } else{
    $formMesasObject = new formMesas();
    $formMesasObject->formMesasShow();

    $viewMessageSistemaObject = new viewMensajeSistema();
    $viewMessageSistemaObject->viewMensajeSistemaShow('error', 'Campo inválido', $mensajeError);
  }

} elseif(validarBoton($AgregarCancelar)){
  $panelGestionMesasObject = new panelGestionarMesas();
  $panelGestionMesasObject->gestionarMesasShow($mesas);

  $viewMessageSistemaObject = new viewMensajeSistema();
  $viewMessageSistemaObject->viewMensajeSistemaShow('info', 'Confirmacion', 'Se ha cancelado la opcion de agregar mesa');

} else {
  $viewMessageSistemaObject = new viewMensajeSistema();
  $viewMessageSistemaObject->viewMensajeSistemaShow('error', 'Acceso denegado', 'Error, no se pudo completar la acción');
}


if (validarBoton($btnHabilitar)) {
  $idMesa = intval($_GET['idMesa']); 
  $panelGestionMesasObject = new panelGestionarMesas();
  $panelGestionMesasObject->gestionarMesasShow($mesas);
  $viewMensajeValidacionObject = new viewMensajeValidacion();
  $viewMensajeValidacionObject->viewMensajeValidacionShow('question', 'Mensaje', '¿Quiere habilitar esta mesa?', $idMesa, 'btnHabilitar');
}

if (validarBoton($btnDeshabilitar)) {
  $idMesa = intval($_GET['idMesa']); 
  $panelGestionMesasObject = new panelGestionarMesas();
  $panelGestionMesasObject->gestionarMesasShow($mesas);

  $viewMensajeValidacionObject = new viewMensajeValidacion();
  $viewMensajeValidacionObject->viewMensajeValidacionShow('question', 'Mensaje', '¿Quiere deshabilitar esta mesa?', $idMesa, 'btnDeshabilitar');
}

if($accion === "btnHabilitar"){
  $idMesa = intval($_GET['idMesa']); 
  if ($opcion === "aceptar") {
    $controlGestionMesasObject = new controlGestionMesas();
    $controlGestionMesasObject->habilitarMesa($idMesa);

  } elseif($opcion === "cancelar") {
    $panelGestionMesasObject = new panelGestionarMesas();
    $panelGestionMesasObject->gestionarMesasShow($mesas);

    $viewMessageSistemaObject = new viewMensajeSistema();
    $viewMessageSistemaObject->viewMensajeSistemaShow('info', 'Confirmación', 'Se ha cancelado la habilitación de la mesa');
  }
} elseif($accion === "btnDeshabilitar"){
  $idMesa = intval($_GET['idMesa']); 
  if ($opcion === "aceptar") {
    $controlGestionMesasObject = new controlGestionMesas();
    $controlGestionMesasObject->deshabilitarMesa($idMesa);
  } elseif($opcion === "cancelar") {
    $panelGestionMesasObject = new panelGestionarMesas();
    $panelGestionMesasObject->gestionarMesasShow($mesas);

    $viewMessageSistemaObject = new viewMensajeSistema();
    $viewMessageSistemaObject->viewMensajeSistemaShow('info', 'Confirmación', 'Se ha cancelado la deshabilitación de la mesa');
  }
}
