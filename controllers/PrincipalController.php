<?php
require "models/producto.php";
require "models/categoria.php";

class PrincipalController
{
    public function mostrarPaginaPrincipal()
    {
        require_once "views/general/slider.php";
        $categoria = new Categoria();
        $listaCategorias = $categoria->obtenerCategorias();
        require_once "views/general/mostrarListaCategorias.php";
        $producto = new Producto();
        $destacados = $producto->productoDestacado();
        require_once "views/general/mostrarDestacados.php";
        
    }
}