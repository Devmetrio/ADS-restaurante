<?php

class seleccionMesas
{
    public function seleccionMesaShow($mesas = null)
    {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Listado de Mesas</title>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f8f9fa;
                    color: #333;
                }

                .container {
                    max-width: 800px;
                    margin: 20px auto;
                    padding: 20px;
                    background: #fff;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                }

                h1 {
                    text-align: center;
                    color: #444;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
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
                    background-color: #f4f4f4;
                }

                .loading {
                    text-align: center;
                    color: #888;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h1>Listado de Mesas</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Capacidad</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody id="mesas-tbody">
                        <?php if (empty($mesas)): ?>
                            <tr class="loading">
                                <td colspan="2">Cargando datos...</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($mesas as $mesa): ?>
                                <tr>
                                    <td><?= htmlspecialchars($mesa['id']); ?></td>
                                    <td><?= htmlspecialchars($mesa['nombre']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </body>
        <script>
            const conn = new WebSocket('ws://localhost:8080');
            const tbody = document.getElementById('mesas-tbody');
            let mesasActuales = {}; // Objeto para almacenar las mesas actuales y sus estados

            conn.onopen = function() {
                console.log("Conexión WebSocket establecida!");
                conn.send('Obtener mesas'); // Enviar petición inicial para obtener las mesas
            };

            conn.onmessage = function(event) {
                console.log("Datos recibidos del servidor:", event.data);

                // Verificar si el mensaje recibido es un simple string como "Cambiando estados"
                if (event.data === "Cambiando estados") {
                    // Recargar todos los datos de las mesas
                    conn.send('Obtener mesas');
                } else {
                    // Si no es un mensaje de actualización, procesar los datos de mesas
                    const mesas = JSON.parse(event.data);

                    if (mesas.length > 0 && Object.keys(mesasActuales).length === 0) {
                        renderizarMesas(mesas); // Renderizamos las mesas iniciales
                    }

                    // Procesar las notificaciones para actualizar el estado de las mesas
                    mesas.forEach(mesa => {
                        if (mesasActuales[mesa.idMesa]) {
                            mesasActuales[mesa.idMesa].estado = mesa.idMesaEstado; // Actualizamos el estado
                            const fila = document.getElementById(`mesa-${mesa.idMesa}`);
                            if (fila) {
                                fila.cells[2].textContent = mesa.idMesaEstado; // Actualizar el estado en la tabla
                            }
                        }
                    });
                }
            };

            conn.onerror = function(error) {
                console.error("Error en la conexión WebSocket:", error);
            };

            conn.onclose = function() {
                console.log("Conexión WebSocket cerrada.");
            };

            // Función para renderizar las mesas iniciales
            function renderizarMesas(mesas) {
                mesas.forEach(mesa => {
                    mesasActuales[mesa.idMesa] = {
                        ...mesa
                    }; // Guardamos la mesa en el objeto mesasActuales
                    const tr = document.createElement('tr');
                    tr.id = `mesa-${mesa.idMesa}`; // Asignamos un ID único para cada fila

                    const tdId = document.createElement('td');
                    const tdCapacidad = document.createElement('td');
                    const tdEstado = document.createElement('td');

                    tdId.textContent = mesa.idMesa;
                    tdCapacidad.textContent = mesa.capacidad;
                    tdEstado.textContent = mesa.idMesaEstado;

                    tr.appendChild(tdId);
                    tr.appendChild(tdCapacidad);
                    tr.appendChild(tdEstado);
                    tbody.appendChild(tr);
                });
            }
        </script>



        </html>
<?php
    }
}
