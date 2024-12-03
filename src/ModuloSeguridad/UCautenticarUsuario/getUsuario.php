<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloSeguridad/UCautenticarUsuario/formAutenticarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloSeguridad/UCautenticarUsuario/controlAutenticarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');


$nombreCampoErroneo = '';
$mensajeError = '';


function validarBoton($boton)
{
  return isset($boton);
}

function validarDatos($txtLogin, $txtContrasena)
{
  global $nombreCampoErroneo, $mensajeError;
  if (strlen($txtLogin)<6) {
    $nombreCampoErroneo = 'Login';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' debe tener un formato de login válido';
    return false;
  } else if (strlen($txtContrasena) < 6 || empty($txtContrasena)) {
    $nombreCampoErroneo = 'Contraseña';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 6 caracteres';
    return false;
  }
  return true;
}

$btnSubmit = $_POST['btnSubmit'];

if (validarBoton($btnSubmit)) {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $txtLogin = $_POST['txtLogin'];
    $txtContrasena = $_POST['txtContrasena'];

    if (validarDatos($txtLogin, $txtContrasena)) {
      $controlAutenticarUsuarioObj = new controlAutenticarUsuario();
      $controlAutenticarUsuarioObj->validarUsuario($txtLogin, $txtContrasena);
    } else {
      $formAutenticarUsuario = new FormAutenticacionUsuario();
      $formAutenticarUsuario->formAutenticarUsuarioShow();

      $viewMessageSistemaObject = new viewMensajeSistema();
      $viewMessageSistemaObject->viewMensajeSistemaShow('error', 'Campo inválido', $mensajeError);
    }
  }
} else {
  $formAutenticarUsuario = new FormAutenticacionUsuario();
  $formAutenticarUsuario->formAutenticarUsuarioShow();

  $viewMessageSistemaObject = new viewMensajeSistema();
  $viewMessageSistemaObject->viewMensajeSistemaShow('error', 'Acceso denegado', 'Error, no se pudo completar la acción');
}
?>