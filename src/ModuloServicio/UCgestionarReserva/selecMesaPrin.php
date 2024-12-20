<?php
class selecMesaPrin
{
    public function selecMesaPrinShow($fechaSeleccionada, $horaReserva, $mesa, $mesaPrincipalSeleccionada = null, $mesasSecundariasSeleccionadas = [])
    {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Selección de Mesas</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #111;
                    color: #fff;
                    margin: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;
                    height: 100vh;
                }
                .container {
                    text-align: center;
                    margin-top: 20px;
                }
                .mesa-container {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 10px;
                    justify-content: center;
                    margin: 20px auto;
                }
                .mesa-btn {
                    width: 80px;
                    height: 80px;
                    border: none;
                    border-radius: 10px;
                    font-size: 14px;
                    font-weight: bold;
                    cursor: pointer;
                    text-align: center;
                }
                .mesa-btn.libre {
                    background-color: green;
                    color: white;
                }
                .mesa-btn.ocupada {
                    background-color: red;
                    color: white;
                    cursor: not-allowed;
                }
                .mesa-btn.seleccionada {
                    background-color: orange;
                    color: black;
                    font-weight: bold;
                    border: 2px solid black;
                }
                .legend {
                    display: flex;
                    justify-content: center;
                    gap: 20px;
                    margin: 20px 0;
                }
                .legend-item {
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }
                .legend-color {
                    width: 20px;
                    height: 20px;
                    border-radius: 50%;
                }
                .legend-color.libre {
                    background-color: green;
                }
                .legend-color.ocupada {
                    background-color: red;
                }
                .legend-color.seleccionada {
                    background-color: orange;
                }
                .buttons {
                    display: flex;
                    justify-content: center;
                    gap: 20px;
                    margin-top: 20px;
                }
                .action-btn {
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    background-color: #333;
                    color: white;
                    font-size: 16px;
                    cursor: pointer;
                }
                .action-btn:hover {
                    background-color: #555;
                }
                .action-btn.disabled {
                    background-color: #777;
                    cursor: not-allowed;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Selecciona la Mesa Principal</h1>
                <form id="mesaForm" method="POST" action="/src/ModuloServicio/UCgestionarReserva/getReserva.php">
                    <div class="mesa-container">
                        <?php if (!empty($mesa)): ?>
                            <?php while ($fila = $mesa->fetch_assoc()): ?>
                                <button name="btnMesaPrincipal"
                                    class="mesa-btn <?= strtolower($fila['EstadoReserva']) ?> <?= ($fila['idMesa'] == $mesaPrincipalSeleccionada) ? 'seleccionada' : '' ?>"
                                    data-id="<?= $fila['idMesa'] ?>"
                                    <?= $fila['EstadoReserva'] === 'Ocupada' ? 'disabled' : '' ?>>
                                Mesa <?= $fila['idMesa'] ?>
                                </button>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <input type="hidden" name="idMesaSeleccionada" id="mesaSeleccionada" value="<?= $mesaPrincipalSeleccionada ?>">
                    <input type="hidden" name="fechaSeleccionada" value="<?= $fechaSeleccionada ?>">
                    <input type="hidden" name="horaReserva" value="<?= $horaReserva ?>">
                    <input type="hidden" name="mesasSecundariasSeleccionadas" id="mesasSecundariasSeleccionadas" value="<?= implode(',', $mesasSecundariasSeleccionadas) ?>">

                    <div class="buttons">
                        <button type="button" 
                                id="btnAgregarMesasSecundarias" 
                                onclick="window.location.href='?fecha=<?= $fechaSeleccionada ?>&hora=<?= $horaReserva ?>&mesaPrin=<?= $mesaPrincipalSeleccionada ?>&mostrarMesasSecundarias=true&mesasSecundariasSeleccionadas=' + encodeURIComponent(document.getElementById('mesasSecundariasSeleccionadas').value);" 
                                class="action-btn" 
                                style="display: <?= $mesaPrincipalSeleccionada ? 'inline-block' : 'none' ?>;">
                            Agregar mesas secundarias
                        </button>
                        <button type="button" onclick="window.location.href='/src/ModuloServicio/UCgestionarReserva/indexGestionarReserva.php?fecha=<?= $fechaSeleccionada ?>';" class="action-btn">
                            Cancelar operación
                        </button>
                        <button type="submit" name="btnUltimoForm" class="action-btn <?= !$mesaPrincipalSeleccionada ? 'disabled' : '' ?>" <?= !$mesaPrincipalSeleccionada ? 'disabled' : '' ?>>
                            Continuar
                        </button>
                    </div>
                </form>
            </div>
            <script>
                const buttons = document.querySelectorAll('.mesa-btn.libre');
                const btnAgregarMesasSecundarias = document.getElementById('btnAgregarMesasSecundarias');
                const inputMesa = document.getElementById('mesaSeleccionada');
                buttons.forEach(button => {
                    button.addEventListener('click', () => {
                        document.querySelectorAll('.mesa-btn').forEach(btn => btn.classList.remove('seleccionada'));
                        button.classList.add('seleccionada');
                        inputMesa.value = button.getAttribute('data-id');
                        btnAgregarMesasSecundarias.style.display = 'inline-block';
                    });
                });
            </script>
        </body>
        </html>
        <?php
    }
}
?>
<?php
class selecMesaPrin
{
    public function selecMesaPrinShow($fechaSeleccionada, $horaReserva, $mesa)
    {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Selección de Mesas</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #111;
                    color: #fff;
                    margin: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;
                    height: 100vh;
                }
                .container {
                    text-align: center;
                    margin-top: 20px;
                }
                .mesa-container {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 10px;
                    justify-content: center;
                    margin: 20px auto;
                }
                .mesa-btn {
                    width: 80px;
                    height: 80px;
                    border: none;
                    border-radius: 10px;
                    font-size: 14px;
                    font-weight: bold;
                    cursor: pointer;
                    text-align: center;
                }
                .mesa-btn.libre {
                    background-color: green;
                    color: white;
                }
                .mesa-btn.ocupada {
                    background-color: red;
                    color: white;
                    cursor: not-allowed;
                }
                .mesa-btn.espera {
                    background-color: yellow;
                    color: black;
                }
                .legend {
                    display: flex;
                    justify-content: center;
                    gap: 20px;
                    margin: 20px 0;
                }
                .legend-item {
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }
                .legend-color {
                    width: 20px;
                    height: 20px;
                    border-radius: 50%;
                }
                .legend-color.libre {
                    background-color: green;
                }
                .legend-color.ocupada {
                    background-color: red;
                }
                .legend-color.espera {
                    background-color: yellow;
                }
                .buttons {
                    display: flex;
                    justify-content: center;
                    gap: 20px;
                }
                .action-btn {
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    background-color: #333;
                    color: white;
                    font-size: 16px;
                    cursor: pointer;
                }
                .action-btn:hover {
                    background-color: #555;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Selecciona la mesa principal</h1>
                <div class="mesa-container">
                    <?php
                    while ($fila = $mesa->fetch_assoc()) {
                        $estadoClase = strtolower($fila['EstadoReserva']);
                        $estadoTexto = ucfirst($fila['EstadoReserva']);
                        ?>
                        <button class="mesa-btn <?= $estadoClase ?>" 
                                <?= $estadoClase == 'ocupada' ? 'disabled' : '' ?> 
                                onclick="seleccionarMesa(<?= $fila['idMesa'] ?>)">
                            Mesa <?= $fila['idMesa'] ?>
                        </button>
                        <?php
                    }
                    ?>
                </div>
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-color libre"></div> Libre
                    </div>
                    <div class="legend-item">
                        <div class="legend-color ocupada"></div> Ocupada
                    </div>
                </div>
                <div class="buttons">
                    <button class="action-btn" onclick="cancelarOperacion()">Cancelar operación</button>
                    <button class="action-btn" onclick="confirmarMesas()">Mesas listas</button>
                </div>
            </div>

            <script>
                function seleccionarMesa(idMesa) {
                    alert("Mesa seleccionada: " + idMesa);
                    // Aquí puedes enviar la selección al servidor o realizar otra acción
                }
                function cancelarOperacion() {
                    alert("Operación cancelada.");
                    // Aquí puedes redirigir al usuario a otra página si es necesario
                }
                function confirmarMesas() {
                    alert("Mesas confirmadas.");
                    // Aquí puedes enviar las mesas seleccionadas al servidor
                }
            </script>
        </body>
        </html>
        <?php
    }
}
?>
