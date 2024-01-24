<?php

require_once "models/categoria.php";
require_once "models/database.php";

class CategoriaController
{
    public function mostrarProductos()
    {
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin'){
            $database = new Database();
            $dbInstance = $database->getDB();
            require_once "views/general/adminPanel/menu.php";
            $categoria = new Categoria($dbInstance,null,null,null,null);
            $catalogo = $categoria->obtenerCategorias();
            require_once "views/general/adminPanel/tablaCategorias.php";

        }
        else{
            adminIncorrecte();
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
            $estado = true;
/*
            if (isset($_POST['estado'])) {
                // El checkbox está marcado
                // Realiza alguna acción si está marcado
                 // O asigna el valor que necesites para 'true'
            } else {
                // El checkbox no está marcado
                // Realiza alguna acción si no está marcado
                $estado = false; // O asigna el valor que necesites para 'false'
            }*/

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

// public function buscarCategoria()
// {
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         $busqueda = $_POST['busqueda'];

//         // Llama a la función de búsqueda en el modelo
//         $database = new Database();
//         $dbInstance = $database->getDB();
//         $categoria = new Categoria($dbInstance, null, null, null, null);
//         $resultados = $categoria->buscador($busqueda);

//         try {
//             // Establece la cabecera Content-Type a application/json
//           //  header('Content-Type: application/json');

//             // Imprime el JSON
//             ob_clean();
//             echo json_encode(['success' => true, 'data' => $resultados]);
            
//             exit;
//         } catch (Exception $e) {
//             // Manejar errores
//             http_response_code(500); // Internal Server Error
//          //   echo json_encode(['success' => false, 'error' => $e->getMessage()]);
//          //   echo json_decode("hola");
//             exit;
//         }
//     }
// }

public function CrearTablaCompletaCategoria()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Llama a la función de búsqueda en el modelo
        $database = new Database();
        $dbInstance = $database->getDB();
        $categoria = new Categoria($dbInstance,null,null,null,null);
        $resultados = $categoria->obtenerCategorias();

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

public function buscarCategoria()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $busqueda = $_POST['busqueda'];

        // Llama a la función de búsqueda en el modelo
        $database = new Database();
        $dbInstance = $database->getDB();
        $categoria = new Categoria($dbInstance, null, null, null, null);
        $resultados = $categoria->buscador($busqueda);

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

// Función para generar el HTML de toda la tabla de categorías
function generarHTMLTablaCategorias($categorias)
{
    $htmlGenerado = "<table class='admin-panel-page-table'>
        <tr>
            <th>ID Categoria</th>
            <th>Nombre</th>
            <th>Género</th>
            <th>Estado</th>
            <th>Editar</th>
        </tr>";

    foreach ($categorias as $categoria) {
        $estado = $categoria['estado'] == 1 ? 'Activado' : 'Desactivado';
        $htmlGenerado .= "<tr>
                <td class='text'>" . $categoria['id_categoria'] . "</td>
                <td class='text'>" . $categoria['nombre'] . "</td>
                <td class='text'>" . $categoria['sexo'] . "</td>
                <td class='text'>" . $estado . "</td>
                <td class='text'><a href='index.php?controller=Categoria&action=botonEditarCategoria&id_categoria=" . $categoria['id_categoria'] . "'><img src='views/img/edit.svg' class='image_edit_icon'></a></td>
            </tr>";
    }

    $htmlGenerado .= "</table>";

    // Retorna el HTML generado
    return $htmlGenerado;
}



    

    public function MostrarCubosCategoriasHombre(){
        $database = new Database();
        $dbInstance = $database->getDB();

        $categoria = new Categoria($dbInstance ,null, null, null , null);
        $categorias = $categoria->obtenerIdNombreCategoriasHombre();

        require_once "views/general/paginaPrincipal/categortiasH.php";

    }

    public function MostrarCubosCategoriasMujer(){
        $database = new Database();
        $dbInstance = $database->getDB();

        $categoria = new Categoria($dbInstance ,null, null, null , null);
        $categorias = $categoria->obtenerIdNombreCategoriasMujer();

        require_once "views/general/paginaPrincipal/categortiasM.php";

    }

    public static function RellenarMenu(){
        $database = new Database();
        $dbInstance = $database->getDB();

        $categoria = new Categoria($dbInstance ,null, null, null , null);
        $categoriasM = $categoria->obtenerIdNombreCategoriasMujer();
        $categoriasH = $categoria->obtenerIdNombreCategoriasHombre();

        require_once "views\general\cabezera.php";

    }

   

}
