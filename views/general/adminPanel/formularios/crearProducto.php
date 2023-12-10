
    <form class='admin-panel-form' action='index.php?controller=Admin&action=botonCrearProducto' method='POST'>
    <h2 class='h2-form'>Crear Producto</h2>
        <label for='id_producto'>ID Producto</label>
        <input type='text' id='' name='id_producto' required><br><br>
    
        <label for='nombre'>Nombre</label>
        <input type='text' id='' name='nombre' required><br><br>

        <label for='descripcion'>Descripción</label>
        <input type='text' id='' name='descripcion' required><br><br>

        <label for='precio'>Precio</label>
        <input type='text' id='' name='precio' required><br><br>

        <label for='stock'>Stock</label>
        <input type='text' id='' name='stock' required><br><br>

        <label for='destacado'>Destacado? (Desactivado por defecto)</label>
        <input type='checkbox' id='' name='destacado' ><br><br>

        <p>Categoria Asignada</p>
        <select id="producto" name="producto">
<?php
            foreach ($categorias as $categoria) {
                echo "<option value='{$categoria['id_categoria']}'>{$categoria['nombre']}</option>";
            }
            ?>
        </select><br><br>

        <label for='estado'>Estado (Activado por defecto)</label>
        <input type='checkbox' id='' name='estado' checked ><br><br>

        <label for='referencia'>Referencia</label>
        <input type='text' id='' name='referencia' ><br><br>

        <label for='imagen'>Imagen del producto</label><br><br>
	    <input type='file' id='imagen' name='imagen'><br><br>

        <input class='admin-panel-submit-link' type='submit' value='AÑADIR'>


    </form>