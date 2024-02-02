<?php
// require "models/producto.php";
require "models/pedido.php";

class PedidoController
{
    public function mostrarProductos()
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin'){
            // require_once "views/adminPanel/menu.php";
            $database = new Database();
            $dbInstance = $database->getDB();
            require_once "views/general/adminPanel/menu.php";
            $pedido = new Pedido($dbInstance, null, null, null, null, null, null);
            $catalogo = $pedido->obtenerPedidos();
            require_once "views/general/adminPanel/tablaComandes.php";

        }
        else{
            // adminIncorrecte();
        }
    }

    public function añadirPedido(){
        ob_clean();
        header('Content-Type: application/json');
        $correo = $_SESSION['email'];
        $datosProductos = json_decode(file_get_contents('php://input'), true);
        $database = new Database();
        $dbInstance = $database->getDB();
        $pedido = new Pedido($dbInstance, null,$correo, null, null, null);
        $pedidos = $pedido->crearNuevoPedido();
        echo json_encode(['success' => true]);
        exit;


    }
}