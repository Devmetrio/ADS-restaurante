<?php

require_once 'seleccionMesa.php';

$idMesa = $_GET['idMesa'] ?? null;

// Instanciar y renderizar la vista
$seleccionMesasObject = new seleccionMesas();
$seleccionMesasObject->seleccionMesaShow($idMesa);
?>
