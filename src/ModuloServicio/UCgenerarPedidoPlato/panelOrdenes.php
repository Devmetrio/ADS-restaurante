<?php
class panelOrdenes
{
    public function panelOrdenesShow($controlOrdenes = null, $ordenDetalles = null, $idMesa = null, $idControl = null)
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
                    height: 70vh;
                }

                h1 {
                    text-align: center;
                    margin-bottom: 20px;
                    user-select: none;
                }

                .mesas-container {
                    display: flex;
                    gap: 20px;
                    height: 70%;
                }

                .mesas-list {
                    flex: 1;
                    border: 2px solid #444;
                    padding: 10px;
                    border-radius: 10px;
                    overflow-y: hidden;
                    max-height: 400px;
                    max-width: 25%;
                    cursor: grab;
                    user-select: none;
                }

                .mesas-list button {
                    display: flex;
                    flex-direction: column;
                    /* Alinea elementos en columna (texto arriba, imagen abajo) */
                    align-items: center;
                    /* Centra el contenido horizontalmente */
                    justify-content: center;
                    /* Centra el contenido verticalmente */
                    width: 100%;
                    /* Ocupa todo el ancho del contenedor */
                    margin-bottom: 10px;
                    padding: 15px;
                    /* Añade espacio interno */
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
                    max-height: 500px;
                    cursor: grab;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    user-select: none;
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


                .mesa-icon {
                    width: 48px;
                    /* Tamaño de la imagen */
                    height: 48px;
                    /* Tamaño de la imagen */
                    margin-top: 5px;
                    /* Espacio entre el texto y la imagen */
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h1>Panel de ordenes</h1>
                <div class="mesas-container">
                    <!-- Lista de Mesas -->
                    <div class="mesas-list">
                        <h2>MESAS</h2>
                        <?php if ($controlOrdenes): ?>
                            <?php foreach ($controlOrdenes as $mesa): ?>
                                <form action="getPedidos.php" method="POST">
                                    <button class="<?= ($mesa['idMesa'] == $idMesa) ? 'selected' : ''; ?>" value=<?= $mesa['idMesa']; ?> name="btnOrdenMesa" type="submit">
                                        <span>Mesa <?= $mesa['idMesa']; ?></span>
                                        <img src="/src/assets/images/mesa1.svg" alt="Mesa <?= $mesa['idMesa']; ?>" class="mesa-icon">
                                    </button>
                                    <input type="hidden" value="<?=$mesa['idMesa'] ?>" name="idMesa">
                                </form>
                                <?php endforeach; ?>

                        <?php else: ?>
                            <p>Cargando...</p>
                        <?php endif; ?>
                    </div>
                    <!-- Detalles de la Orden -->
                    <div class="detalles">
                        <h2>Detalles <?= isset($idMesa) ? 'de mesa ' . $idMesa : '' ?></h2>
                        <?php if ($ordenDetalles): ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Pedido</th>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ordenDetalles as $index => $detalle): ?>
                                        <tr>
                                            <td style="text-align: center;"><?= $index + 1; ?></td>
                                            <td style="width: 20%;"><?= htmlspecialchars($detalle['NombrePlato']); ?></td>
                                            <td><?= htmlspecialchars($detalle['Descripcion']); ?></td>
                                            <td style="text-align: center;"><?= (int)$detalle['Cantidad']; ?></td>
                                            <td style="width: 15%;">S/ <?= number_format((float)$detalle['Subtotal'], 2); ?></td>
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
                    <form action="getPedidos.php" method="POST">
                        <button type="submit" name="btnSeleccionarMesa" value="seleccionar">Seleccionar mesa</button>
                    </form>
                    <?php if ($ordenDetalles || $idMesa): ?>
                        <a href="/src/ModuloServicio/UCgenerarPedidoPlato/indexOrdenMesa.php?orden=<?= isset($ordenDetalles[0]['idOrden']) ? $ordenDetalles[0]['idOrden'] : '' ?>&idMesa=<?= $idMesa ?>&idControl=<?= $idControl ?>">
                            <button>Completar orden</button>
                        </a>
                        <?php endif ?>
                        <a href="/src/ModuloSeguridad/UCautenticarUsuario/cerrarSesion.php">
                            <button>Cerrar Sesion</button>
                        </a>
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