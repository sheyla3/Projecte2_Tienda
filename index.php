<?php
session_start();
?>
<!--Controlador frontal: fichero que se encarga de cargarlo absolutamente-->
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="img/logo.png">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>SRG</title>
</head>


<body>
   
    <script src="script.js"></script>
    <?php
   
    require_once "autoload.php";
    require_once "views/general/pie.php";
    $_SESSION['seccion'] = "nada";
   
    if (isset($_GET['controller'])) {
        $nombreController = $_GET['controller'] . "Controller";
    } else {
        //Controlador per dedecte
        $nombreController = "PrincipalController";
    }
    if (class_exists($nombreController)) {
        $controlador = new $nombreController();
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = "mostrarPaginaPrincipal";
           
        }
        $controlador->$action();
        
    } else {
        echo "No existe el controlador";
    }
    
    CategoriaController::RellenarMenu();
    




    if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin'){
        require_once "views/general/adminPanel/cabezeraAdmin.html";
       
    }elseif (isset($_SESSION['email']) && $_SESSION['role'] == 'user'){
        require_once "views/general/cabezeraSesion.php";
        
    }else{
        require_once "views/general/cabezera.php";
       
        //require_once "views/general/cabezera.html";
    }


    // require_once "views/general/pie.html";
    // require_once "views/general/wrapper.php";
    ?>
</body>


</html>
