<?php
require "models/producto.php";
// require "models/categoria.php";

class ProductoController
{
    public function mostrarProductos()
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin'){
            // require_once "views/adminPanel/menu.php";
            $producto = new Producto();
            $catalogo = $producto->obtenerCatalogo();
            require_once "views/general/adminPanel/obtenerCategorias.php";
        }
        else{
            adminIncorrecte();
        }
    }
}