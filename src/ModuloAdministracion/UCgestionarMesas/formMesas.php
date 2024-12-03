<?php

class formMesas
{
    public function formMesasShow()
    {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Formulario - Agregar Mesa</title>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #2c3e50;
                    /* Color empresarial */
                    color: #ecf0f1;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }

                .form-container {
                    background-color: #34495e;
                    /* Fondo del formulario */
                    padding: 20px 30px;
                    border-radius: 10px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
                    width: 420px;
                }

                .form-container h2 {
                    margin: 0 0 20px;
                    font-size: 32px;
                    text-align: center;
                    color: #1abc9c;
                    /* Verde empresarial */
                }

                .form-group label {
                    font-weight: bold;
                }

                .form-check-inline {
                    display: inline-block;
                    margin-right: 15px;
                }

                .form-check-label {
                    margin-left: 5px;
                }

                .form-select,
                .form-check-input {
                    background-color: #2c3e50;
                    color: #ecf0f1;
                    border: 1px solid #1abc9c;
                }

                .form-select:focus,
                .form-check-input:focus {
                    border-color: #16a085;
                    box-shadow: none;
                }

                .form-actions {
                    display: flex;
                    justify-content: space-between;
                }

                .btn {
                    width: 48%;
                    padding: 10px;
                    border-radius: 5px;
                    font-size: 14px;
                    cursor: pointer;
                    transition: background-color 0.3s ease;
                }

                .btn-primary {
                    background-color: #1abc9c;
                    color: #ffffff;
                }

                .btn-primary:hover {
                    background-color: #16a085;
                }

                .btn-danger {
                    background-color: #e74c3c;
                    color: #ffffff;
                }

                .btn-danger:hover {
                    background-color: #c0392b;
                }

                hr{
                    border: 2px solid #1abc9c;
                }
            </style>
        </head>

        <body>
            <div class="form-container">
                <h2>Agregar Mesa</h2>
                <hr >
                <form action="/src/ModuloAdministracion/UCgestionarMesas/getMesas.php" method="POST">
                    <div class="form-group mb-3 mt-4">
                        <label for="capacidad" class="mb-2">Capacidad:</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="capacidad" id="capacidad2" value="2" checked>
                                <label class="form-check-label" for="capacidad2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="capacidad" id="capacidad4" value="4">
                                <label class="form-check-label" for="capacidad4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="capacidad" id="capacidad6" value="6">
                                <label class="form-check-label" for="capacidad6">6</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="seccion" class="mb-2">Sección:</label>
                        <select id="seccion" name="seccion" class="form-select">
                            <option value="1">Sección 001</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="habilitado" class="mb-2">Habilitado:</label>
                        <select id="habilitado" name="habilitado" class="form-select">
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-actions mt-5">
                        <button type="submit" class="btn btn-primary" name="AbtnAceptar">Aceptar</button>
                        <button type="submit" class="btn btn-danger" name="AbtnCancelar">Cancelar</button>
                    </div>
                </form>
            </div>
        </body>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
        </html>
<?php
    }
}
?>