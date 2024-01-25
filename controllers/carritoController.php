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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verifica si la variable de sesión existe
       
        $correo = $_SESSION['email'];
        $id_producto = $_POST['d_id_producto'];
        $cantidad = $_POST['d_cantidad'];
        $precio = $_POST['d_precio'];
  

        if (isset($_SESSION['email'])) {
            $database = new Database();
            $dbInstance = $database->getDB();
            $carrito = new Carrito($dbInstance, null, $correo, $id_producto, $cantidad, $precio);
            $funciona = $carrito->anadirProductoAlCarrito();

            if ($funciona) {

                // $datos_producto = [
                //     'correo' => $correo,
                //     'id_producto' => $id_producto,
                //     'cantidad' => $cantidad,
                //     'precio' => $precio,
                // ];
                
                // echo json_encode(['success' => true, 'message' => 'Producto añadido al carrito', 'producto' => $datos_producto]);
               
            } else {

                // Manejar el caso en el que no se pueda añadir el producto al carrito
                // echo json_encode(['success' => false, 'message' => 'Error al añadir el producto al carrito']);
                echo "Error al añadir el producto al carrito";
            }
        }

    } 
}




}










?>