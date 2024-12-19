<?php
session_start();
require_once 'seleccionMesa.php';

$idMesa = $_GET['idMesa'] ?? null;
$array = $_GET['mesasSecundarias'] ?? null;
if (!isset($_SESSION['autenticado'])) {
    header('Location: /');
    exit();
  }

// Instanciar y renderizar la vista
$seleccionMesasObject = new seleccionMesas();
$seleccionMesasObject->seleccionMesaShow($idMesa, $array);
?>
