<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Usuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/panelGestionarUsuarios.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/panelGestionarUsuarios.php');

class controlGestionUsuarios
{

  public function crearUsuario($login,$password, $habilitado, $idRol){
    $usuarioObject = new Usuario();
    $usuarioObject->agregarUsuario($login,$password, $habilitado, $idRol);

    header('Location: /src/ModuloAdministracion/UCgestionarUsuarios/indexGestionarUsuarios.php');
  }

  public function habilitarUsuario($id)
  {
    $usuarioObject = new Usuario();
    $usuarioObject->actualizarEstadoUsuario($id, 1);

    header('Location: /src/ModuloAdministracion/UCgestionarUsuarios/indexGestionarUsuarios.php');
  }

  public function deshabilitarUsuario($id)
  {
    $usuarioObject = new Usuario();
    $usuarioObject->actualizarEstadoUsuario($id, 0);

    header('Location: /src/ModuloAdministracion/UCgestionarUsuarios/indexGestionarUsuarios.php');
  }

  public function actualizarUsuario($idUsuario, $login, $password, $estado, $idRol){
    $usuarioObject = new Usuario();
    $usuarioObject->editarUsuario($idUsuario, $login, $password, $estado, $idRol);

    header('Location: /src/ModuloAdministracion/UCgestionarUsuarios/indexGestionarUsuarios.php');
  }


}
