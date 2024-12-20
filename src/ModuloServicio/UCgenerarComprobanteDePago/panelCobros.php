<?php
class panelCobros
{
    public function panelCobrosShow($datos = [])
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Formulario Comprobante de Pago</title>
            <style>
                body {
                    background-color: #121212;
                    color: #ffffff;
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    min-height: 100vh;
                }
                h1 {
                    margin-bottom: 20px;
                }
                table {
                    border-collapse: collapse;
                    width: 80%;
                    margin-bottom: 20px;
                    text-align: left;
                }
                th, td {
                    border: 1px solid #333;
                    padding: 10px;
                }
                th {
                    background-color: #333;
                    color: #fff;
                }
                tr:nth-child(even) {
                    background-color: #1e1e1e;
                }
                tr:hover {
                    background-color: #333;
                }
                button {
                    background-color: #444;
                    color: #fff;
                    border: none;
                    padding: 10px 15px;
                    font-size: 16px;
                    cursor: pointer;
                    border-radius: 5px;
                }
                button:hover {
                    background-color: #666;
                }
                .center {
                    display: flex;
                    justify-content: center;
                }
                .btn-row {
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <h1>Mesas Faltas de Pago</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID Mesa</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($datos)): ?>
                        <?php foreach ($datos as $fila): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['idMesa']); ?></td>
                                <td><?php echo htmlspecialchars($fila['login']); ?></td>
                                <td class="btn-row">
                                    <form action="/src/ModuloServicio/UCgenerarComprobanteDePago/getComprobante.php" method="POST">
                                        <input type="hidden" name="idMesa" value="<?php echo htmlspecialchars($fila['idMesa']); ?>">
                                        <button type="submit">Seleccionar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No hay mesas faltas de pago</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="center">
                <form action="/src/ModuloServicio/UCgenerarComprobanteDePago/getComprobante.php" method="POST">
                    <button type="submit" name="btnRegresarAlPanel">Regresar al panel</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    }
}