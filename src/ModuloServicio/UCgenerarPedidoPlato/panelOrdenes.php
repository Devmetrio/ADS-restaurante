<?php
class panelOrdenes
{
    public function panelOrdenesShow($controlOrdenes = null, $ordenDetalles = null, $idMesa = null, $idControl = null, $arrayMesaSec = null)
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
                <h1>Control de Mesas</h1>
                <div class="mesas-container">
                    <!-- Lista de Mesas -->
                    <div class="mesas-list">
                        <h2>MESAS</h2>
                        <?php if ($controlOrdenes): ?>
                            <form action="getPedidos.php" method="POST">
                                <?php foreach ($controlOrdenes as $mesa): ?>
                                    <button class="<?= ($mesa['idMesa'] == $idMesa) ? 'selected' : ''; ?>" value=<?= $mesa['idMesa']; ?> name="btnOrdenMesa" type="submit">
                                        Mesa <?php echo $mesa['idMesa']; ?>
                                    </button>
                                <?php endforeach; ?>
                            </form>

                        <?php else: ?>
                            <p>Cargando...</p>
                        <?php endif; ?>
                    </div>
                    <!-- Detalles de la Orden -->
                    <div class="detalles">
                        <h2>Detalles</h2>
                        <?php if ($ordenDetalles): ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Pedido</th>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ordenDetalles as $index => $detalle): ?>
                                        <tr>
                                            <td style="text-align: center;"><?= $index + 1; ?></td>
                                            <td style="width: 20%;"><?= htmlspecialchars($detalle['NombrePlato']); ?></td>
                                            <td><?= htmlspecialchars($detalle['Descripcion']); ?></td>
                                            <td style="text-align: center;"><?= (int)$detalle['Cantidad']; ?></td>
                                            <td style="width: 15%;">s/ <?= number_format((float)$detalle['Subtotal'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>    
                        <?php elseif ($idMesa): ?>
                            <p>Se ha iniciado el proceso de orden de esta mesa</p>
                        <?php else: ?>
                            <p>Selecciona una mesa para ver los detalles de la orden.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Botón Seleccionar Mesa -->
                <div class="btn-seleccionar">
                    <a href="indexSeleccionMesas.php">
                        <button>Seleccionar mesa</button>
                    </a>
                    <a href="/src/ModuloSeguridad/UCautenticarUsuario/indexPanelPrincipalSistema.php">
                        <button>Regresar a panel</button>
                    </a>
                    <?php if ($ordenDetalles): ?>
                        <a href="/src/ModuloServicio/UCgenerarPedidoPlato/indexOrdenMesa.php?orden=<?= $ordenDetalles[0]['idOrden'] ?>&idMesa=<?= $ordenDetalles[0]['Mesa'] ?>&idControlMesa=<?=$ordenDetalles[0]['idControlOrden'] ?>" >
                            <button>Aumentar orden</button>
                        </a>
                    <?php endif ?>
                </div>
            </div>

            <script>
                function enableDragScroll(containerSelector) {
                    const container = document.querySelector(containerSelector);
                    let isDragging = false;
                    let startY;
                    let scrollTop;

                    container.addEventListener('mousedown', (e) => {
                        isDragging = true;
                        container.classList.add('dragging');
                        startY = e.pageY - container.offsetTop;
                        scrollTop = container.scrollTop;
                    });

                    document.addEventListener('mousemove', (e) => {
                        if (!isDragging) return;
                        e.preventDefault();
                        const y = e.pageY - container.offsetTop;
                        const scroll = (y - startY) * 1.5;
                        container.scrollTop = scrollTop - scroll;
                    });

                    document.addEventListener('mouseup', () => {
                        isDragging = false;
                        container.classList.remove('dragging');
                    });
                }

                // Aplica la funcionalidad a ambos contenedores
                enableDragScroll('.mesas-list');
                enableDragScroll('.detalles');
            </script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
        </body>

        </html>
<?php
    }
}

?>