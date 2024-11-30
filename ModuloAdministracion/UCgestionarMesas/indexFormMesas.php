<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ModuloAdministracion/UCgestionarMesas/formMesas.php');

session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$formMesasObject = new formMesas();
$formMesasObject->formMesasShow();
?>