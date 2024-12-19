<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/controlGestionUsuarios.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeValidacion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/panelGestionarUsuarios.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/formAgregarUsuarios.php');

$btnDeshabilitar = $_POST['btnDeshabilitar'] ?? null;
$btnHabilitar = $_POST['btnHabilitar'] ?? null;
$opcion = $_GET['opcion'] ?? null;
$accion = $_GET['accion'] ?? null;

$AgregarAceptar = $_POST['AbtnAceptar'] ?? null;
$AgregarCancelar = $_POST['AbtnCancelar'] ?? null;

$usuariosObject = new Usuario();
$usuarios = $usuariosObject->obtenerUsuarios();

$nombreCampoErroneo = '';
$mensajeError = '';

function validarBoton($boton)
{
  return isset($boton);
}

function validarDatos($login, $password, $estado, $idRol) {
    global $nombreCampoErroneo, $mensajeError;

    // Validar el campo 'login' (debe ser una cadena de texto alfanumérica)
    if (empty($login) || strlen($login) < 4 || strlen($login) > 8) {
        $nombreCampoErroneo = 'login';
        $mensajeError = 'El campo ' . $nombreCampoErroneo . ' debe tener entre 4 y 50 caracteres.';
        return false;
    }
    // Validar el campo 'password' (debe ser una cadena de texto con al menos 6 caracteres)
    if (empty($password) || strlen($password) > 8) {
        $nombreCampoErroneo = 'password';
        $mensajeError = 'El campo ' . $nombreCampoErroneo . ' debe tener al menos 6 caracteres.';
        return false;
    }
    // Validar el campo 'estado' (debe ser un entero: 1 o 0)
    if (!is_int($estado) || ($estado !== 0 && $estado !== 1)) {
        $nombreCampoErroneo = 'estado';
        $mensajeError = 'El campo ' . $nombreCampoErroneo . ' debe ser 1 (Activo) o 0 (Inactivo).';
        return false;
    }
    // Validar el campo 'idRol' (debe ser un entero válido)
    if (!is_int($idRol) || $idRol < 1 || $idRol > 4) {
        $nombreCampoErroneo = 'idRol';
        $mensajeError = 'El campo ' . $nombreCampoErroneo . ' debe ser un valor válido entre 1 y 4.';
        return false;
    }
    // Si todas las validaciones pasan
    return true;
}

if (validarBoton($AgregarAceptar)) {
  // Obtener los datos del formulario
  $login = $_POST['login'];
  $password = $_POST['password'];
  $estado = intval($_POST['estado']);
  $idRol = intval($_POST['idRol']);

  // Validar que los datos sean correctos
  if(validarDatos($login, $password, $estado, $idRol)) {
    $controlGestionUsuariosObject = new controlGestionUsuarios();
    $controlGestionUsuariosObject->crearUsuario($login,$password, $estado, $idRol); 
  } else {
    // Mostrar mensaje de error si los datos no son válidos
    $formAgregarUsuariosObject = new formAgregarUsuarios();
    $formAgregarUsuariosObject->formAgregarUsuariosShow();

    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Campos inválidos', 'Algunos campos tienen valores incorrectos o vacíos.');
  }
} elseif(validarBoton($AgregarCancelar)) {
  // Si se cancela la acción, volver a mostrar el panel de usuarios
  $panelGestionUsuariosObject = new panelGestionarUsuarios();
  $panelGestionUsuariosObject->gestionarUsuariosShow($usuarios);

  $viewMensajeSistemaObject = new viewMensajeSistema();
  $viewMensajeSistemaObject->viewMensajeSistemaShow('info', 'Acción cancelada', 'Se ha cancelado la acción de agregar usuario');
} else {
  // Si no se presiona ningún botón válido, mostrar mensaje de acceso denegado
  $viewMensajeSistemaObject = new viewMensajeSistema();
  $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Acceso denegado', 'Error, no se pudo completar la acción');
}




?>


