
	
	<form class='admin-panel-form' action="index.php?controller=Admin&action=botonEditarCategoria&id_categoria=<?php echo $info[0]['id_categoria']; ?>" method="POST">
	<h2 class="h2-form">Editar categoría</h2>
		<?php
    	echo "<label for='nombre'>Nombre</label>
    	<input type='text' id='nombre' name='nombre' required value='" . $info[0]['nombre'] . "'><br><br>
    	<label for='genero'>Género:</label>
    	<select id='genero' name='genero'>";
    	?>
        	<option value="Hombre">Hombre</option>
        	<option value="Mujer">Mujer</option>
    	</select>

    	<input type="checkbox" id="estado" name="estado" <?php echo($info[0]['estado'] == 1) ? 'checked' : ''; ?>>
    	<label for="estado">Estado</label><br>

    	<input class='admin-panel-submit-link' type="submit" value="Editar">
	</form>


