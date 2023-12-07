<?php
// require "models/producto.php";
require "models/categoria.php";

class CategoriaController
{
    public function mostrarProductos()
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin'){
            $database = new Database();
            $dbInstance = $database->getDB();
            require_once "views/general/adminPanel/menu.php";
            $categoria = new Categoria($dbInstance,null,null,null,null);
            $catalogo = $categoria->obtenerCategorias();
            require_once "views/general/adminPanel/tablaCategorias.php";

        }
        else{
            adminIncorrecte();
        }
    }
}