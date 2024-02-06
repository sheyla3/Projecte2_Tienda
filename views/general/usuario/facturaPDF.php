
<?php


require("vendor/setasign/fpdf/fpdf.php"); //Ten cuidado


class PDF extends FPDF{
    //Formato del pdf que no se cambia


    //Adaptarlo para que coja lo de la tabla
    public function Cabezera(){ //Poner datos de la empresa
        $this->SetFont("Arial","B",20); //B-negrita
        $this->Cell(60); //movernos a la derecha
        $this->Cell(70,10,"SRG",1,0,"C"); //Ejemplo de titulo
        $this->Ln(20);//salto de linea




        //Thead de la tabla
        $this->Cell(90,10,"foto",1,0,"C",0); //ancho,alto,texto bbdd,borde,salto de linea,alineado, relleno
        $this->Cell(90,10,"nombre",1,0,"C",0);
        $this->Cell(90,10,"precio",1,1,"C",0);//este tiene salto de linea
    }


    public function Footer() {
        $this->SetY(-15); // 1,5cm del fianl
        $this->SetFont("Arial","I",10);
        $this->Cell(0,10,utf8_decode("Página ").$this->PageNo().'/{nb]',0,0,"C"); //paginas numeradas
    }
}
//Lo que se cambia
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont("Arial","B",18);


$pdf->Output();




/*
Si tienes unproblema con esta linea @set_magic_quotes_runtime(0);
Pon esto --> @ini_set('magic_quotes_runtime', 0);
p en esta otra linea --> if (get_magic_quotes_runtime())
pon esto --> if (ini_get('magic_quotes_runtime'))


*/
?>
