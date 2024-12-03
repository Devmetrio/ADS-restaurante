<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServer implements MessageComponentInterface {
    private $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage(); // Almacena las conexiones activas
    }

    public function onOpen(ConnectionInterface $conn) {
        // Añadir la nueva conexión a la lista de clientes
        $this->clients->attach($conn);
        echo "Nuevo cliente conectado ({$conn->resourceId})\n";
    }

    public function onClose(ConnectionInterface $conn) {
        // Eliminar la conexión de la lista de clientes
        $this->clients->detach($conn);
        echo "Cliente desconectado ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Mensaje recibido del cliente ({$from->resourceId}): $msg\n";

        // Procesar el mensaje recibido
        if ($msg === 'Obtener mesas') {
            $mesas = $this->getMesas();
            $from->send(json_encode($mesas)); // Enviar las mesas solo al cliente que lo solicitó
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }

    private function getMesas() {
        try {
            // Conexión a la base de datos usando PDO
            $pdo = new PDO('mysql:host=localhost;dbname=restaurantedb', 'root', '12345678');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT idMesa, capacidad, idMesaEstado FROM mesas WHERE estadoTecnico = 1";
            $stmt = $pdo->query($sql);

            $mesas = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $mesas[] = $row;
            }

            return $mesas;
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage() . "\n";
            return [];
        }
    }

    // Método que notifica a todos los clientes sobre cambios
    public function notificarCambios($mensaje) {
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
        // Conexión a la base de datos
        $pdo = new PDO('mysql:host=localhost;dbname=restaurantedb', 'root', '12345678');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta para obtener notificaciones no procesadas
        $sql = "SELECT * FROM notificaciones WHERE procesado = 0";
        $stmt = $pdo->query($sql);
        $notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($notificaciones)) {
            echo "Enviando notificaciones...\n";
            $mensaje = "Cambiando estados";
            $webSocketServer->notificarCambios($mensaje);

            // Marcar las notificaciones como procesadas
            $pdo->exec("UPDATE notificaciones SET procesado = 1 WHERE procesado = 0");
        }
    } catch (PDOException $e) {
        echo "Error al consultar notificaciones: " . $e->getMessage() . "\n";
    }
});
echo "Servidor WebSocket iniciado en el puerto 8080...\n";
$loop->run();
