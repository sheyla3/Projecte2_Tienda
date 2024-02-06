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
            	// En caso de credenciales incorrectas, puedes redirigir de nuevo al formulario de inicio de sesión con un mensaje de error
                echo "<br><br><br><br>";
                echo("Credenciales no válidas");
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='2;URL=index.php?controller=admin&action=mostrarLoginAdmin'>";
        	}
    	}else{
            // Si no es una solicitud POST, simplemente muestra el formulario de inicio de sesión
    	    // include('views\general\formularios\mostrar_login.php'); // Reemplaza con la ruta correcta a tu vista

        }

    	
	}

    public function botonVistaProducto(){
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
            $database = new Database();
            $dbInstance = $database->getDB();
            require_once "views/general/adminPanel/menu.php";
            $producto = new Producto($dbInstance,null,null,null,null,null,null,null,null,null,null);
            $catalogo = $producto->obtenerProductos();
            include('views/general/adminPanel/tablaProductos.php');
        }else{
            echo("<p class='validado'>No estas validado</p>");
        }

        
    
    }

    public function botonVistaCanvas(){
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
            $database = new Database();
            $dbInstance = $database->getDB();
            require_once "views/general/adminPanel/menu.php";
            include('views/general/adminPanel/firma.html');
            echo '<script src="./scriptDibujar.js"></script>';

        }else{
            echo("<p class='validado'>No estas validado</p>");
        }

        
    
    }

    public function botonVistaGrafica(){
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
            $database = new Database();
            $dbInstance = $database->getDB();
            header('Location: views/general/adminPanel/grafica/grafica.html');
            /*
            require_once "views/general/adminPanel/menu.php";
            include('views/general/adminPanel/grafica/grafica.html');
            */

        }else{
            echo("<p class='validado'>No estas validado</p>");
        }

    }

    public function botonVistaComanda(){
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
            $database = new Database();
            $dbInstance = $database->getDB();
            require_once "views/general/adminPanel/menu.php";
            $pedido = new Pedido($dbInstance,null,null,null,null,null,null);
            $catalogo = $pedido->obtenerPedidos();
            include('views/general/adminPanel/tablaComandes.php');
        }else{
            echo("<p class='validado'>No estas validado</p>");
        }
       
     }

    public function botonVistaCategoria(){
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
            $database = new Database();
            $dbInstance = $database->getDB();
            require_once "views/general/adminPanel/menu.php";
            $categoria = new Categoria($dbInstance,null,null,null,null);
            $catalogo = $categoria->obtenerCategorias();
            require_once 'views/general/adminPanel/tablaCategorias.php';
        }else{
            echo("<p class='validado'>No estas validado</p>");
        }

       
    }
    public function mostrarLoginAdmin(){
        include('views/general/formularios/mostrar_login.php');
    }

    public function guardarFirma(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['email'])) {
            $imageName = $_POST['imageName'];
            $imageData = $_POST['imageData'];
            $adminEmail = $_SESSION['email'];
    
            // Adjust the path to the "firmas" folder
            $imgFolder = './views/img/firmas/';
            $filePath = $imgFolder . $imageName;
    
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);
    
            // Create the "firmas" folder if it doesn't exist
            if (!file_exists($imgFolder)) {
                mkdir($imgFolder, 0777, true);
            }
    
            file_put_contents($filePath, $imageData);
    
            require_once "models/database.php";
    
            $database = new Database();
            $pdo = $database->getDB();
    
            $stmt = $pdo->prepare('UPDATE admin SET firma = ? WHERE email = ?');
            $stmt->execute([$filePath, $adminEmail]);
    
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    }

    
    
    
}