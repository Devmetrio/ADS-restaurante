<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/src/compartido/viewMensajeSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarIngresoClientes/controlGestionarIngreso.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarIngresoClientes/panelSeleccionarMesa.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarReserva/gestionarReserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Reserva.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/src/modelo/Mesa.php');

// Declaración de funciones
function validarBoton($boton)
{
    return isset($boton);
}

function validarAccion($accion)
{
    return isset($accion);
}

function redirigirindexGestionarReserva()
{
    header('Location: /src/ModuloServicio/UCgestionarReserva/indexGestionarReserva.php');
    exit;
}

function redirigirindexSeleccionarMesa()
{
    header('Location: /src/ModuloServicio/UCgestionarIngresoClientes/indexSeleccionarMesa.php?idMesa=' . $_POST['btnSeleccionarMesa']);
    exit;
}

function redirigirindexverDetallesReserva($idReserva)
{
    header('Location: /src/ModuloServicio/UCgestionarIngresoClientes/indexverDetallesReserva.php?idReserva=' . $idReserva);
    exit; // Asegúrate de salir después de un header para evitar la ejecución de código adicional.
}

$mensajeError = '';
// Declaración de variables 
$btnSeleccionarMesa = $_POST['btnSeleccionarMesa'] ?? null;
$btnRegresarPanel = $_POST['btnRegresarPanel'] ?? null;
$btnverDetalles = $_POST['btnverDetalles'] ?? null;
$btnConfirmarReserva = $_POST['btnConfirmarReserva'] ?? null;
$btnBuscarReserva = $_POST['btnBuscarReserva'] ?? null;
$btncambiarestadoMesa = $_POST['btncambiarestadoMesa'] ?? null;
$btncambiarestadoicono = $_POST['btncambiarestadoicono'] ?? null; // Aquí capturamos el nuevo botón

// Flujo principal
if (validarBoton($btnSeleccionarMesa)) {
    redirigirindexSeleccionarMesa();
} elseif (validarBoton($btnRegresarPanel)) {
    redirigirindexGestionarReserva();
} elseif (validarBoton($btnverDetalles)) {
    $idReserva = $_POST['idReserva'] ?? null;
    if ($idReserva) {
        redirigirindexverDetallesReserva($idReserva);
    } else {
        echo "Error: No se proporcionó un ID de reserva.";
    }
} elseif (validarBoton($btnConfirmarReserva)) {
  // Validar si el ID de la reserva está presente en los parámetros GET
  if (isset($_GET['idReserva'])) {
      $idReserva = intval($_GET['idReserva']); // Captura el ID de la reserva desde la URL

      // Verificar si el ID de la reserva es válido
      if ($idReserva > 0) {
          // Usar el controlador para confirmar la llegada de la reserva
          include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarIngresoClientes/controlGestionarIngreso.php');
          $controlGestionarIngresoObject = new controlGestionarIngreso();

          // Llamar al método para confirmar la llegada de la reserva
          $resultado = $controlGestionarIngresoObject->confirmarLlegadaReserva($idReserva);

          if ($resultado) {
              // Si la operación es exitosa, redirigir con un mensaje de éxito
              $gestionarReservaObject = new gestionarReserva();
              $gestionarReservaObject->gestionarReservaShow($datosMostrar, $fecha);
              $viewMensajeSistemaObject = new viewMensajeSistema();
              $viewMensajeSistemaObject->viewMensajeSistemaShow('success', 'Reserva confirmada', 'La llegada de la reserva ha sido confirmada con éxito.');
          } else {
              // Si la operación falla, mostrar un mensaje de error
              $viewMensajeSistemaObject = new viewMensajeSistema();
              $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Error al confirmar reserva', 'No se pudo confirmar la llegada de la reserva. Intente nuevamente.', '/src/ModuloServicio/UCgestionarIngresoClientes/indexGestionarReserva.php');
          }
      } else {
          // Si el ID de la reserva no es válido, mostrar mensaje de error
          $viewMensajeSistemaObject = new viewMensajeSistema();
          $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'ID de reserva inválido', 'No se ha proporcionado un ID de reserva válido.', '/src/ModuloServicio/UCgestionarIngresoClientes/indexGestionarReserva.php');
      }
  } else {
      // Si no se encuentra el ID de la reserva en los parámetros GET, mostrar mensaje de error
      $viewMensajeSistemaObject = new viewMensajeSistema();
      $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'ID de reserva no encontrado', 'No se ha encontrado el ID de la reserva en la solicitud.', '/src/ModuloServicio/UCgestionarIngresoClientes/indexGestionarReserva.php');
  }
} elseif (validarBoton($btnBuscarReserva)) {
    // Validación del campo de búsqueda
    $nombreBuscado = trim($_POST['busqueda']);
    if (!preg_match('/^[A-Za-zÀ-ÿ\s]{1,40}$/', $nombreBuscado)) {
        $_SESSION['mensajeBusqueda'] = "Búsqueda inválida.";
        redirigirindexGestionarReserva();
    }

    // Recuperar las reservas del día desde la sesión
    $reservasDelDia = $_SESSION['reservasDelDia'] ?? [];

    if (!empty($reservasDelDia)) {
        // Filtrar las reservas por el nombre del cliente
        $resultadoBusqueda = array_filter($reservasDelDia, function ($reserva) use ($nombreBuscado) {
            return stripos($reserva['nombreCliente'], $nombreBuscado) !== false;
        });

        // Guardar los resultados de búsqueda en la sesión
        $_SESSION['resultadoBusqueda'] = $resultadoBusqueda;
        $_SESSION['mensajeBusqueda'] = count($resultadoBusqueda) > 0 ? null : "No se encontraron reservas para el cliente '{$nombreBuscado}'.";

        // Redirigir al index para mostrar los resultados
        redirigirindexGestionarReserva();
    } else {
        $_SESSION['mensajeBusqueda'] = "No hay reservas disponibles para buscar.";
        redirigirindexGestionarReserva();
    }
} elseif (validarBoton($btncambiarestadoMesa)) {
    // Validar si los datos necesarios están presentes
    if (isset($_POST['idMesa'], $_POST['estadoMesa'])) {
        // Capturar los datos enviados por POST
        $idMesa = intval($_POST['idMesa']);
        $estadoActual = intval($_POST['estadoMesa']);

        // Validar si la mesa está ocupada
        if ($estadoActual == 3) { // Estado 3 corresponde a "ocupado"
          $seleccionarMesasObject = new seleccionarMesa();
          $seleccionarMesasObject->panelseleccionarMesaShow();
            $viewMensajeSistemaObject = new viewMensajeSistema();
            $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Acceso denegado', 'Error, la mesa ya esta ocupada');
        } else {
            // Determinar el nuevo estado (libre = 1, en espera = 2)
            $nuevoEstado = ($estadoActual == 1) ? 2 : 1;

            // Usar el controlador para realizar la actualización
            include_once($_SERVER['DOCUMENT_ROOT'] . '/src/ModuloServicio/UCgestionarIngresoClientes/controlGestionarIngreso.php');
            $controlGestionarIngreso = new controlGestionarIngreso();
            $controlGestionarIngreso->cambiarEstadoMesa($idMesa, $nuevoEstado);

            // Redirigir a la vista de selección de mesas
            header('Location: /src/ModuloServicio/UCgestionarIngresoClientes/indexSeleccionarMesa.php');
            exit();
        }
    } else {
        $seleccionMesasObject = new seleccionMesas();
        $seleccionMesasObject->seleccionMesaShow();

        $viewMensajeSistemaObject = new viewMensajeSistema();
        $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Datos insuficientes', 'Falta información para cambiar el estado de la mesa.');
    }
} elseif (validarBoton($btncambiarestadoicono)) { // Aquí se agrega el flujo para el nuevo botón
    // Validar si los datos necesarios están presentes
    if (isset($_POST['idMesa'])) {
        $idMesa = intval($_POST['idMesa']); // Captura la ID de la mesa

        // Cambiar el estado de la mesa de libre a ocupado
        $controlGestionarIngresoObject = new controlGestionarIngreso();
        $controlGestionarIngresoObject->cambiarEstadoLibreAOcupado($idMesa); // Llamada al método de cambio de estado

        exit();
    } else {
        $viewMensajeSistemaObject = new viewMensajeSistema();
        $viewMensajeSistemaObject->viewMensajeSistemaShow('error', 'Datos insuficientes', 'Falta información para cambiar el estado de la mesa.');
    }
}

?>
