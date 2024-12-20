<?php

class formEditarUsuarios
{
    public function formEditarUsuariosShow($usuarios)
    {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Formulario - Editar Usuario</title>
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
    <div class="container mt-5">
        <h1>Editar Usuario</h1>
        <form action="/src/ModuloAdministracion/UCgestionarUsuarios/getUsuarios.php" method="POST">
            <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($usuarios['idUsuario']) ?>">
            
            <div class="mb-3">
                <label for="login" class="form-label">Login:</label>
                <input type="text" id="login" name="login" class="form-control" value="<?= htmlspecialchars($usuarios['login']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="text" id="password" name="password" class="form-control" value="<?= htmlspecialchars($usuarios['password']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select id="estado" name="estado" class="form-select">
                    <option value="1" <?= $usuarios['estado'] == 1 ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= $usuarios['estado'] == 0 ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="idRol" class="form-label">Rol:</label>
                <select id="idRol" name="idRol" class="form-select">
                    <option value="1" <?= $usuarios['idRol'] == 1 ? 'selected' : '' ?>>Anfitrión de Bienvenida</option>
                    <option value="2" <?= $usuarios['idRol'] == 2 ? 'selected' : '' ?>>Anfitrión de Servicio</option>
                    <option value="3" <?= $usuarios['idRol'] == 3 ? 'selected' : '' ?>>Cajero</option>
                    <option value="4" <?= $usuarios['idRol'] == 4 ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary" name="btnActualizarUsuario">Guardar Cambios</button>
            <button type="submit" class="btn btn-danger" name="btnCancelar">Cancelar</button>
        </form>
    </div>
</body>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
        </html>
<?php
    }
}
?>
