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
}