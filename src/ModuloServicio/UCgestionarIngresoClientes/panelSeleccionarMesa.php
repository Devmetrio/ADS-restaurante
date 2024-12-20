<?php
class seleccionarMesa
{
    public function panelseleccionarMesaShow()
    {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Selección de Mesas</title>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #222;
                    color: #fff;
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
                    border: 2px solid #444;
                    font-size: 14px;
                    font-weight: bold;
                    cursor: pointer;
                    background-color: #4CAF50;
                    color: #fff;
                    transition: transform 0.2s, background-color 0.3s;
                }

                .mesa.ocupado {
                    background-color: #F44336;
                }

                .mesa.espera {
                    background-color: #FFEB3B;
                    color: #000;
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
                    background-color: #4CAF50;
                }

                .legend-item .ocupado {
                    background-color: #F44336;
                }

                .legend-item .espera {
                    background-color: #FFEB3B;
                }

                /* Estilo para el botón "Ocupar" */
                .btn-ocupar {
                    background-color: #FF5733;
                    color: white;
                    border: none;
                    width: 40px; /* Tamaño reducido */
                    height: 40px; /* Tamaño reducido */
                    border-radius: 8px; /* Bordes ligeramente redondeados */
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    font-size: 20px; /* Tamaño del ícono ajustado */
                    cursor: pointer;
                    transition: background-color 0.3s, transform 0.2s;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
                    margin-top: 5px; /* Ajuste para centrar mejor */
                }

                .btn-ocupar:hover {
                    background-color: #C0392B;
                    transform: scale(1.1);
                    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
                }

                .btn-ocupar:active {
                    transform: scale(0.98);
                }

                .btn-ocupar:focus {
                    outline: none;
                    box-shadow: 0 0 0 3px rgba(255, 87, 51, 0.5);
                }

                /* Ícono */
                .btn-ocupar i {
                    font-size: 18px; /* Tamaño del ícono más pequeño */
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h1>Selección de Mesas</h1>
                <form action="getIngreso.php" method="POST" name="btncambiarestadoMesa">
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

                <!-- Botón Regresar -->
                <form action="getIngreso.php" method="POST">
                    <button type="submit" name="btnRegresarPanel" class="btn-regresar">Regresar</button>
                </form>
            </div>
        </body>

        <script>
            const conn = new WebSocket('ws://localhost:8080');
            const mesasGrid = document.getElementById('mesas-grid');
            const mesasActuales = {};

            conn.onopen = function () {
                console.log("Conexión WebSocket establecida!");
                conn.send('Obtener mesas');
            };

            conn.onmessage = function (event) {
                console.log("Datos recibidos del servidor:");

                if (event.data === "Cambiando estados") {
                    conn.send('Obtener mesas');
                } else {
                    const mesas = JSON.parse(event.data);
                    renderizarMesas(mesas);
                }
            };

            conn.onerror = function (error) {
                console.error("Error en la conexión WebSocket:", error);
            };

            conn.onclose = function () {
                console.log("Conexión WebSocket cerrada.");
            };

            function renderizarMesas(mesas) {
                mesasGrid.innerHTML = ""; // Limpia las mesas actuales

                mesas.forEach(mesa => {
                    // Crear botón principal de la mesa
                    const button = document.createElement('button');
                    button.classList.add('mesa');
                    button.type = 'submit'; // Enviar el formulario
                    button.name = 'btncambiarestadoMesa'; // Nombre del botón
                    button.value = mesa.idMesa; // ID de la mesa

                    // Crear inputs hidden para enviar los datos
                    const form = document.createElement('form');
                    form.action = 'getIngreso.php';
                    form.method = 'POST';

                    const inputIdMesa = document.createElement('input');
                    inputIdMesa.type = 'hidden';
                    inputIdMesa.name = 'idMesa';
                    inputIdMesa.value = mesa.idMesa;

                    const inputEstadoMesa = document.createElement('input');
                    inputEstadoMesa.type = 'hidden';
                    inputEstadoMesa.name = 'estadoMesa';
                    inputEstadoMesa.value = mesa.idMesaEstado;

                    form.appendChild(inputIdMesa);
                    form.appendChild(inputEstadoMesa);
                    form.appendChild(button);

                    // Contenido del botón principal
                    const mesaInfo = document.createElement('div');
                    mesaInfo.style.textAlign = 'center';

                    const mesaNombre = document.createElement('div');
                    mesaNombre.textContent = `Mesa ${mesa.idMesa}`;
                    mesaInfo.appendChild(mesaNombre);

                    const mesaCapacidad = document.createElement('div');
                    mesaCapacidad.textContent = `Capacidad: ${mesa.capacidad}`;
                    mesaInfo.appendChild(mesaCapacidad);

                    // Crear un nuevo botón con el ícono de "X"
                    const botonRojo = document.createElement('button');
                    botonRojo.classList.add('btn-ocupar'); // Añadimos el estilo elegante al botón
                    botonRojo.name = 'btncambiarestadoicono'; // Atributo name como lo solicitaste

                    // Añadir el ícono "X" de Font Awesome al botón
                    const iconoX = document.createElement('i');
                    iconoX.classList.add('fas', 'fa-times'); // "fas" es el estilo para íconos sólidos, y "fa-times" es la clase para el ícono de la "X"
                    botonRojo.appendChild(iconoX);

                    // Agregar evento al botón rojo
                    botonRojo.addEventListener('click', (event) => {
                        event.stopPropagation(); // Evitar que se dispare el evento del botón principal

                        // Hacer una solicitud POST al servidor con la ID de la mesa
                        fetch('getIngreso.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `idMesa=${mesa.idMesa}`
                        })
                            .then(response => response.text())
                            .then(data => {
                                // Aquí podrías manejar la respuesta del servidor si es necesario
                            })
                            .catch(error => {
                                console.error('Error en la solicitud:', error);
                            });
                    });

                    mesaInfo.appendChild(botonRojo); // Agregar el botón rojo dentro de la info de la mesa
                    button.appendChild(mesaInfo);

                    // Estilo según el estado
                    if (mesa.idMesaEstado == 1) {
                        button.classList.add('libre');
                    } else if (mesa.idMesaEstado == 2) {
                        button.classList.add('espera');
                    } else if (mesa.idMesaEstado == 3) {
                        button.classList.add('ocupado');
                    }

                    // Agregar el formulario al grid
                    mesasGrid.appendChild(form);
                });
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

        </html>
<?php
    }
}
?>
