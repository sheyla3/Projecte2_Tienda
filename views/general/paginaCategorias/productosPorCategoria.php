<div class="cubosCategorias">
    <a href="index.php?controller=Producto&action=mostrarProductosPorPrecioBajo&id_categoria=<?php echo $id_categoria; ?>">
        <img src="" alt="icono" style="margin-right: 10px;">
        Productos por precio bajo
    </a>
    <a href="index.php?controller=Producto&action=mostrarProductosPorPrecioAlto&id_categoria=<?php echo $id_categoria; ?>">Productos por precio alto</a>
    <?php
    $contador = 0;
    foreach ($productos as $producto) {
        if ($producto['estado']){
            if ($contador % 4 === 0) {
                echo '<div class="rowCubosP">';
            }
            echo '<a aria-label="Link" href="index.php?controller=Producto&action=mostrarProducto&id_producto=' . $producto['id_producto'] . '">';
            if ( $producto['stock'] == 0 ) {
                echo '<div class="cuboP" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),url(\'' . $producto['img'] . '\')" alt='.$producto['nombre'].'>'; 
            } else {
                echo '<div class="cuboP" style="background-image: url(\'' . $producto['img'] . '\')" alt='.$producto['nombre'].'>'; 
            }
            echo '<p class="letraP">'. $producto['nombre'] . ' '. $producto['precio'].'€</p>';
            echo '</div>';
            echo '</a>';
    
            $contador++;
        }
        

        if ($contador % 4 === 0 || $contador === count($productos)) {
            echo '</div>'; // Cerrar la fila si el contador es múltiplo de 4 o si es el último producto
        }
    }
    if($contador == 0){
        echo("Sin productos");
    }
    ?>
</div>
