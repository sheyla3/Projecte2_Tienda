<?php
// require "models/producto.php";
require "models/categoria.php";

class CategoriaController
{
    public function mostrarProductos()
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin'){
            // require_once "views/adminPanel/menu.php";
            $categoria = new Categoria();
            $catalogo = $producto->obtenerCatalogo();
            require_once "views/adminPanel/tablaProductos.php";
        }
        else{
            adminIncorrecte();
        }
    }
}