<?php

require("C:/Windows/System32/vendor/setasign/fpdf/fpdf.php");

class PDF extends FPDF{
    //Formato del pdf que no se cambia

    //Adaptarlo para que coja lo de la tabla
    public function header(){ //Poner datos de la empresa
        $this->SetFont("Arial","B",20); //B-negrita
        $this->Cell(60); //movernos a la derecha
        $this->Cell(70,10,"SRG: Productos",0,0,"C"); //Ejemplo de titulo
        $this->Ln(20);//salto de linea


        //Thead de la tabla
        $this->Cell(70,10,"Id",1,0,"C",0); //ancho,alto,texto bbdd,borde,salto de linea,alineado, relleno
        $this->Cell(60,10,"Nombre",1,0,"C",0);
        $this->Cell(60,10,"Precio",1,1,"C",0);//este tiene salto de linea
    }

    public function Footer() {
        $this->SetY(-15); // 1,5cm del fianl
        $this->SetFont("Arial","",10);
        $this->Cell(0, 10, $this->PageNo() . '/{nb}', 0, 0, "R"); //paginas numeradas
    }
}
//Lo que se cambia
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont("Arial","B",18);



$servername = "localhost";
$username = "postgres";
$password = "postgre";
$dbname = "srg";
$conexion = new PDO("pgsql:host=$servername;dbname=$dbname",$username, $password);
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "Select * From productos";
$resultado = $conexion->query($sql);


while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(70,10,$fila["id_producto"],0,0,"C",0); //ancho,alto,texto bbdd,borde,salto de linea,alineado, relleno
    $pdf->Cell(60,10,$fila["nombre"],0,0,"C",0);
    $pdf->Cell(60,10,$fila["precio"],0,1,"C",0);//este tiene salto de linea
}

$pdf->Output();
?>