<!DOCTYPE html>
<html>
<head>
	<title>Editar Producto</title>
</head>
<body>
	<h2>Editar Producto</h2>
	<form action="index.php?controller=Admin&action=botonEditarProducto&id_producto=<?php echo $info[0]['id_producto']; ?>" method="POST">
    	<label for="id_producto">ID Producto</label>
    	<input type="text" id="" name="id_producto" value="<?php echo $info[0]['id_producto']; ?>" required><br><br>
    
    	<label for="nombre">Nombre</label>
    	<input type="text" id="" name="nombre" value="<?php echo $info[0]['nombre']; ?>" required><br><br>

    	<label for="descripcion">Descripción</label>
    	<input type="text" id="" name="descripcion" value="<?php echo $info[0]['descripcion']; ?>" required><br><br>

    	<label for="precio">Precio</label>
    	<input type="text" id="" name="precio" value="<?php echo $info[0]['precio']; ?>" required><br><br>

    	<label for="stock">Stock</label>
    	<input type="text" id="" name="stock" value="<?php echo $info[0]['stock']; ?>" required><br><br>

    	<label for="destacado">Destacado</label>
    	<input type="checkbox" id="" name="destacado" <?php if($info[0]['destacado']) echo 'checked'; ?>><br><br>

    	<select id="categoria" name="categoria">
        	<?php
        	foreach ($categorias as $categoria) {
            	$selected = ($categoria['id_categoria'] == $info[0]['id_categoria']) ? 'selected' : '';
            	echo "<option value='{$categoria['id_categoria']}' $selected>{$categoria['nombre']}</option>";
        	}
        	?>
    	</select>

    	<label for="estado">Estado</label>
    	<input type="checkbox" id="" name="estado" <?php if($info[0]['estado']) echo 'checked'; ?>><br><br>

    	<label for="referencia">Referencia</label>
    	<input type="text" id="" name="referencia" value="<?php echo $info[0]['referencia']; ?>"><br><br>

    	<input type="submit" value="Guardar Cambios">
	</form>
</body>
</html>




