<?php
class selecMesaSec
{
    public function selecMesaSecShow($fechaSeleccionada, $horaReserva, $mesaPrincipal, $mesasSecundarias)
    {
        ?>
        <div id="modalMesasSecundarias" style="display: block; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); z-index: 1000; color: white;">
            <div style="width: 80%; margin: 50px auto; background: #222; padding: 20px; border-radius: 8px; position: relative;">
                <h2>Seleccionar Mesas Secundarias</h2>
                <form id="mesasSecundariasForm" action="/src/ModuloServicio/UCgestionarReserva/getReserva.php" method="POST">
                    <div class="mesas-container">
                        <?php foreach ($mesasSecundarias as $mesa): ?>
                            <div class="mesa-item" data-id="<?= $mesa['idMesa'] ?>" data-capacidad="<?= $mesa['capacidad'] ?>">
                                Mesa <?= $mesa['idMesa'] ?> - Capacidad <?= $mesa['capacidad'] ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="mesasSecundariasSeleccionadas" id="mesasSeleccionadasInput">
                    <input type="hidden" name="fechaSeleccionada" value="<?= $fechaSeleccionada ?>">
                    <input type="hidden" name="horaReserva" value="<?= $horaReserva ?>">
                    <input type="hidden" name="mesaPrincipal" value="<?= $mesaPrincipal ?>">
                    <div style="margin-top: 20px;">
                        <button type="submit" name="btnConfirmarMesasSecundarias" class="action-btn">Confirmar</button>
                        <button type="button" onclick="document.getElementById('modalMesasSecundarias').style.display='none';" class="action-btn">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        <style>
            .mesas-container {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                justify-content: center;
                margin: 20px 0;
            }
            .mesa-item {
                background-color: #444;
                color: white;
                padding: 10px 15px;
                border-radius: 8px;
                cursor: pointer;
                text-align: center;
                transition: background-color 0.3s ease;
            }
            .mesa-item.selected {
                background-color: orange;
                color: black;
                font-weight: bold;
            }
            .action-btn {
                background-color: #007bff;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
                margin: 5px;
            }
            .action-btn:hover {
                background-color: #0056b3;
            }
        </style>

        <script>
            const mesas = document.querySelectorAll('.mesa-item');
            const mesasSeleccionadasInput = document.getElementById('mesasSeleccionadasInput');

            let mesasSeleccionadas = [];

            mesas.forEach(mesa => {
                mesa.addEventListener('click', () => {
                    const mesaId = mesa.getAttribute('data-id');

                    // Alternar selección
                    if (mesa.classList.contains('selected')) {
                        mesa.classList.remove('selected');
                        mesasSeleccionadas = mesasSeleccionadas.filter(id => id !== mesaId);
                    } else {
                        mesa.classList.add('selected');
                        mesasSeleccionadas.push(mesaId);
                    }

                    // Actualizar input oculto
                    mesasSeleccionadasInput.value = mesasSeleccionadas.join(',');
                    console.log('Mesas seleccionadas:', mesasSeleccionadas); // Depuración
                });
            });
        </script>
        <?php
    }
}
?>