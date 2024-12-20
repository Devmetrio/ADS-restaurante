<?php
session_start();
require_once 'seleccionMesa.php';


if (!isset($_SESSION['autenticado']) || $_SESSION['rol'] != 'anfitrion de servicio') {
  header('Location: /');
  exit();
}

$idMesa = $_GET['idMesa'] ?? null;
$array = $_GET['mesasSecundarias'] ?? null;
// Instanciar y renderizar la vista
$seleccionMesasObject = new seleccionMesas();
$seleccionMesasObject->seleccionMesaShow($idMesa, $array);
?>
