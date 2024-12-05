<?php

class panelNumerico
{

    public function panelNumericoShow($capacidadMesa, $idMesa)
    {
?>
        <script>
            (function () {
                // Crear el modal dinámicamente
                function createModal() {
                    // Crear los elementos del modal
                    const modalOverlay = document.createElement('div');
                    modalOverlay.style.position = 'fixed';
                    modalOverlay.style.top = 0;
                    modalOverlay.style.left = 0;
                    modalOverlay.style.width = '100%';
                    modalOverlay.style.height = '100%';
                    modalOverlay.style.background = 'rgba(0, 0, 0, 0.6)';
                    modalOverlay.style.display = 'flex';
                    modalOverlay.style.justifyContent = 'center';
                    modalOverlay.style.alignItems = 'center';

                    const modal = document.createElement('div');
                    modal.style.backgroundColor = '#333';
                    modal.style.border = '2px solid #fff';
                    modal.style.borderRadius = '10px';
                    modal.style.padding = '20px';
                    modal.style.textAlign = 'center';
                    modal.style.width = '300px';
                    modal.style.position = 'relative'; // Necesario para posicionar el botón de cierre

                    // Barra superior con el botón de cierre
                    const header = document.createElement('div');
                    header.style.position = 'absolute';
                    header.style.top = '10px';
                    header.style.right = '10px';
                    
                    const closeButton = document.createElement('button');
                    closeButton.textContent = '×';
                    closeButton.style.background = 'transparent';
                    closeButton.style.border = 'none';
                    closeButton.style.color = '#fff';
                    closeButton.style.fontSize = '24px';
                    closeButton.style.cursor = 'pointer';
                    closeButton.onclick = () => document.body.removeChild(modalOverlay);

                    header.appendChild(closeButton);

                    const title = document.createElement('h2');
                    title.textContent = 'Ingrese cantidad de personas';
                    title.style.marginBottom = '10px';
                    title.style.color = '#fff';

                    const display = document.createElement('div');
                    display.id = 'modal-display';
                    display.textContent = '0';
                    display.style.width = '100%';
                    display.style.height = '50px';
                    display.style.marginBottom = '20px';
                    display.style.backgroundColor = '#444';
                    display.style.color = '#fff';
                    display.style.border = '1px solid #555';
                    display.style.borderRadius = '5px';
                    display.style.fontSize = '24px';
                    display.style.textAlign = 'center';
                    display.style.lineHeight = '50px';

                    const keypad = document.createElement('div');
                    keypad.style.display = 'flex';
                    keypad.style.flexWrap = 'wrap';
                    keypad.style.justifyContent = 'center';
                    keypad.style.gap = '10px';

                    // Crear botones numéricos
                    for (let i = 1; i <= 9; i++) {
                        const button = createButton(i);
                        keypad.appendChild(button);
                    }

                    // Botón "0" ocupa tres espacios
                    const zeroButton = createButton(0);
                    zeroButton.style.gridColumn = '1 / span 3';
                    zeroButton.style.fontSize = '24px';
                    zeroButton.style.width = '77%';
                    keypad.appendChild(zeroButton);

                    const actions = document.createElement('div');
                    actions.style.marginTop = '20px';
                    actions.style.display = 'flex';
                    actions.style.justifyContent = 'center';
                    actions.style.gap = '10px';

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'BORRAR';
                    deleteButton.style.padding = '10px 20px';
                    deleteButton.style.fontSize = '16px';
                    deleteButton.style.backgroundColor = '#F44336';
                    deleteButton.style.color = '#fff';
                    deleteButton.style.border = 'none';
                    deleteButton.style.borderRadius = '5px';
                    deleteButton.onclick = () => (display.textContent = '0');

                    const okButton = document.createElement('button');
                    okButton.textContent = 'OK';
                    okButton.style.padding = '10px 20px';
                    okButton.style.fontSize = '16px';
                    okButton.style.backgroundColor = '#444';
                    okButton.style.color = '#fff';
                    okButton.style.border = 'none';
                    okButton.style.borderRadius = '5px';
                    okButton.onclick = () => {
                        console.log(display.textContent);
                        window.location.href = `/src/ModuloServicio/UCgenerarPedidoPlato/getPedidos.php?cantidad=${display.textContent}&capacidadMesa=<?=$capacidadMesa?>&id=<?=$idMesa?>`;
                        document.body.removeChild(modalOverlay); // Cerrar el modal
                    };

                    actions.appendChild(deleteButton);
                    actions.appendChild(okButton);

                    // Agregar elementos al modal
                    modal.appendChild(header); // Agregar el encabezado con el botón de cierre
                    modal.appendChild(title);
                    modal.appendChild(display);
                    modal.appendChild(keypad);
                    modal.appendChild(actions);
                    modalOverlay.appendChild(modal);

                    // Agregar el modal al DOM
                    document.body.appendChild(modalOverlay);
                }

                // Crear un botón numérico
                function createButton(number) {
                    const button = document.createElement('button');
                    button.textContent = number;
                    button.style.width = '70px';
                    button.style.height = '70px';
                    button.style.fontSize = '24px';
                    button.style.backgroundColor = '#555';
                    button.style.color = '#fff';
                    button.style.border = 'none';
                    button.style.borderRadius = '5px';
                    button.style.cursor = 'pointer';
                    button.onclick = () => {
                        const display = document.getElementById('modal-display');
                        // Verificar si la cantidad de cifras es menor a 3
                        if (display.textContent.length < 2) {
                            if (display.textContent === '0') {
                                display.textContent = number;
                            } else {
                                display.textContent += number;
                            }
                        }
                    };
                    return button;
                }

                createModal();
            })();
        </script>
<?php
    }
}

?>
