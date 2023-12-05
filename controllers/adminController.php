<?php
require "models/producto.php";
require "models/categoria.php";
require "models/admin.php";
require_once "models/database.php";



class AdminController
{

    public function procesar_login() {
    	//session_start(); // Inicia la sesión si no está iniciada

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        	// Obtén los datos del formulario de inicio de sesión
        	$nom = $_POST['email'];
        	$password = $_POST['password'];

            $database = new Database();
            $dbInstance = $database->getDB();

        	// Verifica la autenticación utilizando el modelo Admin
        	$admin = new Admin($dbInstance, $nom, null, $password);
        	$isAdminValid = $admin->login();

        	if ($isAdminValid) {
            	$_SESSION['email'] = $nom;
            	$_SESSION['role'] = 'admin';
                
            	//header('Location: index.php?controller=Producto&action=mostrarProductos');
				header('Location: index.php?controller=categoria&action=mostrarProductos');
            	//exit;
        	} else {
            	// En caso de credenciales incorrectas, puedes redirigir de nuevo al formulario
            	// de inicio de sesión con un mensaje de error
               // header('Location: index.php?controller=Login&action=mostrarFormularioLogin&error=1');
            	//exit;
                echo("no valido");
        	}
    	}else{
            // Si no es una solicitud POST, simplemente muestra el formulario de inicio de sesión
    	    include('views\general\formularios\mostar_login.php'); // Reemplaza con la ruta correcta a tu vista

        }

    	
	}

    public function botonVistaProducto(){
        include('views/general/adminPanel/tablaProductos.php');
    
    }
    public function botonVistaComanda(){
         include('views/general/adminPanel/tablaComandes.php');
     }

    public function botonVistaCategoria(){
        $database = new Database();
        $dbInstance = $database->getDB();
        $categoria = new Categoria($dbInstance,null,null,null,null);
        $catalogo = $categoria->obtenerCategorias();
        include('views/general/adminPanel/tablaCategorias.php');
        
    }


    
    public function botonEditarCategoria() {
        if (isset($_GET['id_categoria'])) {
            $id_categoria = $_GET['id_categoria']; 
            $database = new Database();
            $dbInstance = $database->getDB();
            $categoria = new Categoria($dbInstance,$id_categoria,null,null,null);
            $info = $categoria->obtenerInfo();
            include('views\general\adminPanel\formularios\editarCategoria.php');
        } else {
            // Manejo para cuando no se recibe el parámetro id_categoria
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
                echo("hola");
            }else{

            }


            
        }
    }
    
}