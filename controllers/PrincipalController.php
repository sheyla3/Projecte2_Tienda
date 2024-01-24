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

        require_once "views/general/slider.php";
        require_once "views/general/menu_secundario.php";        
    }
}
