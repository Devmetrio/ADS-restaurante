<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelo/Mesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ModuloAdministracion/UCgestionarMesas/panelGestionarMesas.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ModuloAdministracion/UCgestionarMesas/panelGestionarMesas.php');

class controlGestionMesas
{

  public function crearMesa($capacidad, $idSeccion, $habilitado){
    $mesaObject = new Mesa();
    $mesaObject->agregarMesa($capacidad,$idSeccion, $habilitado);

    header('Location: /ModuloAdministracion/UCgestionarMesas/indexGestionarMesas.php');
  }

  public function habilitarMesa($id)
  {
    $mesaObject = new Mesa();
    $mesaObject->actualizarEstado($id, 1);

    header('Location: /ModuloAdministracion/UCgestionarMesas/indexGestionarMesas.php');
  }

  public function deshabilitarMesa($id)
  {
    $mesaObject = new Mesa();
    $mesaObject->actualizarEstado($id, 0);
    
    header('Location: /ModuloAdministracion/UCgestionarMesas/indexGestionarMesas.php');
  }
}
