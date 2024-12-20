<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloAdministracion/UCgestionarUsuarios/formEditarUsuarios.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Usuario.php');
session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}
if (isset($_GET['idUsuario'])) {
    // Recupera el valor de 'idUsuario' de la URL
    $idUsuario = $_GET['idUsuario'];
    $usuariosObject = new Usuario();
    $usuarios = $usuariosObject->obtenerUsuarioPorId($idUsuario); 

    $formEditarUsuariosObject = new formEditarUsuarios();
    $formEditarUsuariosObject->formEditarUsuariosShow($usuarios);

} else {
    echo "No se proporcionó un ID de usuario.";
}


