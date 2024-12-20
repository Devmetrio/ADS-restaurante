<?php

class modalJuntarMesa {
    function modalJuntarMesaShow($idMesa, $mesasSecundarias){
?>
<script>
    // Función para mostrar el modal
    function mostrarModalJuntarMesa() {
        // Array de mesas secundarias
        const mesasSecundarias = <?php echo json_encode($mesasSecundarias); ?>;

        // Opciones iniciales para los selects
        let optionsHTML = mesasSecundarias.map(mesa => `<option value="${mesa.idMesa}">Mesa ${mesa.idMesa}</option>`).join('');

        // Crear el HTML del modal
        const modalHTML = `
            <div id="modalJuntarMesa" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.7);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;">
                <form action="getPedidos.php" method="POST" style="
                    background-color: #2c3e50;
                    color: #ecf0f1;
                    padding: 20px;
                    border-radius: 15px;
                    width: 450px;
                    font-family: Arial, sans-serif;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
                    text-align: center;">
                    
                    <!-- MESA PRINCIPAL -->
                    <h3 style="margin-bottom: 20px;">MESA PRINCIPAL</h3>
                    <div style="
                        margin: 10px auto;
                        border: 2px solid #95a5a6;
                        padding: 10px;
                        width: 80%;
                        text-align: center;
                        font-weight: bold;
                        background-color: #34495e;
                        border-radius: 5px;">
                        MESA <?php echo $idMesa; ?>
                        <input type="hidden" name="mesaPrincipal" value="<?php echo $idMesa; ?>">
                    </div>
                    
                    <!-- MESA SECUNDARIAS -->
                    <h4 style="margin: 20px 0;">MESAS SECUNDARIAS</h4>
                    <div style="margin: 10px;">
                        <select name="mesaSecundaria1" class="mesa-secundaria" style="
                            width: 100%;
                            padding: 10px;
                            border-radius: 10px;
                            border: 1px solid #7f8c8d;
                            background-color: #2c3e50;
                            color: #ecf0f1;
                            font-size: 16px;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                            <option value="">Seleccione una Mesa</option>
                            ${optionsHTML}
                        </select>
                    </div>
                    <div style="margin: 10px;">
                        <select name="mesaSecundaria2" class="mesa-secundaria" style="
                            width: 100%;
                            padding: 10px;
                            border-radius: 10px;
                            border: 1px solid #7f8c8d;
                            background-color: #2c3e50;
                            color: #ecf0f1;
                            font-size: 16px;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                            <option value="">Seleccione una Mesa</option>
                            ${optionsHTML}
                        </select>
                    </div>
                    <div style="margin: 10px;">
                        <select name="mesaSecundaria3" class="mesa-secundaria" style="
                            width: 100%;
                            padding: 10px;
                            border-radius: 10px;
                            border: 1px solid #7f8c8d;
                            background-color: #2c3e50;
                            color: #ecf0f1;
                            font-size: 16px;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                            <option value="">Seleccione una Mesa</option>
                            ${optionsHTML}
                        </select>
                    </div>

                    <!-- BOTONES -->
                    <div style="margin-top: 30px;">
                        <button type="submit" style="
                            margin: 5px;
                            padding: 10px 20px;
                            background-color: #27ae60;
                            color: #fff;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                            font-size: 16px;" name="btnAceptarJuntar" value="aceptar">ACEPTAR</button>
                        <button type="button" style="
                            margin: 5px;
                            padding: 10px 20px;
                            background-color: #e74c3c;
                            color: #fff;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                            font-size: 16px;"
                            onclick="cerrarModal()">CANCELAR</button>
                    </div>
                </form>
            </div>
        `;

        // Insertar el modal en el DOM
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Agregar funcionalidad dinámica a los selects
        const selects = document.querySelectorAll('.mesa-secundaria');
        selects.forEach(select => {
            select.addEventListener('change', () => {
                const selectedValues = Array.from(selects).map(s => s.value);
                selects.forEach(s => {
                    const currentValue = s.value;
                    Array.from(s.options).forEach(option => {
                        if (option.value && selectedValues.includes(option.value) && option.value !== currentValue) {
                            option.style.display = 'none';
                        } else {
                            option.style.display = 'block';
                        }
                    });
                });
            });
        });
    }

    // Función para cerrar el modal
    function cerrarModal() {
        const modal = document.getElementById("modalJuntarMesa");
        if (modal) modal.remove();
    }

    // Llamar a la función para mostrar el modal
    window.onload = mostrarModalJuntarMesa;
</script>
<?php
    }
}
?>
