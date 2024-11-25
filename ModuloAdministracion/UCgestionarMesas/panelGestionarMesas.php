<?php

class panelGestionarMesas
{
  public function gestionarMesasShow($mesas)
  {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Gestión de Mesas</title>
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
      <style>
        body {
          font-family: Arial, sans-serif;
          background-color: #f4f4f9;
          margin: 0;
          padding: 0;
          display: flex;
          flex-direction: column;
          align-items: center;
        }

        h1 {
          margin-top: 20px;
          color: #333;
        }

        .container {
          width: 80%;
          margin: 20px auto;
          background-color: #fff;
          box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
          padding: 20px;
          border-radius: 8px;
        }

        .actions {
          display: flex;
          justify-content: space-between;
          margin-bottom: 10px;
        }

        .actions button {
          padding: 10px 20px;
          font-size: 16px;
          border: none;
          background-color: #4CAF50;
          color: white;
          cursor: pointer;
          border-radius: 4px;
        }

        .actions button:hover {
          background-color: #45a049;
        }

        table {
          width: 100%;
          border-collapse: collapse;
        }

        table,
        th,
        td {
          border: 1px solid #ddd;
        }

        th,
        td {
          padding: 10px;
          text-align: left;
        }

        th {
          background-color: #f2f2f2;
        }

        .btn {
          padding: 5px 10px;
          font-size: 14px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        }


        .btn-deshabilitar {
          background-color: #f44336;
          color: white;
        }

        .btn-habilitar {
          background-color: #2196F3;
          color: white;
        }

        .btn-eliminar {
          background-color: #555;
          color: white;
        }


        .btn-deshabilitar:hover {
          background-color: #e53935;
        }

        .btn-habilitar:hover {
          background-color: #1e88e5;
        }

        .btn-eliminar:hover {
          background-color: #444;
        }
      </style>
    </head>

    <body>

      <h1>Gestión de Mesas</h1>

      <div class="container">
        <div class="actions">
          <button>Crear Mesa</button>
        </div>

        <table>
          <thead>

            <tr>
              <th>Número de Mesa</th>
              <th>Capacidad</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($mesas as $mesa) : ?>
              <tr>
                <td><?= htmlspecialchars($mesa['idMesa']) ?></td>
                <td><?= htmlspecialchars($mesa['capacidad']) ?></td>
                <td><?= htmlspecialchars($mesa['estadoTecnico']) ?></td>
                <td>
                  <?php if ($mesa['estadoTecnico'] == 1) : ?>
                    <button
                      class="btn btn-deshabilitar" type="submit" name="btnDeshabilitar" value="<?= htmlspecialchars($mesa['idMesa']) ?>">
                      Deshabilitar
                    </button>
                  <?php else : ?>
                    <button class="btn btn-habilitar" type="submit" name="btnHabilitar" value="<?= htmlspecialchars($mesa['idMesa']) ?>">
                      Habilitar
                    </button>
                  <?php endif; ?>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
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