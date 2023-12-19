<?php
require "models/producto.php";
require_once "models/database.php";
require "models/categoria.php";

class PrincipalController
{
    public function mostrarPaginaPrincipal()
    {
        $database = new Database();
        $dbInstance = $database->getDB();

        // require_once "views/general/cabezera.php";
        echo "<br><br>";
        echo "<br><br>";
        echo "<br><br>";

        require_once "views/general/slider.php";
        require_once "views/general/menu_secundario.php";

        // $categoria = new Categoria($dbInstance, null, null, null, null);
        // $listaCategorias = $categoria->obtenerCategorias();
        // require_once "views/general/mostrarListaCategorias.php";
        // $producto = new Producto($dbInstance, null, null, null, null, null, null, null, null, null, null);
        // $destacados = $producto->productoDestacado();
        // require_once "views/general/mostrarDestacados.php";
        
    }
}