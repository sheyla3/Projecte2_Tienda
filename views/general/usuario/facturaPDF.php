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
    public function Content($pedido, $productos_carrito)
    {
        // Establecer la fuente y el tamaño del texto
        $this->SetFont('Arial', '', 12);

        // Agregar título del pedido
        $this->Cell(0, 10, 'Detalles del Pedido #' . $pedido['id_pedido'], 0, 1);
        $this->Ln(5); // Salto de línea

        // Agregar detalles del pedido
        $this->Cell(0, 10, 'Fecha del Pedido: ' . $pedido['fechapedido'], 0, 1);
        // Aquí agregarías más detalles del pedido según tus necesidades

        // Salto de línea
        $this->Ln(10);

        // Agregar tabla de detalles del carrito
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(60, 10, 'Producto', 1, 0, 'C');
        $this->Cell(30, 10, 'Cantidad', 1, 0, 'C');
        $this->Cell(40, 10, 'Precio', 1, 1, 'C');

        $this->SetFont('Arial', '', 12);
        foreach ($productos_carrito as $producto) {
            $this->Cell(60, 10, $producto['id_producto'], 1, 0, 'C');
            $this->Cell(30, 10, $producto['cantidad'], 1, 0, 'C');
            $this->Cell(40, 10, $producto['precio'], 1, 1, 'C');
        }
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
$pdf->Content($pedido, $productos_carrito);

// Generar el PDF
$pdf->Output();


?>