<?php
class formComprobantePago
{
    public function formComprobantePagoShow($idMesa, $idControlOrden, $idUsuario, $total)
    {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Formulario de Pago</title>
            <style>
                body {
                    font-family: sans-serif;
                    margin: 20px;
                }

                h2 {
                    text-align: center;
                    margin-bottom: 20px;
                }

                .formulario-boleta,
                .formulario-factura {
                    display: none;
                }

                .activo {
                    display: block;
                }

                label {
                    display: block;
                    margin-bottom: 10px;
                }

                input[type="text"],
                input[type="number"] {
                    width: 100%;
                    padding: 8px;
                    margin-bottom: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }

                input[disabled] {
                    background-color: #f5f5f5;
                    cursor: not-allowed;
                }

                button {
                    background-color: #4CAF50;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }

                button:hover {
                    background-color: #45a049;
                }
            </style>
        </head>

        <body>
            <form action="/src/ModuloServicio/UCgenerarComprobanteDePago/getComprobante.php" method="POST">
                <h2>Formulario de Pago</h2>
                <p>ID Control Orden: <?= $idControlOrden ?></p>
                <p>Mesa: <?= $idMesa ?></p>
                <p>Usuario: <?= $idUsuario ?></p>
                <p>Total: <?= $total ?></p>
                

                <div>
                    <label><input type="radio" name="tipoComprobante" value="boleta" checked> Boleta</label>
                    <label><input type="radio" name="tipoComprobante" value="factura"> Factura</label>
                </div>

                <div class="formulario-boleta activo">
                    <label for="dni">DNI:</label>
                    <input type="number" id="dni" name="dni">
                </div>

                <div class="formulario-factura">
                    <label for="ruc">RUC:</label>
                    <input type="number" id="ruc" name="ruc">
                    <label for="razonSocial">Razón Social:</label>
                    <input type="text" id="razonSocial" name="razonSocial">
                </div>
                <input type="hidden" name="idMesa" value="<?= htmlspecialchars($idMesa); ?>">
                <input type="hidden" name="idControlOrden" value="<?= htmlspecialchars($idControlOrden); ?>">
                <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($idUsuario); ?>">
                <button type="submit" name="btnImprimir">Imprimir</button>

            </form>
            <form action="/src/ModuloServicio/UCgenerarComprobanteDePago/getComprobante.php" method="POST">

                <input type="hidden" name="idMesa" value="<?= htmlspecialchars($idMesa); ?>">
                <input type="hidden" name="idControlOrden" value="<?= htmlspecialchars($idControlOrden); ?>">
                <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($idUsuario); ?>">
                <button type="submit" name="btnRegresarAlPanel">Regresar al panel</button>
            </form>
            <script>
                const radios = document.querySelectorAll('input[name="tipoComprobante"]');
                const boletaForm = document.querySelector('.formulario-boleta');
                const facturaForm = document.querySelector('.formulario-factura');
                const dniInput = document.getElementById('dni');
                const rucInput = document.getElementById('ruc');
                const razonSocialInput = document.getElementById('razonSocial');

                // Inicialmente deshabilitar los campos de pago


                // Cambiar entre boleta y factura
                radios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        const isBoleta = radio.value === 'boleta';

                        boletaForm.classList.toggle('activo', isBoleta);
                        facturaForm.classList.toggle('activo', !isBoleta);

                        // Limpiar campos al cambiar de tipo de comprobante
                        if (isBoleta) {
                            rucInput.value = '';
                            razonSocialInput.value = '';
                        } else {
                            dniInput.value = '';
                        }
                    });
                });

                // Habilitar campos de pago al enfocar
                document.addEventListener('input', () => {
                    montoEfectivo.disabled = false;
                    montoTarjeta.disabled = false;
                });
            </script>
        </body>

        </html>
<?php
    }
}
