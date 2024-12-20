<?php
session_start();
require_once 'panelSeleccionarMesa.php';


if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
  }

// Instanciar y renderizar la vista
$seleccionarMesasObject = new seleccionarMesa();
$seleccionarMesasObject->panelseleccionarMesaShow();
?>