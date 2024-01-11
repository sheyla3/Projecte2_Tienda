<div class="cubosCategorias">
<?php
$contador = 0;
echo '<h3>Categorias Mujer</h3>';
foreach ($categorias as $categoria) {
    if ($contador % 2 === 0) {
        echo '<div class="rowCubos">';
    }
    echo '<a href="index.php?controller=Producto&action=mostrarProductosPorCatgeoria&id_categoria=' . $categoria['id_categoria'] . '">';
    echo '<div class="categoriaCubo" style="background-image: url(' . (!empty($categoria['primera_foto']) ? '\'' . $categoria['primera_foto'] . '\'' : '') . ')">';
    
    if (empty($categoria['primera_foto'])) {
        // Si no hay primera_foto, puedes agregar un mensaje o contenido alternativo
        
    }
    
    echo '<p class="cubo">' . $categoria['nombre'] . '</p>';
    echo '</div>';
    echo '</a>';

    if ($contador % 2 !== 0 || $contador === count($categorias) - 1) {
        echo '</div>'; // Cerrar la fila si el contador no es par o si es la última categoría
    }

    $contador++;
}
?>
</div>
