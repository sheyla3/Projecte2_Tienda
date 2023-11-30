<?php
// require "models/producto.php";
require "models/categoria.php";

class CategoriaController
{
    public function mostrarProductos()
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin'){
            // require_once "views/adminPanel/menu.php";
            $database = new Database();
            $dbInstance = $database->getDB();
            $categoria = new Categoria($dbInstance,null,null,null,null);
            $catalogo = $categoria->obtenerCategorias();
            require_once "views/general/adminPanel/tablaCategorias.php";

        }
        else{
            adminIncorrecte();
        }
    }
}