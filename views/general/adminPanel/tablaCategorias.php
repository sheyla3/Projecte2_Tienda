<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>estilo</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<a href="index.php?controller=admin&action=botonVistaProducto">Productos</a>
<a href="index.php?controller=admin&action=botonVistaComanda">Comandes</a>

    
<?php
	echo "<table>
    	<tr>
        	<th>id categoria</th>
        	<th>nombre</th>
        	<th>genero</th>
        	<th>estado</th>
    	</tr>";

	foreach($catalogo as $categoria) {
    	echo "<tr>
        	<td>" . $categoria['id_categoria'] . "</td>
        	<td>" . $categoria['nombre'] . "</td>
        	<td>" . $categoria['sexo'] . "</td>
        	<td>" . $categoria['estado'] . "</td>
			<td><a href='index.php?controller=admin&action=botonEditarCategoria'>Editar</a></td>
    	</tr>";
	}
?>
<a href="index.php?controller=admin&action=botonCrearCategoria">Crear categoria</a>
</body>

</html>
