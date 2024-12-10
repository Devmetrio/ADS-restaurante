<?php

class ordenMesa
{
    function ordenMesaShow($idMesa=null, $categoria=null, $menu = null, $idControl=null)
    {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gestión de Restaurante</title>
            <link rel="stylesheet" href="/src/assets/ordenMesa.css">
            <script src="/src/assets/orden.js" defer></script>
        </head>

        <body>
            <div class="container">
                <header class="header">
                    <h1>Orden de la Mesa</h1>
                    <?= $idControl?>
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
                                    <button class="category-btn" onclick="guardarComanda(); location.href='/src/ModuloServicio/UCgenerarPedidoPlato/indexOrdenMesa.php?categoria=<?= $cat['idTipoMenu'] ?>'">
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
                                    <p>Presione una categoría para listar el menú disponible.</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </section>

                <footer class="footer">
                    <button class="action-btn" onclick="limpiarComanda()">Limpiar</button>
                    <form action="getPedidos.php" method="POST" onsubmit="prepararComanda()">
                        <input type="hidden" value="<?= $idControl ?>" name="idControl">
                        <input type="hidden" id="comandaInput" name="comanda">
                        <input type="hidden" value="<?= $idMesa ?>" name="idMesa">
                        <button class="action-btn" name="btnEnviar" value="EnviarOrden">Enviar</button>
                    </form>
                </footer>
            </div>
        </body>

        </html>

<?php
    }
}
?>