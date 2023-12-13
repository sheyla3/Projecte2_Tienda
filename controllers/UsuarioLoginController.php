<?php
require_once "models/usuario.php";
require_once "models/database.php";
class LoginController {
	public function index() {
    	//session_start(); // Inicia la sesión si no está iniciada

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        	// Obtén los datos del formulario de inicio de sesión
        	$email = $_POST['email'];
        	$password = $_POST['password'];

            $database = new Database();
            $dbInstance = $database->getDB();

        	// Verifica la autenticación utilizando el modelo Usuario
        	$usuario = new Usuario($dbInstance);
        	$isUserValid = $usuario->login($email, $password);

        	if ($isUserValid) {
            	$_SESSION['email'] = $email;
            	$_SESSION['role'] = 'user';
            	//header('Location: index.php?controller=Producto&action=mostrarProductos');
				header('Location: index.php?controller=categoria&action=mostrarProductos');
            	exit;
        	} else {
            	// En caso de credenciales incorrectas, puedes redirigir de nuevo al formulario
            	// de inicio de sesión con un mensaje de error
            	header('Location: index.php?controller=Login&action=mostrarFormularioLogin&error=1');
            	exit;
        	}
    	}

    	// Si no es una solicitud POST, simplemente muestra el formulario de inicio de sesión
    	include('views\general\formularios\procesar_login.php'); // Reemplaza con la ruta correcta a tu vista
	}
}
