<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Usuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloSeguridad/UCautenticarUsuario/formAutenticarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloSeguridad/UCautenticarUsuario/indexPanelPrincipalSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');

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
          $_SESSION['id'] = $objUsuario->obtenerId($txtLogin);
          $_SESSION['login'] = $txtLogin;
          $_SESSION['rol'] = $objUsuario->obtenerRol($txtLogin);
          $_SESSION['autenticado'] = "SI";

          if($_SESSION['rol'] == 'administrador'){
            header('Location: /src/ModuloSeguridad/UCautenticarUsuario/indexPanelPrincipalSistema.php');
          } elseif($_SESSION['rol'] == 'anfitrion de bienvenida'){
            header('Location: /src/ModuloServicio/UCgestionarReserva/indexCalendarioReserva.php');
          } elseif($_SESSION['rol'] == 'anfitrion de servicio'){
            header('Location: /src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php');
          } elseif($_SESSION['rol'] == 'cajero'){
            header('Location: /src/ModuloServicio/UCgenerarComprobanteDePago/indexPanelGestionOrden.php');
          } else{
            header('Location: /');
          }
        }
      }
    }
  }
}