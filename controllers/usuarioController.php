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
	
			// Validación de tipos de datos
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo "El formato del correo electrónico no es válido. ";
			} elseif (!is_string($password) || strlen($password) < 6) {
				echo "La contraseña debe ser una cadena de al menos 6 caracteres. ";
			} elseif (!is_string($name) || !is_string($lastname) || !is_string($address)) {
				echo "El nombre, apellido y dirección deben ser cadenas de texto. ";
			} elseif (!is_numeric($phone) || strlen($phone) !== 9) {
				echo "El teléfono debe ser un número de 9 dígitos. ";
			} else {
				// verificacion de la imagen si se mete
				if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
					$photo = $_FILES['photo'];
	
					$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
					$detectedType = exif_imagetype($photo['tmp_name']);
					$isValidType = in_array($detectedType, $allowedTypes);
	
					if ($isValidType && $photo['size'] <= 5000000) { // Tamaño máximo de 5 megas
						$targetDirectory = "./img/fotos_usuario/";
	
						// Fecha y hora para el nombre de la foto
						$currentDateTime = date('YmdHis');
	
						// Nombre de la foto original
						$fileExtension = pathinfo($photo['name'], PATHINFO_EXTENSION);
	
						// Crea el nombre de la foto con la fecha, hora y nombre
						$targetFile = $targetDirectory . 'user_photo_' . $currentDateTime . '.' . $fileExtension;
	
						if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
							$photoPath = $targetFile;
						} else {
							echo "Error al subir la imagen. Por favor, inténtalo nuevamente.";
							return;
						}
	
					} else {
						echo "El archivo de imagen no es válido. Asegúrate de subir una imagen en formato PNG, JPEG o GIF, y que no exceda los 5MB.";
						return;
					}
				} else {
					$photoPath = ''; // Deja el nombre de la foto vacío para subirlo a la BBDD (si no se agrega foto)
				}
	
				// Instancia de la base de datos
				$database = new Database();
				$dbInstance = $database->getDB();
	
				// Encriptar la contraseña
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	
				// Asignar el valor encriptado a la variable $password
				$password = $hashedPassword;
	
				// Crear nuevo usuario
				$newUser = new Usuario($dbInstance, $email, $password, $name, $lastname, $phone, $address, $photoPath);
				$isUserCreated = $newUser->agregarUsuario();
	
				if ($isUserCreated) {
					header('Location: index.php?controller=Usuario&action=mostrarLoginUsuario');
					exit;
				} else {
					echo "Error al crear el usuario. Por favor, inténtalo nuevamente.";
				}
			}
		}
	}
	
	
	
	
	
	

    public function mostrarLoginUsuario(){
        include('views/general/formularios/mostrar_login_usuario.php');
    }
    
}