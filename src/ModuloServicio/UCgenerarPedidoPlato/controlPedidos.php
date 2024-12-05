<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/ControlOrden.php');


class controlPedidos{
    function iniciarControlOrden(){
        $controlOrdenObject = new ControlOrden();
        $controlOrdenObject->insertarControlOrden();
    }
}

?>