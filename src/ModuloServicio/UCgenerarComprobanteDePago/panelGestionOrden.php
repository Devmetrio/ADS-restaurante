<?php
class panelGestionOrden
{
    public function panelGestionOrdenShow($controlOrdenesActivas = null, $ordenDetalles = null, $idMesa = null, $idControl = null, $total = 0)
    {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Control de Mesas</title>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #1a1a1a;
                    color: white;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }

                .container {
                    width: 85%;
                    max-width: 1100px;
                    border: 1px solid #333;
                    padding: 20px;
                    background-color: #292929;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                    height: 60vh;
                }

                h1 {
                    text-align: center;
                    margin-bottom: 20px;
                }

                .mesas-container {
                    display: flex;
                    gap: 20px;
                    height: 60%;
                }

                .mesas-list {
                    flex: 1;
                    border: 2px solid #444;
                    padding: 10px;
                    border-radius: 10px;
                    overflow-y: hidden;
                    max-height: 400px;
                    cursor: grab;
                    user-select: none;
                    /* Deshabilita la selección de texto */
                }

                .mesas-list button {
                    display: block;
                    width: 100%;
                    margin-bottom: 10px;
                    padding: 10px;
                    background-color: #444;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                }

                .mesas-list button:hover {
                    background-color: #555;
                }

                .detalles {
                    flex: 2;
                    border: 2px solid #444;
                    padding: 10px;
                    border-radius: 5px;
                    overflow-y: hidden;
                    max-height: 400px;
                    cursor: grab;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    user-select: none;
                    /* Deshabilita la selección de texto */
                }

                table,
                th,
                td {
                    border: 1px solid #444;
                }

                th,
                td {
                    padding: 8px;
                    text-align: left;
                }

                th {
                    background-color: #444;
                }

                .btn-seleccionar {
                    margin-top: 20px;
                    display: flex;
                    justify-content: center;
                    gap: 5px;
                }

                .btn-seleccionar button {
                    padding: 10px 20px;
                    background-color: #444;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                }

                .btn-seleccionar button:hover {
                    background-color: #555;
                }

                .mesas-list button.selected {
                    background-color: #28a745;
                    color: white;
                    font-weight: bold;
                    border: 2px solid #1f7a31;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h1>GESTIÓN DE ÓRDENES</h1>
                <div class="mesas-container">
                    <!-- Lista de Mesas -->
                    <!-- Lista de Mesas -->
                    <div class="mesas-list">
                        <h2>MESAS ACTIVAS</h2>
                        <?php if ($controlOrdenesActivas): ?>
                            <?php foreach ($controlOrdenesActivas as $mesa): ?>
                                <form action="getComprobante.php" method="POST">
                                    <!-- Campos ocultos solo para la mesa seleccionada -->
                                    <input type="hidden" name="idMesa" value="<?= htmlspecialchars($mesa['idMesa']); ?>">
                                    <input type="hidden" name="idControlOrden" value="<?= htmlspecialchars($mesa['idControlOrden']); ?>">
                                    <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($mesa['idUsuario']); ?>">
                                    <input type="hidden" name="login" value="<?= htmlspecialchars($mesa['login']); ?>">

                                    <!-- Campo oculto para el total -->
                                    <input type="hidden" name="total" value="<?= htmlspecialchars($total); ?>">

                                    <button
                                        class="<?= ($mesa['idMesa'] == $idMesa) ? 'selected' : ''; ?>"
                                        value="<?= htmlspecialchars($mesa['idMesa']); ?>"
                                        name="btnOrdenMesa"
                                        type="submit">
                                        Mesa <?= $mesa['idControlOrden']; ?> - <?= $mesa['idMesa']; ?> - <?= htmlspecialchars($mesa['login']); ?>
                                    </button>
                                </form>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Cargando...</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Botones adicionales -->
                <div class="btn-seleccionar">
                    <form action="/src/ModuloServicio/UCgenerarComprobanteDePago/getComprobante.php" method="POST">
                        <button name="btnTransacciones" type="submit">Transacciones pendientes</button>
                    </form>

                    <a href="/src/ModuloSeguridad/UCautenticarUsuario/cerrarSesion.php">
                        <button style="background-color: red; color: white; border: none; padding: 10px 20px; font-size: 14px; cursor: pointer; border-radius: 5px;">
                            Cerrar Sesión
                        </button>
                    </a>
                </div>

            </div>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
        </body>

        </html>
<?php
    }
}
