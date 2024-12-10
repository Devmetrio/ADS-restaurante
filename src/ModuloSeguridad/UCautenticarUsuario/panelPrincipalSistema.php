<?php

class panelPrincipalSistema
{
    public function panelPrincipalSistemaShow()
    {
        $rol = $_SESSION['rol'];
        $login = $_SESSION['login'];
        $id = $_SESSION['id'];
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Panel de Inicio</title>
        </head>

        <body>
            <main class="main-container">
                <div class="info">
                    <h1>Bienvenido <?= $rol ?></h1>
                    <p>Panel principal del sistema</p>
                    <p><i class="fa-regular fa-user"></i> Usuario: <?= $login ?></p>
                    <p><?= $id?></p>
                    <a href="/src/ModuloAdministracion/UCgestionarMesas/indexGestionarMesas.php">Gestionar Mesas</a>
                    <a href="/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php">Panel de Ordenes</a>
                    <a class="nav-link" href="/src/ModuloSeguridad/UCautenticarUsuario/cerrarSesion.php">Cerrar Sesión</a>
                </div>
        </body>

        </html>
<?php
    }
}
