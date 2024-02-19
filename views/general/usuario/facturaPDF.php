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
    public function Content($pedido, $productos_carrito, $datosE, $datosUser, $firma)
    {
        // Establecer la fuente y el tamaño del texto
        $this->SetFont('Arial', '', 9);

        $imagenPath = $datosE[0]['logo'];

        $firma = $firma[0]['firma'];

        // Obtener la posición actual
        $x = $this->GetX();
        $y = $this->GetY();

        // Mostrar la imagen en la posición actual
        $this->Image($imagenPath, $x, $y, 50, 0, 'PNG'); 
        $this->Ln(18); // Salto de línea
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 4, '' . $datosE[0]['nombre'], 0, 1);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 4, '' . $datosE[0]['direccion'], 0, 1);
        $this->Cell(0, 4, '' . $datosE[0]['cif'], 0, 1);
        $this->Cell(0, 4, '' . $datosE[0]['telf'], 0, 1);
        $this->Ln(10); // Salto de línea
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 4, 'Cliente', 0, 1);
        $this->SetFont('Arial', '', 9);
        $this->Cell(6, 4, $datosUser[0]['correo'], 0, 1);
        $this->Cell(6, 4, $datosUser[0]['nombre'] .' ' . $datosUser[0]['apellidos'] , 0, 1);
        $this->Cell(6, 4, $datosUser[0]['telf'], 0, 1);

        $this->Ln(10);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(6, 4, 'Direccion', 0, 1);
        $this->SetFont('Arial', '', 9);
        $this->Cell(6, 4, $datosUser[0]['direccion'], 0, 1);
        $this->Cell(0, 10, 'Fecha del Pedido: ' . $pedido['fechapedido'], 0, 1);
        // Aquí agregarías más detalles del pedido según tus necesidades

        // Salto de línea
        $this->Ln(10);
        $this->SetLeftMargin(10);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 4, 'Fecha: ' . $pedido['fechapedido'], 0, 1);


        $color = true;
        if ($color) {
            $this->SetFillColor(235, 235, 235); // Gris claro
        }
        $this->SetLeftMargin(10); // Puedes ajustar el valor según sea necesario

        // Crear una nueva página si es necesario
       

        // Establecer la posición X para la tabla
        $this->SetX(10); 
        
        // Agregar tabla de detalles del carrito
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(70, 10, 'CONCEPTO', 0, 0, 'C',$color);
        $this->Cell(40, 10, 'PRECIO', 0, 0, 'C',$color);
        $this->Cell(40, 10, 'CANTIDAD', 0, 0, 'C',$color); // Eliminamos la nueva línea aquí
        $this->Cell(40, 10, 'TOTAL', 0, 1, 'C',$color); // Eliminamos la nueva línea aquí
        
        $this->SetFont('Arial', '', 9);

        $fill = false;

        $this->SetFont('Arial', '', 9);
        foreach ($productos_carrito as $producto) {
            $total = $producto['precio'] * $producto['cantidad'];
            // Alternar entre los colores de fondo
            if ($fill) {
                $this->SetFillColor(235, 235, 235); // Gris claro
            } else {
                $this->SetFillColor(255, 255, 255); // Blanco
            }

            // Dibujar la fila de la tabla con el color de fondo correspondiente
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(70, 10, $producto['id_producto'], 0, 0, 'C', $fill);
            $this->Cell(40, 10, $producto['cantidad'], 0, 0, 'C', $fill);
            $this->Cell(40, 10, $producto['precio'] . '$', 0, 0, 'C', $fill);
            $this->Cell(40, 10, $total. '$', 0, 1, 'C', $fill);

            // Cambiar el valor de la variable $fill para alternar entre los colores
            $fill = !$fill;
        }
        // Establece la posición actual como (x, y)
            $posX = $this->GetX();
            $posY = $this->GetY();

            // Mueve la posición hacia la derecha para la imagen
            $this->SetX($posX);

            // Muestra el texto y la imagen en la misma celda
            $this->Cell(40, 05, 'Firma administrador: ', 0, 0, 'L', false);
            $this->Image($firma, $posX, $posY + 05, 50, 0, 'PNG'); // Ajusta la posición horizontal (40) según tus necesidades

            // Restaura la posición actual a la que estaba antes de mostrar el texto e imagen
            $this->SetXY($posX, $posY);

       

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
$pdf->Content($pedido, $productos_carrito, $datosE, $datosUser, $firma);

// Generar el PDF
$pdf->Output();


?>