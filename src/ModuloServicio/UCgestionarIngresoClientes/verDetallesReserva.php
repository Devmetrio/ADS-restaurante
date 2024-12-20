<?php
class verDetallesReserva
{
    public function mostrarDetalles($detallesReserva, $idMesa = null)
    {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Detalles de la Reserva</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
        </head>
        <body class="bg-dark text-light">
            <div class="container mt-5">
                <h1 class="text-center">Detalles de la Reserva</h1>
                <div class="card bg-secondary text-light mt-4">
                    <div class="card-body">
                        <p><strong>Cliente:</strong> <?php echo htmlspecialchars($detallesReserva['nombreCliente']); ?></p>
                        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($detallesReserva['fechaReserva']); ?></p>
                        <p><strong>Hora:</strong> <?php echo htmlspecialchars($detallesReserva['horaReserva']); ?></p>
                        <p><strong>Celular:</strong> <?php echo htmlspecialchars($detallesReserva['celularCliente']); ?></p>
                        <p><strong>Mesa Principal:</strong> <?php echo htmlspecialchars($detallesReserva['mesaPrincipal']); ?></p>
                        <p><strong>Estado:</strong> <?php echo htmlspecialchars($detallesReserva['estado']); ?></p>
                        <p><strong>Mesas Secundarias (opcional):</strong> 
                            <?php 
                            echo $detallesReserva['mesasSecundarias'] ? htmlspecialchars($detallesReserva['mesasSecundarias']) : 'N/A'; 
                            ?>
                        </p>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <form action="getIngreso.php" method="POST">
                        <button type="submit" class="btn btn-secondary" value="Regresar" name="btnRegresarPanel">Regresar</button>
                    </form>
                    <form action="/src/ModuloServicio/UCgestionarIngresoClientes/getIngreso.php?idReserva=<?= htmlspecialchars($detallesReserva['idReserva']) ?>" method="POST">
    <button class="btn btn-primary btn-accion" type="submit" name="btnConfirmarReserva">
        <i class="fas fa-check"></i> Confirmar llegada
    </button>
</form>

                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </body>
        </html>
        <?php
    }
}
?>