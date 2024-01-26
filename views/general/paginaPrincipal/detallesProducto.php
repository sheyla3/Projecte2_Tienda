
<?php
$producto = $productos[0];
$precioFormateado = number_format($producto['precio'], 2) . '€';


?>

<div class="Desktop1">
    <img class="FotoZapato" src="<?php echo $producto['img']; ?>" alt="<?php echo $producto['nombre']?>" />
    <div class="ZonaInfo">
        <div class="NombreProducto"><?php echo $producto['nombre']; ?></div>
        <div class="Precio"><?php echo $precioFormateado; ?></div>
        <?php if ($producto['stock'] == 0 && isset($_SESSION['email'])){
            $correo = $_SESSION['email'];
            ?>
            <style>.FotoZapato{filter: brightness(50%);}</style>
            <p>Producto Agotado</p>
            <button onclick="mostrarEnviarCorreo()" class="btnEnv">¡Lo quiero! 💌</button>
            <div class="overlay" id="overlay">
                <div class="popup" id="EnviarCorreo">
                    <form action="#" method='POST' enctype="multipart/form-data">
                        <div class="close-btn" onclick="ocultarEnviarCorreo()">🗙</div>
                        <h2><?php echo $producto['nombre']; ?></h2>
                        <p>Te avisaremos a tu e-mail cuando el producto vuelva a estar disponible</p>
                        <label>Verifique si es este su e-mail:</label><br><br>


                        <input type="email" id="email" name="email" value="<?php echo $correo; ?>"><br><br>


                        <input type="submit" class="btnEnv" value="Es correcto">
                    </form>
                </div>
            </div>
        <?php }elseif ($producto['stock'] == 0) { ?>
            <style>.FotoZapato{filter: brightness(50%);}</style>
            <p>Producto Agotado</p>
            <button onclick="mostrarEnviarCorreo()" class="btnEnv">¡Lo quiero! 💌</button>
            <div class="overlay" id="overlay">
                <div class="popup" id="EnviarCorreo">
                    <form action="#" method='POST' enctype="multipart/form-data">
                        <div class="close-btn" onclick="ocultarEnviarCorreo()">🗙</div>
                        <h2><?php echo $producto['nombre']; ?></h2>
                        <p>Te avisaremos a tu e-mail cuando el producto vuelva a estar disponible</p>
                        <input type="email" id="email" name="email" placeholder="E-mail...">
                    </form>
                </div>
            </div>
       <?php } else {?>
        <form action='index.php?controller=carrito&action=añadirAlCarrito' method='POST' enctype="multipart/form-data" class="formularioCarrito"> 
            <div class="contenedorCant">
                <label for="cantidad" id="labelCantidad">Cantidad:</label>
                <input id="cantidad" type="number" name="d_cantidad" min="0" max="<?php echo $producto['stock']; ?>" value="0">
            </div>
            <input type="hidden" name="d_id_producto" value="<?php echo $producto['id_producto']; ?>">
            <input type="hidden" name="d_precio" value="<?php echo $producto['precio']; ?>">
            <input type="hidden" name="d_nombre" value="<?php echo $producto['nombre']; ?>">
            <input type="hidden" name="d_img" value="<?php echo $producto['img']; ?>">
            <input type="hidden" name="d_correo" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
            <!-- Cambios en el botón: agregamos onclick -->
            <button type="button" class="d_botonAñadir">Añadir a la cesta</button>
        </form>
        <?php }?>
        <div class="Descripcion"><?php echo $producto['descripcion']; ?>
       </div>
    </div>
</div>
<script src="script.js"></script>