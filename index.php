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
    <script src="cesta.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="img/logo.png">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>SRG</title>
</head>


<body>
   
    <script src="script.js"></script>
    <script src="cesta.js"></script>
    <?php
   
    require_once "autoload.php";
    require_once "views/general/botonSubir.php";
    // require_once "views/general/botonBajar.php";
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
    
    // require __DIR__.'/vendor/autoload.php';

    // use Spipu\Html2Pdf\Html2Pdf;

    // $html2pdf = new Html2Pdf();
    // $html2pdf->writeHTML('<h1>HelloWorld</h1>');
    // $html2pdf->output("pdfGenerado.pdf");


    if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin'){
        require_once "views/general/adminPanel/cabezeraAdmin.html";
       
    }elseif (isset($_SESSION['email']) && $_SESSION['role'] == 'user'){
        CategoriaController::RellenarMenuValidado();
    }else{
        require_once "views/general/cabezera.php";
    }
    ?>
</body>


</html>
