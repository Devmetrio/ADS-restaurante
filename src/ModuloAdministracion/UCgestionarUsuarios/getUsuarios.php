<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/controlGestionUsuarios.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeValidacion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/panelGestionarUsuarios.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/formAgregarUsuarios.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/formEditarUsuarios.php');

$btnDeshabilitar = $_POST['btnDeshabilitar'] ?? null;
$btnHabilitar = $_POST['btnHabilitar'] ?? null;
$opcion = $_GET['opcion'] ?? null;
$accion = $_GET['accion'] ?? null;

$AgregarAceptar = $_POST['AbtnAceptar'] ?? null;
$AgregarCancelar = $_POST['AbtnCancelar'] ?? null;

$EditarAceptar = $_POST['btnActualizarUsuario'] ?? null;
$EditarCancelar = $_POST['btnCancelar'] ?? null;

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
        $mensajeError = 'El campo ' . $nombreCampoErroneo . ' debe tener entre 4 y 8 caracteres.';
        return false;
    }
    // Validar el campo 'password' (debe ser una cadena de texto con al menos 6 caracteres)
    if (empty($password) || strlen($password) > 8) {
        $nombreCampoErroneo = 'password';
        $mensajeError = 'El campo ' . $nombreCampoErroneo . ' debe tener 8 caracteres.';
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
} elseif (validarBoton($EditarAceptar)) {
    // Obtener los datos del formulario
    $idUsuario = intval($_POST['idUsuario']);
    $login = $_POST['login'];
    $password = $_POST['password'];
    $estado = intval($_POST['estado']);
    $idRol = intval($_POST['idRol']);
  
    // Validar que los datos sean correctos
    if(validarDatos($login, $password, $estado, $idRol)) {
      $controlGestionUsuariosObject = new controlGestionUsuarios();
      $controlGestionUsuariosObject->actualizarUsuario($idUsuario, $login, $password, $estado, $idRol); 
    } else {
        $usuarioRecibido = new Usuario();
        $usuarior = $usuarioRecibido->obtenerUsuarioPorId($idUsuario); 

        $formEditarUsuariosObject = new formEditarUsuarios();
        $formEditarUsuariosObject->formEditarUsuariosShow($usuarior);
  
      $viewMensajeSistemaObject = new viewMensajeSistema();
      $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Campos inválidos', 'Algunos campos tienen valores incorrectos o vacíos.');
    }
  } elseif(validarBoton($EditarCancelar)) {
    // Si se cancela la acción, volver a mostrar el panel de usuarios
    $panelGestionUsuariosObject = new panelGestionarUsuarios();
    $panelGestionUsuariosObject->gestionarUsuariosShow($usuarios);
  
    $viewMensajeSistemaObject = new viewMensajeSistema();
    $viewMensajeSistemaObject->viewMensajeSistemaShow('info', 'Acción cancelada', 'Se ha cancelado la acción de editar usuario');
  } else {
  // Si no se presiona ningún botón válido, mostrar mensaje de acceso denegado
  $viewMensajeSistemaObject = new viewMensajeSistema();
  $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Acceso denegado', 'Error, no se pudo completar la acción');
}

// Verificación del botón de habilitar usuario
if (validarBoton($btnHabilitar)) {
    $idUsuario = intval($_GET['idUsuario']);
    $panelGestionUsuariosObject = new panelGestionarUsuarios();
    $panelGestionUsuariosObject->gestionarUsuariosShow($usuarios);

    // Crear el objeto de mensaje de validación
    $viewMensajeValidacionObject = new viewMensajeValidacion();
    $viewMensajeValidacionObject->viewMensajeValidacionShow('question', 'Mensaje', '¿Quiere habilitar este usuario?', $idUsuario, 'btnHabilitar');
}

// Verificación del botón de deshabilitar usuario
if (validarBoton($btnDeshabilitar)) {
    $idUsuario = intval($_GET['idUsuario']);
    $panelGestionUsuariosObject = new panelGestionarUsuarios();
    $panelGestionUsuariosObject->gestionarUsuariosShow($usuarios);

    // Crear el objeto de mensaje de validación
    $viewMensajeValidacionObject = new viewMensajeValidacion();
    $viewMensajeValidacionObject->viewMensajeValidacionShow('question', 'Mensaje', '¿Quiere deshabilitar este usuario?', $idUsuario, 'btnDeshabilitar');
}

// Verificación de la acción de habilitar usuario
if ($accion === "btnHabilitar") {
    $idUsuario = intval($_GET['idUsuario']);
    if ($opcion === "aceptar") {
        $controlGestionUsuariosObject = new controlGestionUsuarios();
        $controlGestionUsuariosObject->habilitarUsuario($idUsuario);
    } elseif ($opcion === "cancelar") {
        $panelGestionUsuariosObject = new panelGestionarUsuarios();
        $panelGestionUsuariosObject->gestionarUsuariosShow($usuarios);
        $viewMessageSistemaObject = new viewMensajeSistema();
        $viewMessageSistemaObject->viewMensajeSistemaShow('info', 'Confirmación', 'Se ha cancelado la habilitación del usuario');
    }
}

// Verificación de la acción de deshabilitar usuario
elseif ($accion === "btnDeshabilitar") {
    $idUsuario = intval($_GET['idUsuario']);
    if ($opcion === "aceptar") {
        $controlGestionUsuariosObject = new controlGestionUsuarios();
        $controlGestionUsuariosObject->deshabilitarUsuario($idUsuario);
    } elseif ($opcion === "cancelar") {
        $panelGestionUsuariosObject = new panelGestionarUsuarios();
        $panelGestionUsuariosObject->gestionarUsuariosShow($usuarios);
        $viewMessageSistemaObject = new viewMensajeSistema();
        $viewMessageSistemaObject->viewMensajeSistemaShow('info', 'Confirmación', 'Se ha cancelado la deshabilitación del usuario');
    }
}


?>


