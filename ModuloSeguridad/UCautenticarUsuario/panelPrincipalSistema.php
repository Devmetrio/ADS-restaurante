<?php

class panelPrincipalSistema
{
    public function panelPrincipalSistemaShow()
    {
        $rol = $_SESSION['rol'];
        $login = $_SESSION['login'];

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
                    <a href="/ModuloAdministracion/UCgestionarMesas/indexGestionarMesas.php">Gestionar Mesas</a>
                </div>
        </body>

        </html>
<?php
    }
}
