// Array para almacenar la comanda
let comanda = [];

// Función para cargar la comanda desde localStorage
function cargarComanda() {
    const data = localStorage.getItem('comanda');
    if (data) {
        comanda = JSON.parse(data);
    }
    actualizarTabla();
}

// Función para verificar la comanda
function verificarComanda() {
    return JSON.stringify(comanda); // Devuelve la comanda como JSON
}

// Función para preparar la comanda antes de enviar el formulario
function prepararComanda() {
    const comandaInput = document.getElementById('comandaInput');
    comandaInput.value = verificarComanda();
}

// Función para guardar la comanda en localStorage
function guardarComanda() {
    localStorage.setItem('comanda', JSON.stringify(comanda));
}
// Función para agregar un ítem a la comanda
function agregarAComanda(id, nombre, descripcion, precio) {
    // Buscar si el ítem ya está en la comanda
    let itemExistente = comanda.find(item => item.id === id);

    if (itemExistente) {
        // Incrementar la cantidad si ya existe
        itemExistente.cantidad++;
        itemExistente.subtotal = itemExistente.cantidad * itemExistente.precio;
    } else {
        // Agregar nuevo ítem
        comanda.push({
            id: id,
            nombre: nombre,
            descripcion: descripcion,
            precio: precio,
            cantidad: 1,
            subtotal: precio
        });
    }

    // Guardar en localStorage y actualizar la tabla
    guardarComanda();
    actualizarTabla();
}

function actualizarTabla() {
    const tbody = document.querySelector('.order-table tbody');
    const filasExistentes = tbody.children.length;
    let indexInicio = 1;
    // Tamaño de la comanda actual
    const tamañoComanda = comanda.length;

    if(filasExistentes >0 && tamañoComanda==0){
        // El índice de inicio será el número de filas en la tabla menos el tamaño de la comanda actual más 1
        indexInicio = filasExistentes - tamañoComanda + 2;
    }

    // Eliminar la fila con el mensaje (si existe)
    const mensajeFila = tbody.querySelector('tr td[colspan="6"]');
    if (mensajeFila) {
        tbody.removeChild(mensajeFila.parentNode);
    }

    // Eliminar solo las filas creadas por JavaScript (sin el atributo `disabled`)
    const filasParaEliminar = Array.from(tbody.children);
    filasParaEliminar.forEach(fila => {
        const boton = fila.querySelector('.delete-btn');
        if (boton && !boton.hasAttribute('disabled')) {
            tbody.removeChild(fila);
        }
    });

    // Agregar las filas de la comanda con el índice ajustado
    comanda.forEach((item, index) => {
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${indexInicio + index}</td> <!-- Ajustar el índice -->
            <td>${item.nombre}</td>
            <td>${item.descripcion}</td>
            <td>s/ ${item.subtotal.toFixed(2)}</td>
            <td style="width: 5%; min-width: 30px;">${item.cantidad}</td>
            <td><button class="delete-btn" onclick="eliminarDeComanda(${item.id})">🗑️</button></td>
        `;
        tbody.appendChild(fila);
    });
}



// Función para eliminar un ítem de la comanda
function eliminarDeComanda(id) {
    comanda = comanda.filter(item => item.id !== id);
    guardarComanda();
    actualizarTabla();
}

// Función para limpiar la comanda y el localStorage
function limpiarComanda() {
    comanda = [];               // Vaciar el array de la comanda
    localStorage.removeItem('comanda'); // Eliminar los datos del localStorage
    actualizarTabla();           // Actualizar la tabla para reflejar el cambio
}


// Cargar la comanda al iniciar
window.onload = cargarComanda;

document.addEventListener("DOMContentLoaded", function () {
    let isMouseDown = false;
    let startY;
    let scrollTop;

    const tableSection = document.querySelector('.table-section');

    // Función para iniciar el arrastre
    tableSection.addEventListener('mousedown', (e) => {
        isMouseDown = true;
        startY = e.pageY - tableSection.offsetTop;
        scrollTop = tableSection.scrollTop;
        tableSection.style.cursor = 'grabbing';
    });

    // Función para arrastrar el contenido
    tableSection.addEventListener('mousemove', (e) => {
        if (!isMouseDown) return;
        e.preventDefault();
        const y = e.pageY - tableSection.offsetTop;
        const walk = (y - startY) * 2;
        tableSection.scrollTop = scrollTop - walk;
    });

    // Función para finalizar el arrastre
    tableSection.addEventListener('mouseup', () => {
        isMouseDown = false;
        tableSection.style.cursor = 'grab'; // Restablece el cursor
    });

    // Para garantizar que al salir del área del contenedor se detenga el arrastre
    tableSection.addEventListener('mouseleave', () => {
        isMouseDown = false;
        tableSection.style.cursor = 'grab';
    });
});
