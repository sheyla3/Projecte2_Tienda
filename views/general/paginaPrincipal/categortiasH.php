<div class="cubosCategorias">
<?php
$contador = 0;
foreach ($categorias as $categoria) {
    if ($contador % 2 === 0) {
        echo '<div class="rowCubos">';
    }

    echo '<div class="categoriaCubo">';
    echo '<p class="cubo">'. $categoria['nombre'] . '</p>';
    echo '</div>';

    if ($contador % 2 !== 0 || $contador === count($categorias) - 1) {
        echo '</div>'; // Cerrar la fila si el contador no es par o si es la última categoría
    }

    $contador++;
}

?>
</div>


<!-- $userAgent = $_SERVER['HTTP_USER_AGENT'];
echo "User Agent: " . $userAgent; -->