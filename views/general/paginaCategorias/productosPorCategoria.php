<div class="cubosCategorias">
    <?php
    $contador = 0;
    foreach ($productos as $producto) {
        if ($contador % 4 === 0) {
            echo '<div class="rowCubosP">';
        }
        echo '<a href="index.php?controller=Producto&action=mostrarProducto&id_producto=' . $producto['id_producto'] . '">';
        echo '<div class="cuboP" style="background-image: url(\'' . $producto['img'] . '\')">'; 
        echo '<p class="letraP">'. $producto['nombre'] . ' '. $producto['precio'].'€</p>';
        echo '</div>';
        echo '</a>';

        $contador++;

        if ($contador % 4 === 0 || $contador === count($productos)) {
            echo '</div>'; // Cerrar la fila si el contador es múltiplo de 4 o si es el último producto
        }
    }
    ?>
</div>
