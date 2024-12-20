<?php
class formHoraReserva
{
    public function formHoraReservaShow($fechaSeleccionada)
    {
        // Obtener la fecha pasada por GET
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
            <title>Ingreso de datos</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    font-family: Arial, sans-serif;
                }

                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #222;
                    color: white;
                }

                .container {
                    background-color: #333;
                    border-radius: 8px;
                    padding: 20px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                    text-align: center;
                    width: 350px;
                }

                h1 {
                    margin-bottom: 20px;
                    font-size: 24px;
                }

                label {
                    display: block;
                    margin: 10px 0 5px;
                    font-size: 14px;
                }

                input {
                    width: 100%;
                    padding: 8px;
                    border-radius: 4px;
                    border: 1px solid #555;
                    background-color: #222;
                    color: white;
                }

                button {
                    margin-top: 15px;
                    padding: 10px;
                    background-color: #007bff;
                    border: none;
                    color: white;
                    font-size: 14px;
                    border-radius: 4px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                }

                button:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Ingreso de datos</h1>
                <form method="POST" action="/src/ModuloServicio/UCgestionarReserva/getReserva.php">
                    <label for="fecha">Fecha:</label>
                    <input type="text" id="fecha" name="fechaSeleccionada" value="<?php echo $fechaSeleccionada; ?>" readonly required>
                    <label for="hora">Hora:</label>
                    <input type="time" id="horaReserva" name="horaReserva" required>
                    <label for="personas">Nº Personas:</label>
                    <input type="number" id="cantidadPersonas" name="cantidadPersonas" min="1" max="200"required>

                    <button type="submit" name="btnHoraCantidad" value="btnHoraCantidad">Siguiente</button>
                </form>
            </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
        </body>
        </html>
        <?php
    }
}
?>
