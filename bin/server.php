<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/modelo/Notificacion.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServer implements MessageComponentInterface
{
    private $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage(); // Almacena las conexiones activas
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Añadir la nueva conexión a la lista de clientes
        $this->clients->attach($conn);
        echo "Nuevo cliente conectado ({$conn->resourceId})\n";
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Eliminar la conexión de la lista de clientes
        $this->clients->detach($conn);
        echo "Cliente desconectado ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "Mensaje recibido del cliente ({$from->resourceId}): $msg\n";

        // Procesar el mensaje recibido
        if ($msg === 'Obtener mesas') {
            $mesas = $this->getMesas();
            $from->send(json_encode($mesas)); // Enviar las mesas solo al cliente que lo solicitó
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }

    private function getMesas()
    {
        try {
            require_once __DIR__ . '/../src/modelo/Mesa.php';
            $mesa = new Mesa();

            $respuesta = $mesa->mandarMesas();
            if ($respuesta === null) {
                return [];
            }

            $mesas = [];
            while ($fila = $respuesta->fetch_assoc()) {
                $mesas[] = $fila;
            }

            return $mesas;
        } catch (Exception $e) {
            echo "Error al obtener las mesas: " . $e->getMessage() . "\n";
            return [];
        }
    }

    // Método que notifica a todos los clientes sobre cambios
    public function notificarCambios($mensaje)
    {
        foreach ($this->clients as $client) {
            $client->send($mensaje);
        }
    }
}

// Iniciar el servidor WebSocket
use React\EventLoop\Loop;
use React\Socket\SocketServer;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$loop = Loop::get();
$socket = new SocketServer('0.0.0.0:8080', [], $loop);

// Instancia de WebSocketServer
$webSocketServer = new WebSocketServer();

$server = new IoServer(
    new HttpServer(
        new WsServer(
            $webSocketServer
        )
    ),
    $socket,
    $loop
);

// Simular notificaciones en tiempo real desde la base de datos
$loop->addPeriodicTimer(5, function () use ($webSocketServer) {
    try {
        $notificacion = new Notificacion();
        // Obtener notificaciones no procesadas
        $notificaciones = $notificacion->obtenerNotificaciones();

        if (!empty($notificaciones)) {
            echo "Enviando notificaciones...\n";
            $mensaje = "Cambiando estados";
            $webSocketServer->notificarCambios($mensaje);
            // Marcar las notificaciones como procesadas
            $notificacion->marcarNotificaciones();
        }
    } catch (Exception $e) {
        echo "Error al manejar notificaciones: " . $e->getMessage() . "\n";
    }
});
echo "Servidor WebSocket iniciado en el puerto 8080...\n";
$loop->run();
