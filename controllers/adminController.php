<?php
require "models/producto.php";
require "models/categoria.php";
require "models/pedido.php";
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
            	// header('Location: index.php?controller=producto&action=mostrarProductos');
				header('Location: index.php?controller=categoria&action=mostrarProductos');
                //exit;
        	} else {
            	// En caso de credenciales incorrectas, puedes redirigir de nuevo al formulario
            	// de inicio de sesión con un mensaje de error
               // header('Location: index.php?controller=Login&action=mostrarFormularioLogin&error=1');
            	//exit;
                echo("Credenciales no válidas");
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='3;URL=index.php'>";
        	}
    	}else{
            // Si no es una solicitud POST, simplemente muestra el formulario de inicio de sesión
    	    // include('views\general\formularios\mostrar_login.php'); // Reemplaza con la ruta correcta a tu vista

        }

    	
	}

    public function botonVistaProducto(){
         
        $database = new Database();
        $dbInstance = $database->getDB();
        require_once "views/general/adminPanel/menu.php";
        $producto = new Producto($dbInstance,null,null,null,null,null,null,null,null,null,null);
        $catalogo = $producto->obtenerProductos();
        include('views/general/adminPanel/tablaProductos.php');
    
    }
    public function botonVistaComanda(){
        $database = new Database();
        $dbInstance = $database->getDB();
        require_once "views/general/adminPanel/menu.php";
        $pedido = new Pedido($dbInstance,null,null,null,null,null,null);
        $catalogo = $pedido->obtenerPedidos();
        include('views/general/adminPanel/tablaComandes.php');
     }

    public function botonVistaCategoria(){
        $database = new Database();
        $dbInstance = $database->getDB();
        require_once "views/general/adminPanel/menu.php";
        $categoria = new Categoria($dbInstance,null,null,null,null);
        $catalogo = $categoria->obtenerCategorias();
        require_once 'views/general/adminPanel/tablaCategorias.php';
        
    }
    public function mostrarLoginAdmin(){
        include('views/general/formularios/mostrar_login.php');
    }
    
}