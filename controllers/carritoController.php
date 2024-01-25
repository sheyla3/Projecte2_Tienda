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

}















?>