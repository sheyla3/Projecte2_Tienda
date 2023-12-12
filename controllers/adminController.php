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

    public function botonEditarProducto(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $database = new Database();
            $dbInstance = $database->getDB();
            
            // Obtener los datos del formulario
            $id_producto = $_POST['id_producto'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $destacado = isset($_POST['destacado']) ? 1 : 0;
            $id_categoria = $_POST['categoria']; // Asegúrate de tener el nombre correcto del campo select
            $estado = isset($_POST['estado']) ? 1 : 0;
            $referencia = isset($_POST['referencia']) ? 1 : 0;
            // Otros campos del formulario que necesites obtener...

            
            $producto = new Producto(
                $dbInstance,
                $id_producto,
                $nombre,
                $descripcion,
                $precio,
                $stock,
                $destacado,
                $id_categoria,
                $estado,
                null, // Agrega el valor correspondiente para el estado
                $referencia, // Agrega el valor correspondiente para la referencia
                /* Agrega los otros campos del formulario aquí */
            );
            
            
            
            $funciona = $producto->editar();
            
            if ($funciona) {
                header('Location: index.php?controller=Admin&action=botonVistaProducto');
            } else {
                // Manejo del error al editar la categoría
            }
        } else {
            if (isset($_GET['id_producto'])) {
                $id_producto = $_GET['id_producto'];
                $database = new Database();
                $dbInstance = $database->getDB();
                $producto = new Producto($dbInstance,$id_producto,null,null,null,null,null,null,null,null,null);
                $info = $producto->obtenerInfo($id_producto);
                $categoria = new Categoria($dbInstance ,null, null, null , null);
                $categorias = $categoria->obtenerIdNombreCategorias();
                include('views/general/adminPanel/formularios/editarProducto.php');
            } else {
                // Manejo para cuando no se recibe el parámetro id_categoria
            }
        }

    }

    public function botonEditarCategoria() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_categoria = $_GET['id_categoria'];
            $database = new Database();
            $dbInstance = $database->getDB();
            
            $nombre = $_POST['nombre'];
            $genero = $_POST['genero'];
            if (isset($_POST['estado'])) {
                // El checkbox está marcado
                // Realiza alguna acción si está marcado
                $estado = 1; // O asigna el valor que necesites para 'true'
            } else {
                // El checkbox no está marcado
                // Realiza alguna acción si no está marcado
                $estado = 0; // O asigna el valor que necesites para 'false'
            }
            
            $categoriaEditada = new Categoria($dbInstance, $id_categoria, $nombre, $estado, $genero);
            $funciona = $categoriaEditada->editar();
            
            if ($funciona) {
                header('Location: index.php?controller=Admin&action=botonVistaCategoria');
            } else {
                // Manejo del error al editar la categoría
            }
        } else {
            if (isset($_GET['id_categoria'])) {
                $id_categoria = $_GET['id_categoria'];
                $database = new Database();
                $dbInstance = $database->getDB();
                $categoria = new Categoria($dbInstance, $id_categoria, null, null, null);
                $info = $categoria->obtenerInfo($id_categoria);
                include('views/general/adminPanel/formularios/editarCategoria.php');
            } else {
                // Manejo para cuando no se recibe el parámetro id_categoria
            }
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
                header('Location: index.php?controller=Admin&action=botonVistaCategoria');
            }else{

            }
        }
    }

    public function botonCrearProducto(){
        $database = new Database();
        $dbInstance = $database->getDB();

        $categoria = new Categoria($dbInstance ,null, null, null , null);
        $categorias = $categoria->obtenerIdNombreCategorias();

        
        include('views/general/adminPanel/formularios/crearProducto.php');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_producto = $_POST['id_producto'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $imagen = $_POST['imagen'];
            $categoria1 = $_POST['categoria'];
      

            

            if (isset($_POST['estado'])) {
                // El checkbox está marcado
                // Realiza alguna acción si está marcado
                $estado = 1; // O asigna el valor que necesites para 'true'
            } else {
                // El checkbox no está marcado
                // Realiza alguna acción si no está marcado
                $estado = 0; // O asigna el valor que necesites para 'false'
            }


            if (isset($_POST['destacado'])) {
                // El checkbox está marcado
                // Realiza alguna acción si está marcado
                $destacado = 1; // O asigna el valor que necesites para 'true'
            } else {
                // El checkbox no está marcado
                // Realiza alguna acción si no está marcado
                $destacado = 0; // O asigna el valor que necesites para 'false'
            }

            if (isset($_POST['referencia'])) {
                // El checkbox está marcado
                // Realiza alguna acción si está marcado
                $referencia = 1; // O asigna el valor que necesites para 'true'
            } else {
                // El checkbox no está marcado
                // Realiza alguna acción si no está marcado
                $referencia = 0; // O asigna el valor que necesites para 'false'
            }

            $database = new Database();
            $dbInstance = $database->getDB();

            $producto = new Producto($dbInstance ,$id_producto, $nombre, $descripcion, $precio, $stock, $destacado,$categoria1, $estado, $imagen, $referencia);
            $funciona = $producto->anadir();

            if($funciona){
                header('Location: index.php?controller=Admin&action=botonVistaProducto');
            }else{

            }
        }
    }


   

    public function mostrarLoginAdmin(){
        include('views/general/formularios/mostrar_login.php');
    }
    
}