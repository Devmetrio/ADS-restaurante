<?php
class gestionarReserva
{
    public function gestionarReservaShow($reservas, $fecha)
    {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gestión de Reservas</title>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #222;
                    color: white;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .container {
                    width: 80%;
                    max-width: 800px;
                    background: #333;
                    padding: 30px;
                    border-radius: 8px;
                    box-shadow: 0px 0px 15px #000;
                }
                .logout-container {
                    width: 100%;
                    display: flex;
                    justify-content: flex-end;
                    padding: 10px 20px;
                }
                .logout-link {
                    color: white;
                    text-decoration: none;
                    background-color: #d9534f;
                    padding: 8px 12px;
                    border-radius: 5px;
                    transition: background 0.3s ease;
                }
                .logout-link:hover {
                    background-color: #c9302c;
                }
                h1 {
                    text-align: center;
                    margin-bottom: 30px;
                    font-size: 24px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 10px 0;
                    background-color: #444;
                    border-radius: 8px;
                    overflow: hidden;
                }
                th, td {
                    padding: 15px;
                    text-align: center;
                    border-bottom: 1px solid #555;
                }
                th {
                    background-color: #555;
                    color: white;
                    font-size: 16px;
                }
                td {
                    font-size: 14px;
                }
                tr:nth-child(even) {
                    background-color: #333;
                }
                tr:hover {
                    background-color: #555;
                }
                button {
                    background-color: #007bff;
                    color: white;
                    border: none;
                    padding: 8px 12px;
                    cursor: pointer;
                    border-radius: 5px;
                    margin: 5px;
                    transition: background 0.3s ease;
                }
                button:hover {
                    background-color: #0056b3;
                }
                .btn-container {
                    display: flex;
                    justify-content: center;
                    gap: 10px;
                    margin-top: 30px;
                }
                .no-reservations {
                    color: #ff4d4d;
                    font-size: 16px;
                    text-align: center;
                    margin-top: 20px;
                }
                .search-bar {
                    display: flex;
                    justify-content: center;
                    margin-bottom: 20px;
                    gap: 10px;
                }
                .search-bar input {
                    padding: 8px;
                    border: 1px solid #555;
                    border-radius: 5px;
                    background-color: #444;
                    color: white;
                }
                .search-bar button {
                    padding: 8px 12px;
                }
            </style>
        </head>
        <body>
            <div class="logout-container">
                <a class="logout-link" href="/src/ModuloSeguridad/UCautenticarUsuario/cerrarSesion.php">Cerrar Sesión</a>
            </div>
            <div class="container">
                <h1>Gestión de Reservas</h1>
                

                <!-- Barra de búsqueda -->
                <form action="/src/ModuloServicio/UCgestionarIngresoClientes/getIngreso.php" method="POST" class="search-bar">
                    <input type="text" name="busqueda" placeholder="Buscar reserva">
                    <button type="submit">Buscar</button>
                </form>


                <h2>Reservas para el <?php echo $fecha; ?></h2>
                <table>
                    <tr>
                        <th>Hora</th>
                        <th>Cliente</th>
                        <th>Mesa principal</th>
                        <th>Mesas adicionales</th>
                        <th>Acciones</th>
                    </tr>
                    <?php if ($reservas && $reservas->num_rows > 0): ?>
                        <?php while ($reserva = $reservas->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $reserva['horaReserva']; ?></td>
                                <td><?php echo $reserva['nombreCliente']; ?></td>
                                <td><?php echo $reserva['idMesa']; ?></td>
                                <td><?php echo $reserva['mesasecundarias'] ? $reserva['mesasecundarias'] : 'N/A'; ?></td>
                                <td>
                                    <!-- Botón Ver Detalles -->
                                    <form action="/src/ModuloServicio/UCgestionarIngresoClientes/getIngreso.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="idReserva" value="<?php echo $reserva['idReserva']; ?>">
                                        <button type="submit">Ver Detalles</button>
                                    </form>
                                    <!-- Botón adicional -->
                                    <form action="/src/ModuloServicio/UCgestionarReserva/getReserva.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="idReserva" value="<?php echo $reserva['idReserva']; ?>">
                                        <button type="submit">Cancelar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-reservations">No hay reservas en curso para esta fecha.</td>
                        </tr>
                    <?php endif; ?>
                </table>
                <div class="btn-container">
                    <!-- Primer formulario -->
                    <form action="/src/ModuloServicio/UCgestionarReserva/getReserva.php" method="POST">
                        <input type="hidden" value="<?=$fecha ?>" name="fechaSeleccionada">
                        <button type="submit" name="btnAgregarReserva">Agregar reserva</button>
                    </form>
                    <button type="button" onclick="window.location.href='indexCalendarioReserva.php';">Calendario</button>
                    <!-- Segundo formulario -->
                    <form action="/src/ModuloServicio/UCgestionarIngresoClientes/getIngreso.php" method="POST">
                        <button type="submit">Mesas</button>
                    </form>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
        </body>
        </html>
        <?php
    }
}
?>
