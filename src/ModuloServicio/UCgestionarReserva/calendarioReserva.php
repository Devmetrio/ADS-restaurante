<?php
class calendarioReserva
{
    public function calendarioReservaShow()
    {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Seleccionar Fecha</title>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                }

                body {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #f4f7fa;
                }

                h1 {
                    text-align: center;
                    margin-bottom: 20px;
                    color: #333;
                }

                form {
                    display: flex;
                    flex-direction: column;
                    width: 300px;
                    padding: 20px;
                    border: 1px solid #ccc;
                    border-radius: 8px;
                    background-color: white;
                }

                label {
                    margin-top: 10px;
                    font-size: 16px;
                    color: #555;
                }

                input {
                    margin-top: 5px;
                    padding: 10px;
                    font-size: 16px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    outline: none;
                }

                input[type="date"] {
                    width: 100%;
                }

                button {
                    margin-top: 20px;
                    padding: 10px;
                    background-color: #007bff;
                    color: white;
                    border: none;
                    cursor: pointer;
                    font-size: 16px;
                    border-radius: 4px;
                    transition: background-color 0.3s ease;
                }

                button:hover {
                    background-color: #0056b3;
                }

                .error-message {
                    color: red;
                    font-size: 14px;
                    margin-top: 10px;
                    text-align: center;
                }
            </style>
        </head>

        <body>
            <h1>Seleccione una Fecha para la Reserva</h1>
            <form action="/src/ModuloServicio/UCgestionarReserva/getReserva.php" method="POST">
                <label for="fecha">Fecha:</label>
                <input type="date" name="fechaSeleccionada">
                <button type="submit" name="btnSeleccionarFecha" value="btnSeleccionarFecha">Seleccionar Fecha</button>
            </form>

            <?php if (isset($mensajeError)) { ?>
                <div class="error-message"><?= $mensajeError ?></div>
            <?php } ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
        </body>
        
        </html>
<?php
    }
}
?>