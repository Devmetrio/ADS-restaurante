<?php
class panelGestionarMesas
{
  public function gestionarMesasShow($mesas = null)
  {
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Gestión de Mesas</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
      <style>
        body {
          background-color: #f8f9fa;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
          margin-top: 20px;
          background: #ffffff;
          border-radius: 8px;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
          padding: 20px;
        }
        .btn-crear {
          background-color: #28a745;
          color: white;
          transition: background 0.3s;
        }
        .btn-crear:hover {
          background-color: #218838;
        }
        .btn-regresar {
          background-color: #ffc107;
          color: white;
          transition: background 0.3s;
        }
        .btn-regresar:hover {
          background-color: #e0a800;
        }
        table {
          border-radius: 8px;
          overflow: hidden;
        }
        table th {
          background-color: #343a40;
          color: white;
        }
        table tr:nth-child(even) {
          background-color: #f8f9fa;
        }
        .badge-estado {
          font-size: 14px;
          border-radius: 12px;
          padding: 5px 10px;
        }
        .badge-activo {
          background-color: #28a745;
          color: white;
        }
        .badge-inactivo {
          background-color: #dc3545;
          color: white;
        }
        .btn-accion {
          padding: 6px 12px;
          font-size: 14px;
          border-radius: 4px;
          transition: all 0.3s;
        }
        .btn-accion:hover {
          transform: scale(1.05);
        }
      </style>
    </head>

    <body>
      <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h1 class="h3 text-dark">Gestión de Mesas</h1>
          <div>
            <a href="indexFormMesas.php" class="btn btn-crear"><i class="fas fa-plus"></i> Crear Mesa</a>
            <a href="/src/ModuloSeguridad/UCautenticarUsuario/indexPanelPrincipalSistema.php" class="btn btn-regresar"><i class="fas fa-arrow-left"></i> Regresar</a>
          </div>
        </div>

        <table class="table table-hover text-center">
          <thead>
            <tr>
              <th scope="col">Número de Mesa</th>
              <th scope="col">Capacidad</th>
              <th scope="col">Estado</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($mesas as $mesa) : ?>
              <tr>
                <td><?= htmlspecialchars($mesa['idMesa']) ?></td>
                <td><?= htmlspecialchars($mesa['capacidad']) ?> personas</td>
                <td>
                  <?php if ($mesa['estadoTecnico'] == 1) : ?>
                    <span class="badge badge-estado badge-activo">Activo</span>
                  <?php else : ?>
                    <span class="badge badge-estado badge-inactivo">Inactivo</span>
                  <?php endif; ?>
                </td>
                <td>
                  <form action="/src/ModuloAdministracion/UCgestionarMesas/getMesas.php?idMesa=<?= htmlspecialchars($mesa['idMesa']) ?>" method="POST" style="display:inline;">
                    <?php if ($mesa['estadoTecnico'] == 1) : ?>
                      <button class="btn btn-danger btn-accion" type="submit" name="btnDeshabilitar">
                        <i class="fas fa-ban"></i> Deshabilitar
                      </button>
                    <?php else : ?>
                      <button class="btn btn-primary btn-accion" type="submit" name="btnHabilitar">
                        <i class="fas fa-check"></i> Habilitar
                      </button>
                    <?php endif; ?>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
<?php
  }
}
?>
