<?php

class ordenMesa
{
    function ordenMesaShow($categoria = null, $menu = null, $idControl = null, $idMesa = null, $orden = null, $idOrden = null)
    {


?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gestión de Restaurante</title>
            <link rel="stylesheet" href="/src/assets/ordenMesa.css">
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <script src="/src/assets/orden.js" defer></script>
        </head>

        <body>
            <div class="container" id="content">
                <header class="header">
                    <h1>Orden de la Mesa</h1>
                </header>

                <section class="content">
                    <!-- SECCIÓN DE LA ORDEN DE MESA (Tabla) -->
                    <div class="table-section">
                        <h2>MESA <?= $idMesa ?></h2>
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Plato</th>
                                    <th>Descripción</th>
                                    <th>Subtotal</th>
                                    <th>Cantidad</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($orden && count($orden) > 0): ?>
                                    <?php foreach ($orden as $index => $detalle): ?>
                                        <tr>
                                            <td><?= $index + 1; ?></td>
                                            <td><?= htmlspecialchars($detalle['NombrePlato']); ?></td>
                                            <td><?= htmlspecialchars($detalle['Descripcion']); ?></td>
                                            <td>s/ <?= number_format((float)$detalle['Subtotal'], 2); ?></td>
                                            <td style="width: 5%; min-width: 30px;"><?= (int)$detalle['Cantidad']; ?></td>
                                            <td><button class="delete-btn" disabled></button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6">¡Presiona las categorías para comenzar la comanda!</td>
                                    </tr>
                                <?php endif; ?>
                                <!-- Aquí se llenará dinámicamente con JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- SECCIÓN DEL MENÚ -->
                    <div class="menu-section">
                        <div class="categories-container">
                            <h2>Categorías</h2>
                            <div class="categories">
                                <?php if ($categoria) {
                                    foreach ($categoria as $cat) { ?>
                                        <button class="category-btn" onclick="guardarComanda();cambiarCategoria(<?= $cat['idTipoMenu'] ?>, '<?= $idControl ?>', '<?= $idMesa ?>', '<?= $idOrden ?>')">
                                            <div class="category-content">
                                                <span class="category-name"><?= htmlspecialchars($cat['tipoNombre']) ?></span>
                                                <img src="/src/assets/images/categoria<?= $cat['idTipoMenu'] ?>.svg" alt="Ícono de <?= htmlspecialchars($cat['tipoNombre']) ?>" class="category-icon">
                                            </div>
                                        </button>
                                    <?php }
                                } else { ?>
                                    <p>Cargando categorias...</p>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="menu-container">
                            <h2>Platos del menú:</h2>
                            <div class="menu-items">
                                <?php if ($menu) {
                                    foreach ($menu as $item) { ?>
                                        <button class="menu-item" onclick="agregarAComanda(<?= $item['idItem'] ?>, '<?= htmlspecialchars($item['nombre']) ?>', '<?= htmlspecialchars($item['descripcion']) ?>', <?= $item['precio'] ?>)">
                                            <span><?= htmlspecialchars($item['nombre']) ?></span>
                                        </button>
                                    <?php }
                                } else { ?>
                            </div>
                            <p>Presione una categoría para listar el menú disponible.</p>
                        <?php } ?>
                        </div>
                    </div>
                </section>

                <footer class="footer">
                    <button class="action-btn" onclick="limpiarComanda()">Limpiar</button>
                    <button class="action-btn" onclick="limpiarComanda(); location.href='/src/ModuloServicio/UCgenerarPedidoPlato/indexPanelOrdenes.php'">Regresar al panel</button>
                    <form action="getPedidos.php" method="POST" onsubmit="prepararComanda()">
                        <input type="hidden" value="<?= $idControl ?>" name="idControl">
                        <input type="hidden" id="comandaInput" name="comanda">
                        <input type="hidden" value="<?= $idMesa ?>" name="idMesa">
                        <button class="action-btn" name="btnEnviar" value="EnviarOrden">Enviar</button>
                    </form>
                </footer>
            </div>
            <script>
                function cambiarCategoria(categoriaId, idControl, idMesa, idOrden) {
                    fetch(`/src/ModuloServicio/UCgenerarPedidoPlato/indexOrdenMesa.php?categoria=${categoriaId}&idControl=${idControl}&idMesa=${idMesa}&orden=${idOrden}`)
                        .then(response => response.text())
                        .then(html => {
                            const content = document.getElementById('content'); // Contenedor principal
                            if (content) {
                                content.innerHTML = html; // Reemplaza solo el contenido del contenedor
                                actualizarTabla();
                            } else {
                                console.error("No se encontró el contenedor con id 'content'.");
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            </script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
        </body>

        </html>

<?php
    }
}
?>