<?php
class seleccionMesas
{
    public function seleccionMesaShow($id = null, $array = null)
    {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Selección de Mesas</title>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #FCE4D6;
                    /* Fondo cálido */
                    color: #4E342E;
                    /* Texto cálido */
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                }

                .container {
                    text-align: center;
                }

                h1 {
                    margin-bottom: 20px;
                    color: #8D6E63;
                    /* Título cálido */
                }

                .mesas-grid {
                    display: grid;
                    grid-template-columns: repeat(4, 100px);
                    gap: 15px;
                    justify-content: center;
                }

                .mesa {
                    width: 100px;
                    height: 100px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-direction: column;
                    border-radius: 8px;
                    border: 2px solid #A1887F;
                    /* Borde cálido */
                    font-size: 14px;
                    font-weight: bold;
                    cursor: pointer;
                    background-color: #4CAF50;
                    /* Verde más oscuro */
                    color: #fff;
                    /* Texto blanco */
                }

                .mesa.ocupado {
                    background-color: #F44336;
                    /* Mantiene el color de ocupado */
                }

                .mesa.espera {
                    background-color: #FFEB3B;
                    /* Mantiene el color de espera */
                    color: #000;
                    /* Texto negro */
                }

                .legend {
                    display: flex;
                    justify-content: center;
                    margin-top: 20px;
                    gap: 15px;
                }

                .legend-item {
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }

                .legend-item span {
                    width: 20px;
                    height: 20px;
                    display: inline-block;
                    border-radius: 50%;
                }

                .legend-item .libre {
                    background-color: #388E3C;
                    /* Verde más oscuro para la leyenda */
                }

                .legend-item .ocupado {
                    background-color: #F44336;
                    /* Mantiene el color de ocupado */
                }

                .legend-item .espera {
                    background-color: #FFEB3B;
                    /* Mantiene el color de espera */
                }

                .btn-action {
                    margin-top: 20px;
                    padding: 10px 20px;
                    font-size: 16px;
                    background-color: #FFAB91;
                    /* Botón cálido */
                    color: #4E342E;
                    /* Texto cálido */
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                }

                .btn-action:hover {
                    background-color: #FF7043;
                    /* Hover cálido */
                }

                .mesa.select {
                    border: 3px solid #FF5722;
                    /* Borde cálido para seleccionado */
                    background-color: #FF8A65;
                    /* Fondo cálido para seleccionado */
                    color: #4E342E;
                    /* Texto cálido para seleccionado */
                }
            </style>

        </head>

        <body>
            <div class="container">
                <h1>Selección de Mesas</h1>
                <?php if ($array !== null) : ?>
                    <h2>Mesas a juntar: <?= $array ?> </h2>
                <?php endif; ?>
                <form action="getPedidos.php" method="POST">
                    <input type="hidden" name="idMesa" value="">
                    <input type="hidden" name="capacidad" value="">
                    <div class="mesas-grid" id="mesas-grid">
                        <!-- Botones de mesas generados dinámicamente -->
                    </div>
                </form>
                <div class="legend">
                    <div class="legend-item">
                        <span class="libre"></span> Libre
                    </div>
                    <div class="legend-item">
                        <span class="ocupado"></span> Ocupado
                    </div>
                    <div class="legend-item">
                        <span class="espera"></span> En espera
                    </div>
                </div>
                <form action="getPedidos.php" method="POST">
                    <?php if ($id !== null) : ?>
                        <button class="btn-action" type="submit" value="Cancelar" name="btnCancelarSelec">Cancelar seleccion</button>
                        <button class="btn-action" type="submit" value="Juntar" name="btnJuntarMesas">Juntar Mesas</button>
                        <button class="btn-action" type="submit" value="Iniciar" name="btnIniciar">Iniciar Orden</button>
                        <input type="hidden" value="<?= $array ?>" name="mesasSecundarias">
                        <input type="hidden" value="<?= $id ?>" name="idMesa">
                    <?php endif; ?>
                </form>
                <button class="btn-action" onclick="window.location.href='indexPanelOrdenes.php'">Regresar</button>
            </div>
        </body>
        <script>
            const idSeleccionado = <?= json_encode($id) ?>;
            const conn = new WebSocket('ws://localhost:8080');
            const mesasGrid = document.getElementById('mesas-grid');
            const mesasActuales = {};

            conn.onopen = function() {
                console.log("Conexión WebSocket establecida!");
                conn.send('Obtener mesas');
            };

            conn.onmessage = function(event) {
                console.log("Datos recibidos del servidor:");

                if (event.data === "Cambiando estados") {
                    conn.send('Obtener mesas');
                } else {
                    const mesas = JSON.parse(event.data);
                    renderizarMesas(mesas);
                }
            };

            conn.onerror = function(error) {
                console.error("Error en la conexión WebSocket:", error);
            };

            conn.onclose = function() {
                console.log("Conexión WebSocket cerrada.");
            };

            function renderizarMesas(mesas) {
                mesasGrid.innerHTML = ""; // Limpia las mesas actuales

                mesas.forEach(mesa => {
                    // Crear botón para la mesa
                    const button = document.createElement('button');
                    button.classList.add('mesa');
                    button.type = 'button'; // No envía el formulario directamente
                    button.dataset.idMesa = mesa.idMesa; // Guardar idMesa en un atributo
                    button.dataset.capacidad = mesa.capacidad; // Guardar capacidad en un atributo
                    button.name = "btnMesaEnviada";
                    button.value = "Mesa";
                    button.type = "submit";
                    // Contenido del botón
                    const mesaInfo = document.createElement('div');
                    mesaInfo.style.textAlign = 'center';

                    const mesaNombre = document.createElement('div');
                    mesaNombre.textContent = `Mesa ${mesa.idMesa}`;
                    mesaInfo.appendChild(mesaNombre);

                    const mesaCapacidad = document.createElement('div');
                    mesaCapacidad.textContent = `Capacidad: ${mesa.capacidad}`;
                    mesaInfo.appendChild(mesaCapacidad);

                    button.appendChild(mesaInfo);

                    // Estilo según el estado
                    if (mesa.idMesaEstado == 1) {
                        button.classList.add('libre');
                        button.value = 0;
                    } else if (mesa.idMesaEstado == 2) {
                        button.classList.add('espera');
                        button.value = 1;
                    } else if (mesa.idMesaEstado == 3) {
                        button.value = 0;
                        button.classList.add('ocupado');
                    }

                    // Marcar la mesa seleccionada
                    if (mesa.idMesa == idSeleccionado) {
                        button.classList.add('select');
                    }

                    // Evento click para actualizar los inputs ocultos y enviar el formulario
                    button.addEventListener('click', function() {
                        // Actualizar inputs ocultos en el formulario principal
                        document.querySelector('input[name="idMesa"]').value = this.dataset.idMesa;
                        document.querySelector('input[name="capacidad"]').value = this.dataset.capacidad;
                    });

                    // Agregar el botón al grid
                    mesasGrid.appendChild(button);
                });
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

        </html>
<?php
    }
}
?>