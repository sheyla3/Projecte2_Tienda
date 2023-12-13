<?php
require "models/usuario.php";
require_once "models/database.php";



class UsuarioController
{

	public function procesar_login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $database = new Database();
            $dbInstance = $database->getDB();

            $user = new Usuario($dbInstance, $email, $password, null, null, null, null, null);
            $isUserValid = $user->login();

            if ($isUserValid) {
                $_SESSION['email'] = $email;
                $_SESSION['role'] = 'user';
                header('Location: index.php');
                exit;
            } else {
                echo "Credenciales no válidas";
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='3;URL=index.php'>";
            }
        } else {
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
            } else {
                echo "Error al crear el usuario. Por favor, inténtalo nuevamente.";
            }
        } else {
            include('views/general/formularios/crear_usuario.php');
        }
	}

    public function mostrarLoginUsuario(){
        include('views/general/formularios/mostrar_login_usuario.php');
    }
    
}