<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelo/Usuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ModuloSeguridad/UCautenticarUsuario/formAutenticarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ModuloSeguridad/UCautenticarUsuario/indexPanelPrincipalSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/compartido/viewMensajeSistema.php');

class controlAutenticarUsuario
{
  public function validarUsuario($txtLogin, $txtContrasena)
  {
    session_start();
    $objUsuario = new usuario();
    $respuesta = $objUsuario->validarLogin($txtLogin);

    if ($respuesta == null) {
      $formAutenticarUsuario = new FormAutenticacionUsuario();
      $formAutenticarUsuario->formAutenticarUsuarioShow();

      $viewMessageSistemaObject = new viewMensajeSistema();
      $viewMessageSistemaObject->viewMensajeSistemaShow('error', 'Error', 'No se encontró el usuario');
    } else {
      $respuesta = $objUsuario->validarLoginPassword($txtLogin, $txtContrasena);
      if ($respuesta == null) {
        $formAutenticarUsuario = new FormAutenticacionUsuario();
        $formAutenticarUsuario->formAutenticarUsuarioShow();

        $viewMessageSistemaObject = new viewMensajeSistema();
        $viewMessageSistemaObject->viewMensajeSistemaShow('error', 'Error', 'Contraseña incorrecta');
      } else {
        $respuesta = $objUsuario->validarEstado($txtLogin);
        if ($respuesta == null) {
          $formAutenticarUsuario = new FormAutenticacionUsuario();
          $formAutenticarUsuario->formAutenticarUsuarioShow();

          $viewMessageSistemaObject = new viewMensajeSistema();
          $viewMessageSistemaObject->viewMensajeSistemaShow('error', 'Error', 'Usuario inactivo');
        } else {
          $_SESSION['login'] = $txtLogin;
          $_SESSION['rol'] = $objUsuario->obtenerRol($txtLogin);
          $_SESSION['autenticado'] = "SI";

          header('Location: /ModuloSeguridad/UCautenticarUsuario/indexPanelPrincipalSistema.php');
        }
      }
    }
  }
}