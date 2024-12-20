<?php class panelCobros
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
        </head>
        <body>
            <h1>Mesas Faltas de Pago</h1>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID Mesa</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($datos)): ?>
                        <?php foreach ($datos as $fila): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['idMesa']); ?></td>
                                <td><?php echo htmlspecialchars($fila['login']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">No hay mesas faltas de pago</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <form action="/src/ModuloServicio/UCgenerarComprobanteDePago/getComprobante.php" method="POST">
                <button type="submit" name="btnRegresarAlPanel">Regresar al panel</button>
            </form>
        </body>
        </html>
        <?php
    }
}
