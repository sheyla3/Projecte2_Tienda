<?php
require "models/admin.php";
// require "models/usuario.php";

class LoginController
{
    public function index()
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
            header('Location: index.php?controller=Producto&action=mostrarProductos');
        } else if (isset($_SESSION['email']) && $_SESSION['role'] == 'user') {
            header('Location: index.php?controller=Principal&action=mostrarPaginaPrincipal');
        } else {
            header('Location: index.php?controller=Principal&action=mostrarPaginaPrincipal');
        }
    }


}