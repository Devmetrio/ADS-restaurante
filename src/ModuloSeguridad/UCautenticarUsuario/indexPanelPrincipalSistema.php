<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloSeguridad/UCautenticarUsuario/panelPrincipalSistema.php');
session_start();
if (isset($_SESSION['autenticado'])) {
  $panelPrincipalObject = new panelPrincipalSistema();
  $panelPrincipalObject->panelPrincipalSistemaShow();
}
