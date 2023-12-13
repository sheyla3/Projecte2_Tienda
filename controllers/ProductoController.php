<?php
require "models/producto.php";
require "models/categoria.php";
require "models/pedido.php";
require "models/admin.php";
require_once "models/database.php";

class ProductoController
{
    public function mostrarProductos()
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin'){
            // require_once "views/adminPanel/menu.php";
            $database = new Database();
            $dbInstance = $database->getDB();
            require_once "views/general/adminPanel/menu.php";
            $producto = new Producto($dbInstance,null,null,null,null,null,null,null,null,null);
            $catalogo = $producto->obtenerProductos();
            require_once "views/general/adminPanel/tablaProductos.php";
        }
        else{
            // adminIncorrecte();
        }
    }

    public function buscarproductos($filtro)
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
            // Acceso a la base de datos y búsqueda de productos
            $database = new Database();
            $dbInstance = $database->getDB();
            $producto = new Producto($dbInstance, null, null, null, null, null, null, null, null, null);
            $resultados = $producto->buscarproductos($filtro);
    
            // Devolver resultados como JSON
            header('Content-Type: application/json');
            echo json_encode($resultados);
            exit(); // Terminar la ejecución para evitar cualquier otra salida
        } else {
            // Manejar caso en que el usuario no sea un administrador o no haya sesión activa
        }
    }

    public function botonCrearProducto(){
        $database = new Database();
        $dbInstance = $database->getDB();

        $categoria = new Categoria($dbInstance ,null, null, null, null);
        $categorias = $categoria->obtenerIdNombreCategorias();

        
        include('views/general/adminPanel/formularios/crearProducto.php');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //$id_producto = $_POST['id_producto'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $imagen = $_POST['imagen'];
            $categoria1 = $_POST['categoria'];

            //parte de generar el id
            $categoriaNombre = new Categoria($dbInstance, $categoria1, null, null, null);
            $categoriasResult = $categoriaNombre->obtenerNombre();
            
            $Numproducto = new Producto($dbInstance, null, null, null, null, null, null, null, null, null, null);
            $numeroRegistros = $Numproducto->obtenerNumeroProductos();
            $dosPrimerasLetrasCate = substr($categoriasResult, 0, 2);
            $dosPrimerasLetrasProd = substr($nombre, 0, 2);
            
            $id_producto = $dosPrimerasLetrasCate . ($numeroRegistros + 1) . "-" . $dosPrimerasLetrasProd;
            
            
            
            // Obtener información del archivo de imagen
            $nombreArchivo = $_FILES['imagen']['name'];
            $tipoArchivo = $_FILES['imagen']['type'];
            $tamanoArchivo = $_FILES['imagen']['size'];
            $tempArchivo = $_FILES['imagen']['tmp_name'];
            
            // Obtener la extensión del archivo
            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

            // Crear el nombre del archivo basado en el ID del producto
            $nombreArchivoGuardar = $id_producto . "." . $extension;

            // Ruta donde se guardará la imagen
            $rutaGuardar = "img/" . $nombreArchivoGuardar;

            // Mover el archivo a la carpeta deseada
            move_uploaded_file($tempArchivo, $rutaGuardar);

            // Resto de tu lógica para guardar la información en la base de datos
            // ...
            
            // Pasar la ruta correcta a la base de datos
            $imagen = $rutaGuardar;
            


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

    public function botonEditarProducto(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $database = new Database();
            $dbInstance = $database->getDB();
            
            // Obtener los datos del formulario
            $id_producto = $_GET['id_producto'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $destacado = isset($_POST['destacado']) ? 1 : 0;
            $id_categoria = $_POST['categoria']; // Asegúrate de tener el nombre correcto del campo select
            $estado = isset($_POST['estado']) ? 1 : 0;
            $referencia = isset($_POST['referencia']) ? 1 : 0;
            
            //parte de la imagen 
            if (!empty($_FILES['imagen']['name'])) {
                // Obtener información del archivo de imagen
                $nombreArchivo = $_FILES['imagen']['name'];
                $tipoArchivo = $_FILES['imagen']['type'];
                $tamanoArchivo = $_FILES['imagen']['size'];
                $tempArchivo = $_FILES['imagen']['tmp_name'];
                
                // Obtener la extensión del archivo
                $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

                // Crear el nombre del archivo basado en el ID del producto
                $nombreArchivoGuardar = $id_producto . "." . $extension;

                // Ruta donde se guardará la imagen
                $rutaGuardar = "img/" . $nombreArchivoGuardar;
        
                // Mover el archivo a la carpeta deseada y reemplazar la foto existente
                if (move_uploaded_file($tempArchivo, $rutaGuardar)) {
                    
                } else {
                    // Manejar si la subida de archivo falla
                }
            } else {
                
            }

            
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
                $fotos = $producto->obtenerFotos();
                $categoria = new Categoria($dbInstance ,null, null, null , null);
                $categorias = $categoria->obtenerIdNombreCategorias();
                include('views/general/adminPanel/formularios/editarProducto.php');
            } else {
                // Manejo para cuando no se recibe el parámetro id_categoria
            }
        }

    }
    



}