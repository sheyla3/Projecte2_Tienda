<?php
$producto = $productos[0];
$precioFormateado = number_format($producto['precio'], 2) . '€';
?>

<div class="Desktop1">
    <img class="FotoZapato" src="<?php echo $producto['img']; ?>" alt="<?php echo $producto['nombre']?>" />
    <div class="ZonaInfo">
        <div class="NombreProducto"><?php echo $producto['nombre']; ?></div>
        <div class="Precio"><?php echo $precioFormateado; ?></div>
        <form action="detallesProducto.php" action='meter aqui' method='POST' enctype="multipart/form-data"> 
            <div class="contenedorCant">
                <label for="cantidad" id="labelCantidad">Cantidad:</label>
                <input id="cantidad" type="number" name="cantidad" min="0" max="<?php echo $producto['stock']; ?>" value="0">
            </div>
            <button type="submit" class="botonAñadir">Añadir a la cesta</button>
        </form>
        <div class="Descripcion"><?php echo $producto['descripcion']; ?></div>
    </div>
</div>