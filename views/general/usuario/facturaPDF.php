<?php

require("vendor/setasign/fpdf/fpdf.php");

class PDF extends FPDF
{
    // Método para la cabecera del PDF
    public function Header()
    {
        // Puedes personalizar la cabecera aquí si lo deseas
        // Por ejemplo, agregar un logo o datos de la empresa
    }

    // Método para el contenido del PDF
    public function Content()
    {
        // Establecer la fuente y el tamaño del texto
        $this->SetFont('Arial', 'B', 16);

        // Agregar el texto "Hola Mundo"
        $this->Cell(40, 10, '¡Hola Mundo!', 0, 1); // El último argumento 1 indica que se agrega un salto de línea después del texto
    }

    // Método para el pie de página del PDF
    public function Footer()
    {
        // Configurar posición y fuente del pie de página
        $this->SetY(-15);
        $this->SetFont("Arial", "I", 10);

        // Agregar número de página
        $this->Cell(0, 10, utf8_decode("Página ") . $this->PageNo() . '/{nb}', 0, 0, "C");
    }
}

// Crear instancia de la clase PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Llamar al método Content para agregar el contenido al PDF
$pdf->Content();

// Generar el PDF
$pdf->Output();

?>
