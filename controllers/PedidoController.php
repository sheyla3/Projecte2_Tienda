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

    public function mostrarPedidos() {
        // Obtener la información de los pedidos del usuario actual desde la base de datos
        $id_usuario = $_SESSION['id_usuario'];  // Asegúrate de tener una sesión activa

        $pedidos = obtenerPedidosUsuario($id_usuario);

        // Verificar si hay pedidos
        if (empty($pedidos)) {
            echo "No tienes pedidos realizados.";
        } else {
            // Mostrar los pedidos en forma de tabla
            echo "<table border='1'>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Fecha Pedido</th>
                        <!-- Agrega más columnas según tus necesidades -->
                    </tr>";

            foreach ($pedidos as $pedido) {
                echo "<tr>
                        <td>{$pedido['id_pedido']}</td>
                        <td>{$pedido['fecha_pedido']}</td>
                        <!-- Agrega más celdas según tus necesidades -->
                      </tr>";
            }

            echo "</table>";
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