<?php
// require "models/producto.php";
require "models/pedido.php";
require "models/carrito.php";
require "models/usuario.php";
require "models/producto.php";

class PedidoController
{
    public function mostrarProductos()
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
            // require_once "views/adminPanel/menu.php";
            $database = new Database();
            $dbInstance = $database->getDB();
            require_once "views/general/adminPanel/menu.php";
            $pedido = new Pedido($dbInstance, null, null, null, null, null, null);
            $catalogo = $pedido->obtenerPedidos();
            require_once "views/general/adminPanel/tablaComandes.php";

        } else {
            // adminIncorrecte();
        }
    }
    public function añadirPedido()
    {
        ob_clean();
        header('Content-Type: application/json');
        $correo = $_SESSION['email'];
        $datosProductos = json_decode(file_get_contents('php://input'), true);
        $database = new Database();
        $dbInstance = $database->getDB();

        // Iterar sobre los datos de productos y añadir al carrito
        foreach ($datosProductos['carrito'] as $producto) {
            $id_producto = $producto['id_producto'];
            $cantidad = $producto['cantidad'];
            $precio = $producto['precio'];
            $nombre = $producto['nombre'];
            $img = $producto['img'];

            $carrito = new Carrito($dbInstance, null, $correo, $id_producto, $cantidad, $precio);
            $funciona = $carrito->anadirProductoAlCarrito();

            // Puedes hacer algo con $funciona si lo necesitas
        }

        // Llamar a la función para crear el pedido
        $pedido = new Pedido($dbInstance, null, $correo, null, null, null);
        $pedidos = $pedido->crearNuevoPedido();

        echo json_encode(['success' => true, 'info' => $datosProductos]);
        exit;
    }

    public static function listarPedidosUsuario()
    {
        // Obtener el email del usuario desde la sesión
        $email = $_SESSION['email'];

        // Crear una instancia de PedidoModel
        $pedidoModel = new Pedido(null, null, null, null, null, null);

        // Llamar al método no estático
        $pedidos = $pedidoModel->obtenerPedidosUsuario($email);

        // Verificar si $pedidos es un array
        if (is_array($pedidos)) {
            // Renderizar la vista con los datos de los pedidos
            include 'views/general/usuario/pedidosUser.php';
        } else {
            // Manejar el caso en que la consulta falla
            echo "Error al obtener los pedidos.";
        }
    }

    public function verPedido()
    {
        // Verificar si se proporciona un ID de pedido válido en la URL
        if (isset($_GET['id_pedido'])) {
            $idPedido = $_GET['id_pedido'];

            // Obtener el pedido correspondiente del modelo (supongamos que tienes un método en tu modelo)
            $pedidoModel = new Pedido(null, null, null, null, null, null);
            $pedido = $pedidoModel->getPedidoById($idPedido);

            // Mostrar la vista con el formulario para cambiar el estado del pedido
            include('views/general/adminPanel/formularios/verPedido.php');  // Ajusta la ruta según tu estructura
        } else {
            // Manejar el caso en el que no se proporciona un ID de pedido válido
            echo "Error: ID de pedido no válido.";
        }
    }

    public function procesarActualizacionEstado()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pedidoId = $_POST['id_pedido'];
            $nuevoEstado = $_POST['estado'];
            $pedidoModel = new Pedido(null, null, null, null, null, null);
            $pedidoModel->actualizarEstado($pedidoId, $nuevoEstado);

            echo 'Estado actualizado con exito';
            echo '<meta http-equiv="refresh" content="2;url=index.php?controller=pedido&action=mostrarProductos">';
            exit();
        } else {
            echo "Acceso no válido";
        }
    }

    public function verDetallesPedido()
    {
        if (isset($_GET['id_pedido'])) {
            $id_pedido = $_GET['id_pedido'];

            $database = new Database();
            $dbInstance = $database->getDB();

            $pedidomodel = new Pedido($dbInstance, null, null, null, null, null);
            $detallesPedido = $pedidomodel->obtenerPedidoPorId($id_pedido);

            $this->mostrarDetallesPedido($detallesPedido);
        } else {
            // Manejo de error: el ID del pedido no se proporcionó
            echo "Error: ID del pedido no especificado";
        }
    }

    public function verDetallesPedidoPDF()
    {
        ob_clean();
        if (isset($_GET['id_pedido'])) {
            $id_pedido = $_GET['id_pedido'];

            $database = new Database();
            $dbInstance = $database->getDB();

            $pedidomodel = new Pedido($dbInstance, null, null, null, null, null);
            $detallesPedido = $pedidomodel->obtenerPedidoPorId($id_pedido);

            $this->mostrarPDFpedido($detallesPedido);
        } else {
            // Manejo de error: el ID del pedido no se proporcionó
            echo "Error: ID del pedido no especificado";
        }
    }

    public function mostrarDetallesPedido($detallesPedido)
    {
        // Incluye la vista para mostrar los detalles del pedido
        include("views/general/usuario/detallePedido.php");
    }

    public function mostrarPDFpedido($detallesPedido){
        $pedidoModel = new Pedido(null, null, null, null, null, null);
        $clienteModel = new Usuario(null, null, null, null, null, null, null, null);
        $productoModel = new Producto(null, null, null, null, null, null, null, null, null, null, null);
        $carritoModel = new Carrito(null, null, null, null, null, null);

        $pedido = $pedidoModel->obtenerPedidoPorId($detallesPedido);
        $cliente = $clienteModel->getProfile($pedido['correo']);
        $productos_carrito = $pedidoModel->obtenerDetallesCarritoPorPedido($detallesPedido);


        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);

        $pdf->Cell(0, 10, 'Detalles del Pedido: ' . print_r($pedido, true), 0, 1);
        $pdf->Cell(0, 10, 'Detalles del Cliente: ' . print_r($cliente, true), 0, 1);

        $pdf->Cell(0, 10, 'Productos del Carrito:', 0, 1);
        foreach ($productos_carrito as $producto) {
            // Obtener detalles del producto
            $detalles_producto = $productoModel->obtenerInfo($producto['id_producto']);
            $pdf->Cell(0, 10, 'Nombre: ' . $detalles_producto['nombre'] . ', Cantidad: ' . $producto['cantidad'] . ', Precio: ' . $producto['precio'], 0, 1);
        }

        $pdf->Output();

        include("views/general/usuario/facturaPDF.php");
    }

}