<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Categorías</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class='admin-panel-title-container'>
		<h1 class='admin-panel-title'>Categorías</h1>
		<a href='index.php?controller=admin&action=botonCrearCategoria'>Añadir categoría</a><br>
		<div class='blue-line'></div>
	</div>
	<div class="div1">
		<a href="index.php?controller=admin&action=botonVistaProducto">Productos</a>
		<a href="index.php?controller=admin&action=botonVistaComanda">Pedidos</a>
	</div>

	<div class="div2">
		<?php
		echo "<table>
    	<tr>
        	<th>id categoria</th>
        	<th>nombre</th>
        	<th>genero</th>
        	<th>estado</th>
    	</tr>";

		foreach ($catalogo as $categoria) {
			echo "<tr>
        	<td>" . $categoria['id_categoria'] . "</td>
        	<td>" . $categoria['nombre'] . "</td>
        	<td>" . $categoria['sexo'] . "</td>
        	<td>" . $categoria['estado'] . "</td>
			<td><a href='index.php?controller=admin&action=botonEditarCategoria&id_categoria=" . $categoria['id_categoria'] . "'>Editar</a></td>
    	</tr>";
		}
		?>
	</div>
</body>

</html>