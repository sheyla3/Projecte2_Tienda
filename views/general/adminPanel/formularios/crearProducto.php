<div class="editContanier">	
    <form class='admin-panel-form' action='index.php?controller=Producto&action=botonCrearProducto' method='POST' enctype="multipart/form-data">
    <h2 class='h2-form'>Crear Producto</h2>
    
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
        <select id="categoria" name="categoria">
        <?php
            foreach ($categorias as $categoria) {
                echo "<option value='{$categoria['id_categoria']}'>{$categoria['nombre']}-{$categoria['sexo']}</option>";
            }
            ?>
        </select><br><br>

        <label for='estado'>Estado (Activado por defecto)</label>
        <input type='checkbox' id='' name='estado' checked ><br><br>

        <label for='referencia'>Referencia</label>
        <input type='text' id='' name='referencia' ><br><br>

        <label for='imagen'>Imagen del producto</label><br><br>
	    <input type='file' id='imagen' name='imagen'><br><br>

        <a href="index.php?controller=Admin&action=botonVistaProducto" class='admin-panel-submit-link'>Volver atras</a>
        <input aria-label='añadir' class='admin-panel-submit-link' type='submit' value='AÑADIR'>


    </form>
</div>