<?php
require "models/usuario.php";
require_once "models/database.php";

class UsuarioController
{

	public function procesar_login()
	{
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
				header('Location: index.php');
				exit;
			} else {
				echo "<br><br><br><br>";
				echo "<h1 class='error_val'>Credenciales no válidas</h1>";
				echo "<META HTTP-EQUIV='REFRESH' CONTENT='3;URL=index.php?controller=usuario&action=mostrarLoginUsuario '>";
			}
		} else {
			include('views\general\formularios\mostrar_login.php');
		}
	}


	public function crearUsuario()
	{
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

	public function mostrarLoginUsuario()
	{
		include('views/general/formularios/mostrar_login_usuario.php');
	}

	public function mostrarCrearUsuario()
	{
		include('views/general/formularios/crear_usuario.php');
	}

	public function mostrarFormUserPhoto()
	{
		// Verifica si el usuario está autenticado (puedes ajustar esto según tu lógica de autenticación)
		if (!isset($_SESSION["email"])) {
			header("Location: index.php"); // Redirige a la página principal si no está autenticado
			exit();
		}

		// Obtén el email del usuario desde la URL
		$email = $_GET["email"];

		// Validar si el usuario tiene permiso para cambiar la foto (comparando con el email en la sesión)
		if ($_SESSION["email"] != $email) {
			echo "No tienes permisos para cambiar la foto de este perfil.";
			exit();
		}

		// Obtén los datos del usuario para mostrar en el formulario de cambio de foto
		$database = new Database();
		$dbInstance = $database->getDB();

		$usuario = new Usuario($dbInstance, $email, null, null, null, null, null, null);
		$datosUser = $usuario->getProfile($email);

		// Incluye la vista de cambio de foto
		include('views/general/usuario/editPhoto.php');
	}

	// Cambia la llamada de editPhoto() a editFoto()
	public function editPhoto()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// Obtener el ID del usuario desde la sesión
			$email = $_SESSION["email"];

			// Carpeta donde se guardarán las fotos
			$carpetaDestino = "img/fotos_usuario/";

			// Verificar si se ha subido un archivo
			if (isset($_FILES["nuevaFoto"]) && $_FILES["nuevaFoto"]["error"] == 0) {
				// Generar un nombre único para la nueva foto
				$nuevoNombreFoto = $email . "_" . time() . "_" . $_FILES["nuevaFoto"]["name"];

				// Ruta completa donde se guardará la nueva foto
				$rutaCompleta = $carpetaDestino . $nuevoNombreFoto;

				// Mover el archivo al servidor
				move_uploaded_file($_FILES["nuevaFoto"]["tmp_name"], $rutaCompleta);

				// Aquí deberías realizar la lógica para actualizar la foto en la base de datos
				// Establecer conexión a la base de datos (ajusta los valores según tu configuración)
				$database = new Database();
				$dbInstance = $database->getDB();
				$usuario = new Usuario($dbInstance, $email, null, null, null, null, null, null);

				if ($dbInstance !== null) {

					// Preparar la consulta SQL para actualizar la foto en la base de datos
					$consulta = $usuario->editFoto(); // Cambia editPhoto() a editFoto()
					if ($consulta !== false) {
						$consulta->bindParam(':photo', $rutaCompleta);
						$consulta->bindParam(':email', $email);

						// Ejecutar la consulta
						$consulta->execute();

						// Redirigir al perfil del usuario (cambia "perfil_usuario.php" según tu estructura)
						echo 'Fotografia actualizada con exito';
						echo '<meta http-equiv="refresh" content="2;url=index.php?controller=Usuario&action=mostrarPerfil">';
						exit();
					} else {
						echo "Error al subir la foto.";
					}
				} else {
					echo "Acceso no permitido.";
				}
			}
		}
	}


	public function mostrarPerfil()
	{
		$database = new Database();
		$dbInstance = $database->getDB();

		$newUser = new Usuario($dbInstance, $_SESSION['email'], null, null, null, null, null, null);
		$datosUser = $newUser->getProfile($_SESSION['email']);

		include('views/general/usuario/perfilUser.php');
	}

	public function mostrarEditarPerfil()
	{
		// Verifica si el usuario está autenticado (puedes ajustar esto según tu lógica de autenticación)
		if (!isset($_SESSION["email"])) {
			header("Location: index.php"); // Redirige a la página principal si no está autenticado
			exit();
		}

		// Obtén el email del usuario desde la URL
		$email = $_GET["email"];

		// Validar si el usuario tiene permiso para editar este perfil (por ejemplo, comparando con el email en la sesión)
		if ($_SESSION["email"] != $email) {
			echo "No tienes permisos para editar este perfil.";
			exit();
		}

		// Obtén los datos del usuario para mostrar en el formulario de edición
		$database = new Database();
		$dbInstance = $database->getDB();

		$usuario = new Usuario($dbInstance, $email, null, null, null, null, null, null);
		$datosUser = $usuario->getProfile($email);

		// Incluye la vista de edición del perfil
		include('views/general/usuario/editarPerfil.php');
	}

	public function actualizarPerfil()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Obtener datos del formulario
			$nombre = $_POST['nombre'];
			$apellidos = $_POST['apellidos'];
			$direccion = $_POST['direccion'];
			$telefono = $_POST['telefono'];

			// Validar y actualizar los datos en la base de datos
			$database = new Database();
			$dbInstance = $database->getDB();

			$usuario = new Usuario($dbInstance, $_SESSION['email'], null, null, null, null, null, null);
			$result = $usuario->updateProfile($nombre, $apellidos, $direccion, $telefono);

			if ($result) {
				// Redirigir al perfil del usuario con los datos actualizados
				header("Location: index.php?controller=usuario&action=mostrarPerfil");
				exit();
			} else {
				echo "Error al actualizar el perfil. Inténtalo nuevamente.";
			}
		} else {
			// Acceso no permitido
			echo "Acceso no permitido.";
		}
	}
}