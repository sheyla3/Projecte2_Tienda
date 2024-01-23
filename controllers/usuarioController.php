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
				session_start();
	
				$_SESSION['email'] = $email;
				$_SESSION['role'] = 'user';
				header('Location: index.php?controller=usuario&action=mostrarPerfil');
				exit;
			} else {
				echo "Credenciales no válidas";
				echo "<META HTTP-EQUIV='REFRESH' CONTENT='3;URL=index.php?controller=usuario&action=mostrarLoginUsuario '>";
			}
		} else {
			include('views\general\formularios\mostrar_login.php');
		}
	}
	

	public function crearUsuario() {
		include('views/general/formularios/crear_usuario.php');
	
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$email = trim($_POST['email']);
			$password = $_POST['password'];
			$name = $_POST['name'];
			$lastname = $_POST['lastname'];
			$phone = $_POST['phone'];
			$address = $_POST['address'];
	
			// Valida el tipos de datos
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errorEmail = 'El formato del correo electrónico no es válido.';
				$url = 'index.php?controller=Usuario&action=crearUsuario&errorEmail=' . urlencode($errorEmail);
				echo "<meta http-equiv='refresh' content='0;URL=" . $url . "'>";
				exit();
				
			} elseif (!is_string($password) || strlen($password) < 6) {
				$errorPass = 'La contraseña debe ser una cadena de al menos 6 caracteres.';
				$url = 'index.php?controller=Usuario&action=crearUsuario&errorPass=' . urlencode($errorPass);
				echo "<meta http-equiv='refresh' content='0;URL=" . $url . "'>";
				exit();
			} elseif (!is_string($name) || !is_string($lastname) || !is_string($address)) {
				$errorTexto = 'El nombre, apellido y dirección deben ser cadenas de texto.';
				$url = 'index.php?controller=Usuario&action=crearUsuario&errorTexto=' . urlencode($errorTexto);
				echo "<meta http-equiv='refresh' content='0;URL=" . $url . "'>";
				exit();
			} elseif (!is_numeric($phone) || strlen($phone) !== 9) {
				$errorTel = 'El teléfono debe ser un número de 9 dígitos.';
				$url = 'index.php?controller=Usuario&action=crearUsuario&errorTel=' . urlencode($errorTel);
				echo "<meta http-equiv='refresh' content='0;URL=" . $url . "'>";
				exit();
			} else {
				// verificacion de la imagen si se mete
				if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
					$photo = $_FILES['photo']; 
	
					$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
					$detectedType = exif_imagetype($photo['tmp_name']);
					$isValidType = in_array($detectedType, $allowedTypes);
	
					if ($isValidType && $photo['size'] <= 5000000) { // tamaño máximo de 5 megas, lo podemos cambiar
						$targetDirectory = "./img/fotos_usuario/";
	
						$currentDateTime = date('YmdHis');
	
						$fileExtension = pathinfo($photo['name'], PATHINFO_EXTENSION);
	
						$targetFile = $targetDirectory . 'user_photo_' . $currentDateTime . '.' . $fileExtension;
	
						if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
							$photoPath = $targetFile;
						} else {
							$errorSubir = 'Error al subir la imagen. Vuelve a intentarlo.';
							$url = 'index.php?controller=Usuario&action=crearUsuario&errorSubir=' . urlencode($errorSubir);
							echo "<meta http-equiv='refresh' content='0;URL=" . $url . "'>";
							exit();
						}
	
					} else {
						$errorValidez = 'El archivo de imagen no es válido. Asegúrate de subir una imagen en formato PNG, JPEG o GIF, y que no exceda los 5MB.';
						$url = 'index.php?controller=Usuario&action=crearUsuario&errorSubir=' . urlencode($errorValidez);
						echo "<meta http-equiv='refresh' content='0;URL=" . $url . "'>";
						exit();
					}
				} else {
					$photoPath = '';
				}
	
				$database = new Database();
				$dbInstance = $database->getDB();
	
				// Encriptacion de la contra
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
				$password = $hashedPassword;
	
				// Crear nuevo usuario
				$newUser = new Usuario($dbInstance, $email, $password, $name, $lastname, $phone, $address, $photoPath);
				$isUserCreated = $newUser->agregarUsuario();
	
				if ($isUserCreated) {
					echo '<meta http-equiv="refresh" content="0;url=index.php?controller=Usuario&action=mostrarLoginUsuario">';

				} else {
					$result = '<div style="position:absolute; top:10%; left: 41%; color:red;">Error al crear el usuario. Por favor, inténtalo nuevamente. </div>';
				}
			}
		}
	}
	
	// FUNCIONES PARA MOSTRAR

    public function mostrarLoginUsuario(){
        include('views/general/formularios/mostrar_login_usuario.php');
    }
	
    public function mostrarCrearUsuario(){
		include('views/general/formularios/crear_usuario.php');
	}

	public function editarFoto(){
        include('views/general/formularios/mostrar_edit_photo.php');
    }

	public function mostrarPerfil(){
		$database = new Database();
		$dbInstance = $database->getDB();

		$newUser = new Usuario($dbInstance, $_SESSION['email'], null, null, null, null, null, null);
        $datosUser = $newUser->getProfile($_SESSION['email']);
		
		include('views/general/usuario/perfilUser.php');
	}
}