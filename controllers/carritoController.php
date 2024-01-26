<?php

require_once "models/carrito.php";
require_once "models/database.php";

class CarritoController
{

public function obetenerCarrito()
{
    $database = new Database();
    $dbInstance = $database->getDB();
    $carrito = new Carrito($dbInstance,null,$correo,null,null,null,null);
    $resultados = $carrito->obtenerProductosEnCarrito();

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


// public function mostrarCarrito() {
//     ob_clean();
//     header('Content-Type: application/json');


//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         // Decodificar datos JSON
//             ob_clean();
//             $carritoData = json_decode(file_get_contents('php://input'), true);
            
//             require_once 'views\general\usuario\carrito.php';
        
//     } else {
//         echo json_encode(['success' => false, 'message' => 'Error en la solicitud']);
//     }
// }

public function recibirLocalCarrito() {
    ob_clean();
    header('Content-Type: application/json');


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Decodificar datos JSON
        $carritoData = json_decode(file_get_contents('php://input'), true);
        $htmlGenerado = self::crearHTMLcarrito($carritoData);

        // Puedes realizar alguna lógica de procesamiento si es necesario
        // Devolver éxito
        echo json_encode(['success' => true, 'info' => $htmlGenerado , 'datos' => $carritoData]);

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
    $htmlGenerado = '<table border="1">
                        <thead>
                            <tr>
                                <th>ID Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Nombre</th>
                                <th>Imagen</th>
                            </tr>
                        </thead>
                        <tbody>';

    // Verificar si hay datos de productos en el carrito
    if (isset($datos['carrito'][0]['productos']) && is_array($datos['carrito'][0]['productos'])) {
        // Recorrer cada producto y agregar una fila a la tabla
        foreach ($datos['carrito'][0]['productos'] as $producto) {
            $htmlGenerado .= '<tr>
                                <td>holaa</td>
                                <td>' . $producto['id_producto'] . '</td>
                                <td>' . $producto['cantidad'] . '</td>
                                <td>' . $producto['precio'] . '</td>
                                <td>' . $producto['nombre'] . '</td>
                                <td><img src="' . $producto['img'] . '" alt="' . $producto['nombre'] . '" width="50" height="50"></td>
                            </tr>';
        }
    }

    $htmlGenerado .= '</tbody></table>';

    return $htmlGenerado;
}









}
















?>