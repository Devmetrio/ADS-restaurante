<?php
@session_destroy();

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
            <title>Inicio de Sesión</title>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    font-family: 'Poppins', sans-serif;
                }

                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh; /* Cambiamos min-height por height para asegurarnos de ocupar toda la pantalla */
                    margin: 0;
                    background: linear-gradient(135deg, #74b9ff, #a29bfe);
                }

                .login-container {
                    background: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    width: 100%;
                    max-width: 400px;
                }

                .login-container h1 {
                    font-size: 24px;
                    text-align: center;
                    color: #2d3436;
                    margin-bottom: 20px;
                }

                .login-container form {
                    display: flex;
                    flex-direction: column;
                }

                .form-group {
                    margin-bottom: 15px;
                }

                label {
                    font-size: 14px;
                    color: #636e72;
                    margin-bottom: 5px;
                }

                input {
                    width: 100%;
                    padding: 10px;
                    font-size: 14px;
                    border: 1px solid #dfe6e9;
                    border-radius: 4px;
                }

                button {
                    background: #0984e3;
                    color: white;
                    padding: 10px;
                    font-size: 16px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    transition: background 0.3s;
                }

                button:hover {
                    background: #74b9ff;
                }

                .footer {
                    text-align: center;
                    margin-top: 10px;
                    font-size: 12px;
                    color: #b2bec3;
                }

                .footer a {
                    color: #0984e3;
                    text-decoration: none;
                }
            </style>
        </head>

        <body>
            <div class="login-container">
                <h1>Autenticación de Usuario</h1>
                <form action="/src/ModuloSeguridad/UCautenticarUsuario/getUsuario.php" method="POST">
                    <div class="form-group">
                        <label for="txtUsuario">Usuario</label>
                        <input type="text" name="txtLogin" id="txtUsuario" placeholder="Ingresa tu usuario">
                    </div>
                    <div class="form-group">
                        <label for="txtContraseña">Contraseña</label>
                        <input type="password" name="txtContrasena" id="txtContraseña" placeholder="Ingresa tu contraseña">
                    </div>
                    <button type="submit" name="btnSubmit" value="Enviar">Iniciar Sesión</button>
                </form>
                <div class="footer">
                    <p><a href="#"></a></p>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
        </body>

        </html>
<?php
    }
}
?>
