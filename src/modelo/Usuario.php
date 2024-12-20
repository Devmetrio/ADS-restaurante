<?php
require_once("conexion.php");

class Usuario extends conexion {
  
  public function validarLogin($login)
  {
    $this->conectar();
    $sql = "SELECT * FROM usuarios WHERE login = '$login'";
    $respuesta = $this->conectar()->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return true;
  }

  public function validarLoginPassword($txtLogin, $txtPassword)
  {
    $this->conectar();

    $sql = "SELECT password FROM usuarios WHERE login = '$txtLogin'";
    $respuesta = $this->conectar()->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    // Obtener la contraseña hasheada desde la base de datos
    $fila = $respuesta->fetch_assoc();
    $hashContrasenaDB = $fila['password'];

    // Verificar la contraseña
    // $isPasswordCorrect = password_verify($txtPassword, $hashContrasenaDB);

    $this->desconectar();

    // Retornar true si la contraseña es correcta, null si no
    return $hashContrasenaDB == $txtPassword;
  }


  public function validarEstado($txtLogin)
  {
    $this->conectar();
    $sql = "SELECT * FROM usuarios WHERE login = '$txtLogin' AND estado = 1";
    $respuesta = $this->conectar()->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return true;
  }

  public function obtenerRol($txtLogin)
  {
    $this->conectar();
    $sql = "SELECT idRol FROM usuarios WHERE login = '$txtLogin'";
    $respuesta = $this->conectar()->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $fila = $respuesta->fetch_assoc();
    $rol = $fila['idRol'];

    switch ($rol) {
      case 1:
        $rol = "anfitrion de bienvenida";
        break;
      case 2:
        $rol = "anfitrion de servicio";
        break;
      case 3:
        $rol = "cajero";
        break;
      default:
        $rol = "administrador";
    }

    $this->desconectar();
    return $rol;
  }

  public function obtenerId($txtLogin){
    $this->conectar();
    $sql = "SELECT idUsuario FROM usuarios WHERE login = '$txtLogin'";
    $respuesta = $this->conectar()->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $fila = $respuesta->fetch_assoc();
    $id= $fila['idUsuario'];
    return $id;
}
}

?>