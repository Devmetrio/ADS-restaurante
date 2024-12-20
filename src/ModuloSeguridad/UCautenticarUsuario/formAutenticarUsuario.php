<?php
<<<<<<< HEAD
@session_destroy();
=======
// Inicia la sesión antes de manipularla
session_start();

// Limpia todas las variables de sesión
$_SESSION = [];

// Destruye la sesión
session_destroy();

// Elimina la cookie de sesión, si existe
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
=========
@session_destroy();
>>>>>>>>> Temporary merge branch 2

class FormAutenticacionUsuario
{
    public function formAutenticarUsuarioShow()
    {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Index</title>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                }

                form {
                    display: flex;
                    flex-direction: column;
                    width: 200px;
                    margin: 0 auto;

                }

                label {
                    margin-top: 10px;
                }

                input {
                    margin-top: 5px;
                }

                button {
                    margin-top: 10px;
                    padding: 5px;
                    background-color: #007bff;
                    color: white;
                    border: none;
                    cursor: pointer;
                }

                h1 {
                    text-align: center;
                }
            </style>
        </head>

        <body>
            <h1>Autenticación de Usuario</h1>
            <form action="/src/ModuloSeguridad/UCautenticarUsuario/getUsuario.php" method="POST">
                <label for="txtUsuario">Usuario:</label>
                <input type="text" name="txtLogin">
                <label for="txtContraseña">Contraseña:</label>
                <input type="password" name="txtContrasena">
                <button type="submit" name="btnSubmit" value="Enviar">Enviar</button>
            </form>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
        </body>

        </html>
<?php
    }
}
?>