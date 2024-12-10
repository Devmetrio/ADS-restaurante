<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Mesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarMesas/panelGestionarMesas.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarMesas/panelGestionarMesas.php');

class controlGestionMesas
{

  public function crearMesa($capacidad, $idSeccion, $habilitado){
    $mesaObject = new Mesa();
    $mesaObject->agregarMesa($capacidad,$idSeccion, $habilitado);

    header('Location: /src/ModuloAdministracion/UCgestionarMesas/indexGestionarMesas.php');
  }

  public function habilitarMesa($id)
  {
    $mesaObject = new Mesa();
    $mesaObject->actualizarEstadoTecnico($id, 1);

    header('Location: /src/ModuloAdministracion/UCgestionarMesas/indexGestionarMesas.php');
  }

  public function deshabilitarMesa($id)
  {
    $mesaObject = new Mesa();
    $mesaObject->actualizarEstadoTecnico($id, 0);
    
    header('Location: /src/ModuloAdministracion/UCgestionarMesas/indexGestionarMesas.php');
  }
}
