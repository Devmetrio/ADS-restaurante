<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/panelGestionarUsuarios.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Usuario.php');
session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$usuariosObject = new Usuario();
$usuarios = $usuariosObject->obtenerUsuarios(); 

$panelUsuariosObject = new panelGestionarUsuarios();
$panelUsuariosObject->gestionarUsuariosShow($usuarios);