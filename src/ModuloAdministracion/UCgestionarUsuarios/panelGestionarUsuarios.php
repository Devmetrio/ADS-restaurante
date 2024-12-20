<?php

class panelGestionarUsuarios
{
  public function gestionarUsuariosShow($usuarios = null)
  {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Gestión de Usuarios</title>
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
      <style>
        table {
          width: 100%;
          border-collapse: collapse;
          margin: 20px 0;
          font-size: 18px;
          text-align: left;
        }

        th, td {
          padding: 12px;
          border: 1px solid #ddd;
        }

        th {
          background-color: #f4f4f4;
        }

        .btn {
          padding: 10px 15px;
          margin: 5px;
          border: none;
          cursor: pointer;
          font-size: 14px;
        }

        .btn-crear {
          background-color: #4caf50;
          color: white;
        }

        .btn-regresar {
          background-color: #2196f3;
          color: white;
        }

        .btn-habilitar {
          background-color: #4caf50;
          color: white;
        }

        .btn-deshabilitar {
          background-color: #f44336;
          color: white;
        }

        .btn-editar {
          background-color: #ff9800;
          color: white;
        }
      </style>
    </head>

    <body>

      <h1>Gestión de Usuarios</h1>

      <div class="container">
        <div class="botones-container">
          <a href="indexFormAgregarUsuarios.php">
            <button class="btn btn-crear">Crear Usuario</button>
          </a>
          <a href="/src/ModuloSeguridad/UCautenticarUsuario/cerrarSesion.php">
            <button class="btn btn-regresar">Cerrar Sesion</button>
          </a>
        </div>
        <table>
          <thead>
            <tr>
              <th>ID Usuario</th>
              <th>Login</th>
              <th>Contraseña</th>
              <th>Estado</th>
              <th>Rol</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($usuarios && $usuarios->num_rows > 0) : ?>
              <?php while ($usuario = $usuarios->fetch_assoc()) : ?>
                <tr>
                  <td><?= htmlspecialchars($usuario['idUsuario']) ?></td>
                  <td><?= htmlspecialchars($usuario['login']) ?></td>
                  <td><?= htmlspecialchars($usuario['password']) ?></td>
                  <td><?= $usuario['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
                  <td>
                    <?php
                    switch ($usuario['idRol']) {
                      case 1:
                        echo 'Anfitrión de Bienvenida';
                        break;
                      case 2:
                        echo 'Anfitrión de Servicio';
                        break;
                      case 3:
                        echo 'Cajero';
                        break;
                      default:
                        echo 'Administrador';
                        break;
                    }
                    ?>
                  </td>
                  <td>
                    <form action="/src/ModuloAdministracion/UCgestionarUsuarios/getUsuarios.php?idUsuario=<?= htmlspecialchars($usuario['idUsuario']) ?>" method="POST" style="display: inline;">
                      <?php if ($usuario['estado'] == 1) : ?>
                        <button class="btn btn-deshabilitar" type="submit" name="btnDeshabilitar">
                          Deshabilitar
                        </button>
                      <?php else : ?>
                        <button class="btn btn-habilitar" type="submit" name="btnHabilitar">
                          Habilitar
                        </button>
                      <?php endif; ?>
                    </form>
                    <!-- Botón para editar usuario -->
                    <a href="/src/ModuloAdministracion/UCgestionarUsuarios/indexformEditarUsuarios.php?idUsuario=<?= htmlspecialchars($usuario['idUsuario']) ?>">
                      <button class="btn btn-editar">
                        Editar
                      </button>
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else : ?>
              <tr>
                <td colspan="6">No hay usuarios registrados.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    </body>

    </html>

<?php
  }
}
?>
