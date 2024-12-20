<?php

class formAgregarUsuarios
{
    public function formAgregarUsuariosShow()
    {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Formulario - Agregar Usuario</title>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #2c3e50;
                    color: #ecf0f1;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }

                .form-container {
                    background-color: #34495e;
                    padding: 20px 30px;
                    border-radius: 10px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
                    width: 420px;
                }

                .form-container h2 {
                    margin: 0 0 20px;
                    font-size: 32px;
                    text-align: center;
                    color: #1abc9c;
                }

                .form-group label {
                    font-weight: bold;
                }

                .form-select,
                .form-control {
                    background-color: #2c3e50;
                    color: #ecf0f1;
                    border: 1px solid #1abc9c;
                }

                .form-select:focus,
                .form-control:focus {
                    border-color: #16a085;
                    box-shadow: none;
                }

                .form-actions {
                    display: flex;
                    justify-content: space-between;
                }

                .btn {
                    width: 48%;
                    padding: 10px;
                    border-radius: 5px;
                    font-size: 14px;
                    cursor: pointer;
                    transition: background-color 0.3s ease;
                }

                .btn-primary {
                    background-color: #1abc9c;
                    color: #ffffff;
                }

                .btn-primary:hover {
                    background-color: #16a085;
                }

                .btn-danger {
                    background-color: #e74c3c;
                    color: #ffffff;
                }

                .btn-danger:hover {
                    background-color: #c0392b;
                }

                hr {
                    border: 2px solid #1abc9c;
                }
            </style>
        </head>

        <body>
            <div class="form-container">
                <h2>Agregar Usuario</h2>
                <hr>
                <form action="/src/ModuloAdministracion/UCgestionarUsuarios/getUsuarios.php" method="POST">
                    <div class="form-group mb-3 mt-4">
                        <label for="login" class="mb-2">Login:</label>
                        <input type="text" id="login" name="login" class="form-control" required placeholder="Ingresa el login">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="mb-2">Contraseña:</label>
                        <input type="password" id="password" name="password" class="form-control" required placeholder="Ingresa la contraseña">
                    </div>
                    <div class="form-group mb-3">
                        <label for="estado" class="mb-2">Estado:</label>
                        <select id="estado" name="estado" class="form-select">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="rol" class="mb-2">Rol:</label>
                        <select id="rol" name="idRol" class="form-select">
                            <option value="1">Anfitrión de Bienvenida</option>
                            <option value="2">Anfitrión de Servicio</option>
                            <option value="3">Cajero</option>
                            <option value="4">Administrador</option>
                        </select>
                    </div>
                    <div class="form-actions mt-5">
                        <button type="submit" class="btn btn-primary" name="AbtnAceptar">Aceptar</button>
                        <button type="submit" class="btn btn-danger" name="AbtnCancelar">Cancelar</button>
                    </div>
                </form>
            </div>
        </body>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
        </html>
<?php
    }
}
?>
