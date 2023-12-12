<?php
require "models/producto.php";
// require "models/categoria.php";

class ProductoController
{
    public function mostrarProductos()
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin'){
            // require_once "views/adminPanel/menu.php";
            $database = new Database();
            $dbInstance = $database->getDB();
            require_once "views/general/adminPanel/menu.php";
            $producto = new Producto($dbInstance,null,null,null,null,null,null,null,null,null);
            $catalogo = $producto->obtenerProductos();
            require_once "views/general/adminPanel/tablaProductos.php";
        }
        else{
            // adminIncorrecte();
        }
    }

    public function buscarproductos($filtro)
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
            // Acceso a la base de datos y búsqueda de productos
            $database = new Database();
            $dbInstance = $database->getDB();
            $producto = new Producto($dbInstance, null, null, null, null, null, null, null, null, null);
            $resultados = $producto->buscarproductos($filtro);
    
            // Devolver resultados como JSON
            header('Content-Type: application/json');
            echo json_encode($resultados);
            exit(); // Terminar la ejecución para evitar cualquier otra salida
        } else {
            // Manejar caso en que el usuario no sea un administrador o no haya sesión activa
        }
    }
    



}