<div class="editContanier">	
    <form class='admin-panel-form' action='index.php?controller=Producto&action=botonCrearProducto' method='POST' enctype="multipart/form-data">
    <h2 class='h2-form'>Crear Producto</h2>
    
        <input type='text' id='' name='nombre' placeholder="Nombre del Producto" required><br><br>

        <input type='text' id='' name='descripcion' placeholder="Descripción" required><br><br>

        <input type='text' id='' name='precio' placeholder="Precio" required><br><br>

        <input type='text' id='' name='stock' placeholder="Stock" required><br><br>
        <div class="formgroup">
            <div class="destgroup">
                <label id="labelDestacado" for='destacado'>Destacado?</label>
                <div class="formgroup">
                    <input type='checkbox' id='' name='destacado' >
                </div>
                <div class="formgroup">
                    <select id="categoria" name="categoria">
                    <?php
                        foreach ($categorias as $categoria) {
                            echo "<option value='{$categoria['id_categoria']}'>{$categoria['nombre']}-{$categoria['sexo']}</option>";
                        }
                        ?>
                    </select></div>
                </div>
                <div class="estadoGrorup">
                    <label for='estado' id='labelestado'>Estado</label>
                    <input type='checkbox' id='checkestado' name='estado' checked >
                </div>


        </div>
       
        <input type='text' id='' name='referencia' placeholder="Referencia" ><br><br>

        <label for='imagen'>Imagen del producto</label><br><br>
	    <input type='file' id='imagen' name='imagen'><br><br>

        <a href="index.php?controller=Admin&action=botonVistaProducto" class='admin-panel-submit-link'>Volver atras</a>
        <input aria-label='añadir' class='admin-panel-submit-link' type='submit' value='Añadir'>


    </form>
</div>