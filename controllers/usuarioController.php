<?php
require "models/producto.php";
require "models/categoria.php";
require "models/pedido.php";
require "models/admin.php";
require_once "models/database.php";



class UsuarioController
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
        	$admin = new User($dbInstance, $nom, null, $password);
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

    public function mostrarLoginUsuario(){
        include('views/general/formularios/mostrar_login_usuario.php');
    }
    
}