<?php
$producto = $productos[0];
$precioFormateado = number_format($producto['precio'], 2) . '€';
//<button type="submit" class="enviar">Recibir aviso</button>
?>

<div class="Desktop1" id="oscuro">
    <img class="FotoZapato" src="<?php echo $producto['img']; ?>" alt="<?php echo $producto['nombre']?>" />
    <div class="ZonaInfo">
        <div class="NombreProducto"><?php echo $producto['nombre']; ?></div>
        <div class="Precio"><?php echo $precioFormateado; ?></div>
        <?php if ($producto['stock'] == 0) { ?>
            <style>.FotoZapato{filter: brightness(50%);}</style>
            <p>Producto Agotado</p>
            <button onclick="mostrarEnviarCorreo()">¡Lo quiero! 💌</button>
            <div class="overlay" id="overlay">
                <div class="popup" id="EnviarCorreo">
                    <form action="#" method='POST' enctype="multipart/form-data">
                        <div class="close-btn" onclick="ocultarEnviarCorreo()">🗙</div>
                        <h2><?php echo $producto['nombre']; ?></h2>
                        <p>Te avisaremos a tu e-mail cuando el producto vuelva a estar disponible</p>
                        <input type="email" id="email" name="email">
                    </form>
                </div>
            </div>
       <?php } else {?>
        <form action='index.php?controller=carrito&action=añadirAlCarrito' method='POST' enctype="multipart/form-data"> 
            <div class="contenedorCant">
                <label for="cantidad" id="labelCantidad">Cantidad:</label>
                <input id="cantidad" type="number" name="cantidad" min="0" max="<?php echo $producto['stock']; ?>" value="0">
            </div>
            <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
            <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
            <button type="submit" class="botonAñadir">Añadir a la cesta</button>
        </form>
        <?php }?>
        <div class="Descripcion"><?php echo $producto['descripcion']; ?></div>
    </div>
</div>

<script>
    function mostrarEnviarCorreo() {
        document.getElementById('overlay').style.display = 'flex';
    }

    function ocultarEnviarCorreo() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>
<style>
    /* Estilos para el pop-up */
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1;
    }

    .popup {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        max-width: 400px;
        margin: 0 auto;
        text-align: center;
    }

    .close-btn {
        margin-top: 10px;
        cursor: pointer;
    }
</style>
