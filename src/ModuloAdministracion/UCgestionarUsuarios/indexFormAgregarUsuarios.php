<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/formAgregarUsuarios.php');

session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$formUsuariosObject = new formAgregarUsuarios();
$formUsuariosObject->formAgregarUsuariosShow();
?>