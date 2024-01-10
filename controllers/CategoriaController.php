<?php

require_once "models/categoria.php";
require_once "models/database.php";

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

    public function botonEditarCategoria() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_categoria = $_GET['id_categoria'];
            $database = new Database();
            $dbInstance = $database->getDB();
            
            $nombre = $_POST['nombre'];
            $genero = $_POST['genero'];
            if (isset($_POST['estado'])) {
                // El checkbox está marcado
                // Realiza alguna acción si está marcado
                $estado = 1; // O asigna el valor que necesites para 'true'
            } else {
                // El checkbox no está marcado
                // Realiza alguna acción si no está marcado
                $estado = 0; // O asigna el valor que necesites para 'false'
            }
            
            $categoriaEditada = new Categoria($dbInstance, $id_categoria, $nombre, $estado, $genero);
            $funciona = $categoriaEditada->editar();
            
            if ($funciona) {
                header('Location: index.php?controller=Admin&action=botonVistaCategoria');
            } else {
                // Manejo del error al editar la categoría
            }
        } else {
            if (isset($_GET['id_categoria'])) {
                $id_categoria = $_GET['id_categoria'];
                $database = new Database();
                $dbInstance = $database->getDB();
                $categoria = new Categoria($dbInstance, $id_categoria, null, null, null);
                $info = $categoria->obtenerInfo($id_categoria);
                include('views/general/adminPanel/formularios/editarCategoria.php');
            } else {
                // Manejo para cuando no se recibe el parámetro id_categoria
            }
        }
    }

    public function botonCrearCategoria(){
        include('views/general/adminPanel/formularios/crearCategoria.php');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $genero = $_POST['genero'];
            

            if (isset($_POST['estado'])) {
                // El checkbox está marcado
                // Realiza alguna acción si está marcado
                $estado = true; // O asigna el valor que necesites para 'true'
            } else {
                // El checkbox no está marcado
                // Realiza alguna acción si no está marcado
                $estado = false; // O asigna el valor que necesites para 'false'
            }

            $database = new Database();
            $dbInstance = $database->getDB();

            $categoria = new Categoria($dbInstance ,null, $nombre, $estado , $genero);
            $funciona = $categoria->anadir();

            if($funciona){
                header('Location: index.php?controller=Admin&action=botonVistaCategoria');
            }else{

            }
        }
    }

    public function MostrarCubosCategoriasHombre(){
        $database = new Database();
        $dbInstance = $database->getDB();

        $categoria = new Categoria($dbInstance ,null, null, null , null);
        $categorias = $categoria->obtenerIdNombreCategoriasHombre();

        require_once "views/general/paginaPrincipal/categortiasH.php";

    }

    public function MostrarCubosCategoriasMujer(){
        $database = new Database();
        $dbInstance = $database->getDB();

        $categoria = new Categoria($dbInstance ,null, null, null , null);
        $categorias = $categoria->obtenerIdNombreCategoriasMujer();

        require_once "views/general/paginaPrincipal/categortiasM.php";

    }

    public static function RellenarMenu(){
        $database = new Database();
        $dbInstance = $database->getDB();

        $categoria = new Categoria($dbInstance ,null, null, null , null);
        $categoriasM = $categoria->obtenerIdNombreCategoriasMujer();
        $categoriasH = $categoria->obtenerIdNombreCategoriasHombre();

        require_once "views\general\cabezera.php";

    }

   

}