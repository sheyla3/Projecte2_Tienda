<?php

require("vendor/setasign/fpdf/fpdf.php");
// require_once 'vendor/autoload.php'; // Carga el autoloader de Composer

use Fpdf\Fpdf;

// Crea una clase extendida de FPDF
class PDF extends FPDF {
    // Cabecera
    function Header() {
        // Logo
        $this->Image('logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30,10,'Factura de Pedido',0,0,'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Crear nuevo objeto PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Configurar fuente y tamaño de texto para el contenido
$pdf->SetFont('Arial','',12);

// Aquí obtendrías los datos del pedido de la base de datos
$pedido_id = $_GET['pedido_id']; // Supongamos que pasas el ID del pedido a través de la URL
// Realiza la consulta a la base de datos para obtener los detalles del pedido
// Puedes hacerlo usando PDO, mysqli u otra extensión de base de datos en PHP

// Ejemplo de cómo podrías mostrar los detalles del pedido
$pdf->Cell(0, 10, 'Detalles del Pedido #' . $pedido_id, 0, 1);
$pdf->Cell(0, 10, 'Fecha del Pedido: ' . date('Y-m-d'), 0, 1);
$pdf->Cell(0, 10, 'Datos del Cliente:', 0, 1);
// Aquí agregarías los detalles del cliente obtenidos de la base de datos

$pdf->Cell(0, 10, 'Datos del Producto:', 0, 1);
// Aquí agregarías los detalles del producto obtenidos de la base de datos

$pdf->Cell(0, 10, 'Datos de la Empresa:', 0, 1);
// Aquí agregarías los detalles de la empresa obtenidos de la base de datos

// Generar el PDF y enviarlo al navegador
$pdf->Output();
