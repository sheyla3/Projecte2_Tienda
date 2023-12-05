<!DOCTYPE html>
<html>
<head>
	<title>Editar categoría</title>
</head>
<body>
	<h2>Editar categoría</h2>
	<form action="index.php?controller=Admin&action=botonEditarCategoria&id_categoria=<?php echo $info[0]['id_categoria']; ?>" method="POST">
    	<?php
    	echo("<label for='nombre'>Nombre</label>");
    	echo("<input type='text' id='nombre' name='nombre' required value='" . $info[0]['nombre'] . "'><br><br>");
    	echo("<label for='genero'>Género:</label>");
    	echo("<select id='genero' name='genero'>");
    	?>
        	<option value="H">Hombre</option>
        	<option value="M">Mujer</option>
    	</select>

    	<input type="checkbox" id="estado" name="estado" <?php echo($info[0]['estado'] == 1) ? 'checked' : ''; ?>>
    	<label for="estado">Estado</label><br>

    	<input type="submit" value="Editar">
	</form>
</body>
</html>

