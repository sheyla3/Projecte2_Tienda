<?php

require_once "models/carrito.php";
require_once "models/database.php";

class CarritoController
{

public function obetenerCarrito()
{
    $correo = $_SESSION['email'];
    $database = new Database();
    $dbInstance = $database->getDB();
    $carrito = new Carrito($dbInstance,null,$correo,null,null,null,null);
    $resultados = $carrito->obtenerProductosEnCarrito();

}

public function modificarAccion() {
    ob_clean();
    header('Content-Type: application/json');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener datos del cuerpo de la solicitud
        $data = json_decode(file_get_contents("php://input"), true);

        // Verificar si se recibieron los datos esperados
        if (isset($data['id_producto']) && isset($data['accion'])) {
            $id_producto = $data['id_producto'];
            $accion = $data['accion'];

            // Resto de la lógica para obtener el correo y la instancia de la base de datos
            $correo = $_SESSION['email'];
            $database = new Database();
            $dbInstance = $database->getDB();
            $carrito = new Carrito($dbInstance, null, $correo, $id_producto, null, null, null);

            // Llamar a la función para actualizar el producto en el carrito
            $resultados = $carrito->actualizarProductoEnCarrito($accion);

            // Puedes devolver una respuesta JSON indicando el resultado de la operación
            echo json_encode(['success' => $resultados]);
        } else {
            // Datos incompletos en la solicitud
            echo json_encode(['success' => false, 'message' => 'Datos incompletos en la solicitud']);
        }
    }
}



public function añadirAlCarrito()
{
    if (isset($_SESSION['email'])) {
        // Recibir los datos del formulario
        $id_producto = isset($_POST['id_producto']) ? $_POST['id_producto'] : null;
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : null;
        $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
        $img = isset($_POST['img']) ? $_POST['img'] : null;
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        $correo = $_SESSION['email'];

        error_log("ID Producto: " . $id_producto . ", Cantidad: " . $cantidad . ", Precio: " . $precio);

        if ($correo !== null && $id_producto !== null && $cantidad !== null && $precio !== null) {
            // Si todos los datos están presentes, realizar las operaciones necesarias
            $database = new Database();
            $dbInstance = $database->getDB();
            $carrito = new Carrito($dbInstance, null, $correo, $id_producto, $cantidad, $precio);
            $funciona = $carrito->anadirProductoAlCarrito();

            if ($funciona) {
               
            } else {
                // Manejar el caso en el que no se pueda añadir el producto al carrito
            }
        } else {
            // Manejar el caso en el que falta algún dato
        }
    } else {
        echo("no data");
        // Manejar el caso en el que no haya una sesión de usuario activa
    }
}


public function recibirLocalCarrito() {
    ob_clean();
    header('Content-Type: application/json');
   
    // if (isset($_SESSION['email'])) {
    //     $datosBase = $this->obtenerCarrito(); // Corregido el nombre de la función
    // }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Decodificar datos JSON
        $carritoData = json_decode(file_get_contents('php://input'), true);
        // $htmlGenerado = self::crearHTMLcarrito($carritoData);
        $htmlGenerado = self::crearHTMLcarrito($carritoData);
        // $datosBase = $this->obtenerCarrito();

        // Puedes realizar alguna lógica de procesamiento si es necesario
        // Devolver éxito
        echo json_encode(['success' => true, 'info' => $htmlGenerado]);

        exit;
    } else {
        // Devolver fallo
        echo json_encode(['success' => false, 'message' => 'Error en la solicitud']);
        exit;
    }
}

public function entrar(){
    include 'views\general\usuario\carrito.php';
}

public function crearHTMLcarrito($datos) {
    $productosCombinados = [];
    if (isset($_SESSION['email'])) {
        $correo = $_SESSION['email'];
        $database = new Database();
        $dbInstance = $database->getDB();
        $carrito = new Carrito($dbInstance, null, $correo, null, null, null, null);
        $datosBase = $carrito->obtenerProductosEnCarrito();
        $productosCombinados = self::combinarProductos($datos, $datosBase);
    } else {
        // Si no hay sesión de usuario, solo combinar los productos del carrito
        $productosCombinados = self::combinarProductos($datos);
    }

    $precioTotal = 0;
    $htmlGenerado = '<div class="carrito1">
                        <div class="generalCarrito carritoContanier">';

    foreach ($productosCombinados as $producto) {
        $subtotal = $producto['precio'] * $producto['cantidad'];
        $precioTotal += $subtotal;

        $htmlGenerado .= '<div class="carritoContanier">
                            <div class="carritoimg">
                                <img src="' . $producto['img'] . '" alt="' . $producto['nombre'] . '" data-stock="' . $producto['stock'] . '">
                            </div>
                            <div>
                                <p>' . $producto['nombre'] . '</p>
                                <p>' . $producto['precio'] * $producto['cantidad'] . '</p>
                                <div class="menuPrecio">
                                    <p>' . $producto['cantidad'] . '</p>
                                    <input type="hidden" class="producto-seleccionado" name="productos_seleccionados[' . $producto['id_producto'] . '][seleccionado]" value="' . $producto['id_producto'] . '">
                                    <input type="hidden" name="productos_seleccionados[' . $producto['id_producto'] . '][cantidad]" value="' . $producto['cantidad'] . '">
                                    <input type="hidden" name="productos_seleccionados[' . $producto['id_producto'] . '][precio]" value="' . $producto['precio'] . '">
                                    <input type="hidden" name="productos_seleccionados[' . $producto['id_producto'] . '][nombre]" value="' . htmlspecialchars($producto['nombre']) . '">
                                    <input type="hidden" name="productos_seleccionados[' . $producto['id_producto'] . '][img]" value="' . htmlspecialchars($producto['img']) . '">
                                    <button type="button" class="btn-subir" data-cant="' . $producto['cantidad'] . '" data-id="' . $producto['id_producto'] . '" data-stock="' . $producto['stock'] . '"></button>
                                    <button type="button" class="btn-bajar" data-id="' . $producto['id_producto'] . '"></button>
                                    <button type="button" class="btn-eliminar" data-id="' . $producto['id_producto'] . '"></button>
                                </div>
                            </div>
                       
                    </div>';
    }

    $htmlGenerado .= ' </div>
    <div class="precioContanier">
                            <h3>Resumen</h3>
                            <p>Total' . $precioTotal . ' </p>
                            <button type="button" onclick="comprarProductos()">Comprar Productos</button>
                        </div>
                    </div>';

    $htmlNoP = '<h3>Sin productos</h3>';

    if ($productosCombinados) {
        return $htmlGenerado;
    } else {
        return $htmlNoP;
    }
}






public function combinarProductos($productosCarrito, $productosBase = null) {
    $productosCombinados = [];

    // Agregar productos de datosBase
    if ($productosBase !== null && is_array($productosBase)) {
        // Agregar cada producto de datosBase
        foreach ($productosBase as $producto) {
            $productosCombinados[$producto['id_producto']] = $producto;
        }
    }

    // Agregar productos del carrito
    if (isset($productosCarrito['carrito']) && is_array($productosCarrito['carrito'])) {
        foreach ($productosCarrito['carrito'] as $carrito) {
            if (isset($carrito['productos']) && is_array($carrito['productos'])) {
                foreach ($carrito['productos'] as $producto) {
                    // Verificar si ya existe un producto con el mismo id
                    if (!isset($productosCombinados[$producto['id_producto']])) {
                        $productosCombinados[$producto['id_producto']] = $producto;
                    }
                }
            }
        }
    }

    return array_values($productosCombinados);
}



}
















?>