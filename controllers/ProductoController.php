<?php
require_once "models/producto.php";
require_once "models/categoria.php";
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

//buscador general
public function buscarGP()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $busqueda = $_POST['busqueda'];

        // Llama a la función de búsqueda en el modelo
        $database = new Database();
        $dbInstance = $database->getDB();
        $producto = new Producto($dbInstance,null,null,null,null,null,null,null,null,null,null);
        $resultados = $producto->productosBuscador($busqueda);

        try {
            ob_clean();
            // Genera el HTML para toda la tabla
            $htmlTabla = self::generarHTMLCubosProductos($resultados);

            // Imprime el HTML
            echo $htmlTabla;
            exit;
        } catch (Exception $e) {
            // Manejar errores
            http_response_code(500); // Internal Server Error
            exit;
        }
    }
}

public function CrearTablaCompletaPG()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Llama a la función de búsqueda en el modelo
        $database = new Database();
        $dbInstance = $database->getDB();
        $producto = new Producto($dbInstance,null,null,null,null,null,null,null,null,null,null);
        $resultados = $producto->productosGN();

        try {
            ob_clean();
            // Genera el HTML para toda la tabla
            $htmlTabla = self::generarHTMLCubosProductos($resultados);

            // Imprime el HTML
            echo $htmlTabla;
            exit;
        } catch (Exception $e) {
            // Manejar errores
            http_response_code(500); // Internal Server Error
            exit;
        }
    }
}

function generarHTMLCubosProductos($productos)
{
    $htmlGenerado = "<div class='cubosCategorias cubopgg'>";
    $contador = 0;
    foreach ($productos as $producto) {
        if ($producto['estado']) {
            if ($contador % 2 === 0) {
                $htmlGenerado .= '<div class="rowCubosP">';
            }
            $htmlGenerado .= '<a aria-label="Link" href="index.php?controller=Producto&action=mostrarProducto&id_producto=' . $producto['id_producto'] . '">';
            if ($producto['stock'] == 0) {
                $htmlGenerado .= '<div class="cuboPG" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),url(\'' . $producto['img'] . '\')" alt=' . $producto['nombre'] . '>';
            } else {
                $htmlGenerado .= '<div class="cuboPG" style="background-image: url(\'' . $producto['img'] . '\')" alt=' . $producto['nombre'] . '>';
            }
            $htmlGenerado .= '<p class="letraP">' . $producto['nombre'] . ' ' . $producto['precio'] . '€</p>';
            $htmlGenerado .= '</div>';
            $htmlGenerado .= '</a>';
    
            $contador++;
        }
        
        if ($contador % 2 === 0 || $contador === count($productos)) {
            $htmlGenerado .= '</div>'; // Cerrar la fila si el contador es múltiplo de 4 o si es el último producto
        }
    }
    if ($contador == 0) {
        $htmlGenerado .= "Sin productos";
    }
    $htmlGenerado .= "</div>";

    // Retorna el HTML generado
    return $htmlGenerado;
}


//buscador admin
public function CrearTablaCompletaP()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Llama a la función de búsqueda en el modelo
        $database = new Database();
        $dbInstance = $database->getDB();
        $producto = new Producto($dbInstance,null,null,null,null,null,null,null,null,null,null);
        $resultados = $producto->obtenerProductos();

        try {
            ob_clean();
            // Genera el HTML para toda la tabla
            $htmlTabla = self::generarHTMLTablaCategorias($resultados);

            // Imprime el HTML
            echo $htmlTabla;
            exit;
        } catch (Exception $e) {
            // Manejar errores
            http_response_code(500); // Internal Server Error
            exit;
        }
    }
}

    public function buscarP()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $busqueda = $_POST['busqueda'];

        // Llama a la función de búsqueda en el modelo
        $database = new Database();
        $dbInstance = $database->getDB();
        $producto = new Producto($dbInstance,null,null,null,null,null,null,null,null,null,null);
        $resultados = $producto->buscador($busqueda);

        try {
            ob_clean();
            // Genera el HTML para toda la tabla
            $htmlTabla = self::generarHTMLTablaCategorias($resultados);

            // Imprime el HTML
            echo $htmlTabla;
            exit;
        } catch (Exception $e) {
            // Manejar errores
            http_response_code(500); // Internal Server Error
            exit;
        }
    }
}

function generarHTMLTablaCategorias($categorias)
{
    $htmlGenerado = "<table class='admin-panel-page-table'>
        <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Destacado?</th>
            <th>ID Categoria</th>
            <th>Estado</th>
            <th>Referencia</th>
            <th>Editar</th>
        </tr>";

    foreach ($categorias as $producto) {
        $estado = $producto['estado'] == 1 ? 'Activado' : 'Desactivado';
		$destacado = $producto['destacado'] == 1 ? 'SI' : 'NO';
        $htmlGenerado .= "<tr>
                <td class='text'>" . $producto['id_producto'] . "</td>
                <td class='text'>" . $producto['nombre'] . "</td>
                <td class='text'>" . $producto['descripcion'] . "</td>
                <td class='text'>" . $producto['precio'] . "</td>
                <td class='text'>" . $producto['stock'] . "</td>
                <td class='text'>" . $destacado . "</td>
                <td class='text'>" . $producto['id_categoria'] . "</td>
                <td class='text'>" . $estado . "</td>
                <td class='text'>" . $producto['referencia'] . "</td>
                <td class='text'><a href='index.php?controller=Producto&action=botonEditarProducto&id_producto=" . $producto['id_producto'] . "'><img src='views/img/edit.svg' class='image_edit_icon'></a></td>
            </tr>";
    }

    $htmlGenerado .= "</table>";

    // Retorna el HTML generado
    return $htmlGenerado;
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

    public function mostrarProductosPorCatgeoria(){

        $database = new Database();
        $dbInstance = $database->getDB();
        $id_categoria = $_GET['id_categoria'];
        $producto = new Producto($dbInstance,null,null,null,null,null,null,$id_categoria,null,null,null);
        $productos = $producto->productosCategoria();
        include('views/general/paginaCategorias/productosPorCategoria.php');
        
    }

    public function mostrarProductosG(){

        $database = new Database();
        $dbInstance = $database->getDB();
        $producto = new Producto($dbInstance,null,null,null,null,null,null,null,null,null,null);
        $productos = $producto->productosGN();
        include('views/general/paginaPrincipal/productosG.php');
        
    }

    public function mostrarProductosPorPrecioBajo(){

        $database = new Database();
        $dbInstance = $database->getDB();
        $id_categoria = $_GET['id_categoria'];
        $producto = new Producto($dbInstance, null, null, null, null, null, null, $id_categoria, null, null, null);
        $productos = $producto->productosCategoria();
        usort($productos, function ($a, $b) {
            return $a['precio'] - $b['precio'];
        });
        include('views/general/paginaCategorias/productosPorCategoria.php');
        
    }

    public function mostrarProductosPorPrecioAlto(){

        $database = new Database();
        $dbInstance = $database->getDB();
        $id_categoria = $_GET['id_categoria'];
        $producto = new Producto($dbInstance, null, null, null, null, null, null, $id_categoria, null, null, null);
        $productos = $producto->productosCategoria();
        usort($productos, function ($a, $b) {
            return $b['precio'] - $a['precio']; // Cambiado para ordenar de más alto a más bajo
        });
        include('views/general/paginaCategorias/productosPorCategoria.php');
        
    }

    public function mostrarProducto(){

        $database = new Database();
        $dbInstance = $database->getDB();
        $id_producto = $_GET['id_producto'];
        $producto = new Producto($dbInstance,$id_producto,null,null,null,null,null,null,null,null,null);
        $productos = $producto->obtenerInfo();
        include('views\general\paginaPrincipal\detallesProducto.php');
        
    }

    public static function mostrarProductoDestacados(){

        $database = new Database();
        $dbInstance = $database->getDB();
        $productos = new Producto($dbInstance,null,null,null,null,null,null,null,null,null,null);
        $productos = $productos->productoDestacado();
        require_once "views\general\paginaCategorias\productosDestacados.php";
        
    }
    



}