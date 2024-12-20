<?php
class ultimoFormReserva
{
    public function ultimoFormReservaShow($fecha, $hora, $mesaPrincipal, $mesasSecundarias)
    {
        ?>
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Reserva</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f5f5f5;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .form-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-container label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: #f7f7f7;
            color: #333;
        }

        .form-container input[readonly] {
            background-color: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
            <div class="form-container">
                <h1>Datos de Reserva</h1>
                <form method="POST" action="/src/ModuloServicio/UCgestionarReserva/getReserva.php">
                    <label for="fecha">Fecha:</label>
                    <input type="text" id="fecha" name="fecha" value="<?= htmlspecialchars($fecha) ?>" readonly>

                    <label for="hora">Hora:</label>
                    <input type="text" id="hora" name="hora" value="<?= htmlspecialchars($hora) ?>" readonly>

                    <label for="mesaPrincipal">Mesa Principal:</label>
                    <input type="text" id="mesaPrincipal" name="mesaPrincipal" value="<?= htmlspecialchars($mesaPrincipal) ?>" readonly>

                    <label for="mesasSecundarias">Mesas Secundarias:</label>
                    <input type="text" id="mesasSecundarias" name="mesasSecundariasSeleccionadas" value="<?= htmlspecialchars($mesasSecundarias) ?: 'N/A' ?>" readonly>

                    <label for="cliente">Nombre del Cliente:</label>
                    <input type="text" id="cliente" name="cliente" placeholder="Ingrese su nombre">

                    <label for="celular">Número de Celular:</label>
                    <input type="text" id="celular" name="celular" placeholder="Ingrese su número de celular">

                    <button type="submit" name="btnGenerarReserva">Confirmar Reserva</button>
                </form>
            </div>
        </body>
</html>

        <?php
    }
}
?>
