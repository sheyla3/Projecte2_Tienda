<?php
require "models/usuario.php";
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


    public function crearUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtén los datos del formulario para crear un usuario
            $email = $_POST['email'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $photo = $_POST['photo']; // Considera cómo manejar el archivo de imagen

            // Instancia de la base de datos
            $database = new Database();
            $dbInstance = $database->getDB();

            // Crea una nueva instancia de Usuario con los datos del formulario
            $newUser = new Usuario($dbInstance, $email, $password, $name, $lastname, $phone, $address, $photo);
            
            // Intenta agregar el usuario a la base de datos
            $isUserCreated = $newUser->agregarUsuario();

            if ($isUserCreated) {
                header('Location: index.php?controller=Usuario&action=mostrarLoginUsuario');
                echo "Usuario creado exitosamente.";
            } else {
                // Manejar el caso en el que el usuario no se pudo crear
                echo "Error al crear el usuario. Por favor, inténtalo nuevamente.";
            }
        } else {
            // Si no es una solicitud POST, simplemente muestra el formulario para crear un usuario
            include('views/general/formularios/crear_usuario.php');
        }
	}

    public function mostrarLoginUsuario(){
        include('views/general/formularios/mostrar_login_usuario.php');
    }
    
}