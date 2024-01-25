<?php
$producto = $productos[0];
$precioFormateado = number_format($producto['precio'], 2) . '€';


?>

<div class="Desktop1">
    <img class="FotoZapato" src="<?php echo $producto['img']; ?>" alt="<?php echo $producto['nombre']?>" />
    <div class="ZonaInfo">
        <div class="NombreProducto"><?php echo $producto['nombre']; ?></div>
        <div class="Precio"><?php echo $precioFormateado; ?></div>
        <form action='index.php?controller=carrito&action=añadirAlCarrito' method='POST' enctype="multipart/form-data" class="formularioCarrito"> 
            <div class="contenedorCant">
                <label for="cantidad" id="labelCantidad">Cantidad:</label>
                <input id="cantidad" type="number" name="d_cantidad" min="0" max="<?php echo $producto['stock']; ?>" value="0">
            </div>
            <input type="hidden" name="d_id_producto" value="<?php echo $producto['id_producto']; ?>">
            <input type="hidden" name="d_precio" value="<?php echo $producto['precio']; ?>">
            <input type="hidden" name="d_correo" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
            <!-- Cambios en el botón: agregamos onclick -->
            <button type="button" class="botonAñadir" onclick="agregarAlCarrito()">Añadir a la cesta</button>
        </form>
        <div class="Descripcion"><?php echo $producto['descripcion']; ?></div>
    </div>
</div>

<script>
    // Definimos la función que se llamará al hacer clic en el botón
    function agregarAlCarrito() {
        // Acceder a los valores del formulario actual
        var id_producto = document.querySelector('[name="d_id_producto"]').value;
        var cantidad = document.querySelector('[name="d_cantidad"]').value;
        var precio = document.querySelector('[name="d_precio"]').value;
        var correo = document.querySelector('[name="d_correo"]').value;

        // Puedes realizar operaciones con los datos aquí
        console.log("ID Producto: " + id_producto);
        console.log("Cantidad: " + cantidad);
        console.log("Precio: " + precio);
        console.log("usuario" + correo);

        // Ejemplo de cómo enviar los datos a través de XMLHttpRequest o fetch
        // (reemplaza esto con tu lógica específica)
        // fetch('tu_url_de_backend', {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json',
        //     },
        //     body: JSON.stringify({
        //         id_producto: id_producto,
        //         cantidad: cantidad,
        //         precio: precio
        //     }),
        // });

        // Después de realizar las operaciones, puedes redirigir o mostrar un mensaje
        // window.location.href = 'index.php'; // Cambia la URL según tus necesidades
    }
</script>
