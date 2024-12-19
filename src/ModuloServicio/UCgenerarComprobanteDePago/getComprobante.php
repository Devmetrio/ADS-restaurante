<?php
session_start();


// Declaracion de funciones
function validarBoton($boton)
{
  return isset($boton);
}

function validarAccion($accion)
{
  return isset($accion);
}

function redirigirIndexPanelGestionOrden()
{
  header('Location: /src/ModuloServicio/UCgenerarComprobanteDePago/indexPanelGestionOrden.php?idMesa=' .  $_POST['btnOrdenMesa']);
}


$btnOrdenMesa = $_POST['btnOrdenMesa'] ?? null;


if (validarBoton($btnOrdenMesa)) {
    redirigirIndexPanelGestionOrden();
  }