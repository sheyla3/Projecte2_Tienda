
<br><br>
<div class="editContanier">	
	<div class="imagenes">
		<?php
			foreach ($fotos as $imagen) {
				echo "<img src='" . $imagen['img'] . "' alt='Producto seleccionado'  width='400' height='500'>";
			}
		?>
	</div>
	<form class='admin-panel-form' action="index.php?controller=Producto&action=botonEditarProducto&id_producto=<?php echo $info[0]['id_producto']; ?>" method="POST" enctype="multipart/form-data">
	<h2 class="h2-form">Editar Producto</h2>	
	<!-- <label for="id_producto">ID Producto</label>
    	<input type="text" id="" name="id_producto" value="<?php echo $info[0]['id_producto']; ?>" required><br><br> -->
    
    	<label for="nombre">Nombre</label>
    	<input type="text" id="" name="nombre" value="<?php echo $info[0]['nombre']; ?>" required><br><br>

    	<label for="descripcion">Descripción</label>
    	<input type="text" id="" name="descripcion" value="<?php echo $info[0]['descripcion']; ?>" required><br><br>

    	<label for="precio">Precio</label>
    	<input type="text" id="" name="precio" value="<?php echo $info[0]['precio']; ?>" required><br><br>

    	<label for="stock">Stock</label>
    	<input type="text" id="" name="stock" value="<?php echo $info[0]['stock']; ?>" required><br><br>

		<div class="formgroup">
			<div class="destgroup">
			<label id="labelDestacado" for='destacado'>Destacado?</label>
				<div class="formgroup">
					<input type="checkbox" id="" name="destacado" <?php if($info[0]['destacado']) echo 'checked'; ?>>

				</div>
				<div class="formgroup">
				<select id="categoria" name="categoria">
					<?php
					foreach ($categorias as $categoria) {
						$selected = ($categoria['id_categoria'] == $info[0]['id_categoria']) ? 'selected' : '';
						echo "<option value='{$categoria['id_categoria']}' $selected>{$categoria['nombre']}-{$categoria['sexo']}</option>";
					}
					?>
				</select>
				</div>

			</div>
			<div class="estadoGrorup">
				<label for='estado' id='labelestado'>Estado</label>

    			<input type="checkbox" id='checkestado' name="estado" <?php if($info[0]['estado']) echo 'checked'; ?>>
			</div>


		</div>

	

    	

    	<label for="referencia">Referencia</label>
    	<input type="text" id="" name="referencia" value="<?php echo $info[0]['referencia']; ?>"><br><br>

		<input type="button" onclick="mostrarCampoImagen()" value="¿Quieres cambiar la foto?">
        <div id="campoImagen" style="display: none;">
            <input type="file" name="imagen">
        </div>
		<br><br>
		<a role='link' href="index.php?controller=Admin&action=botonVistaProducto" class='admin-panel-submit-link'>Volver atras</a>
    	<input aria-label="Guardar cambios" class='admin-panel-submit-link' type="submit" value="Guardar">
	</form>
</div>




