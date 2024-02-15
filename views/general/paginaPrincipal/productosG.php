<div class="contBPG">   
     <form action='' aria-label='formulario' method='post' class='formCat buscador'>
        <label for='PGbuscar' name='PGbuscar'><img src='views/img/AdminLupa.png' alt='Buscar' width='20' height='20'></label>
        <input type='text' id='PGbuscar' name='PGbuscar'>
</div>
<div class="cubosCategorias" id="tabla-pg">

	</form>
    <?php
    $contador = 0;
    foreach ($productos as $producto) {
        if ($producto['estado']){
            if ($contador % 4 === 0) {
                echo '<div class="rowCubosP">';
            }
            echo '<a aria-label="Link" href="index.php?controller=Producto&action=mostrarProducto&id_producto=' . $producto['id_producto'] . '">';
            if ( $producto['stock'] == 0 ) {
                echo '<div class="cuboPG" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),url(\'' . $producto['img'] . '\')" alt='.$producto['nombre'].'>'; 
            } else {
                echo '<div class="cuboPG" style="background-image: url(\'' . $producto['img'] . '\')" alt='.$producto['nombre'].'>'; 
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
