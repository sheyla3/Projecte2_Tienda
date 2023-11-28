<?php
require "models/producto.php";
require "models/categoria.php";

class PrincipalController
{
    public function mostrarPaginaPrincipal()
    {
        $categoria = new Categoria();
        $resultado = $categoria->obtenerListado();
        require_once "views/general/mostrarListaCategorias.php";
        $producto = new Producto();
        $resultado = $producto->productoDestacado();
    }
}