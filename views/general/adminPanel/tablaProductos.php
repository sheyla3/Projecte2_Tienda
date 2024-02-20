<?php
echo "
<div class='admin-panel-content-container'>
	<div class='admin-panel-title-container'>
		<ul class='tituloMenu'>
			<li><h1 class='admin-panel-title'>Productos</h1></li>
			<li class='derecha'><a class='admin-panel-add-link' href='index.php?controller=Producto&action=botonCrearProducto'>Añadir producto</a></li>
			<li class='derecha'>
			<form action='' aria-label='formulario' method='post' class='formCat buscador2'>
				<label for='Pbuscar' name='Pbuscar'><img src='views/img/AdminLupa.png' alt='Buscar' width='20' height='20'></label>
				<input type='text' id='Pbuscar' name='Pbuscar'>
			</form>
			</li>
		</ul>
    	<div class='blue-line'></div>
	</div>";

echo "<div class='table-container tabla_prod' id='tabla-p'>";
echo "<table class='admin-panel-page-table' aria-label='tabla'>
	<tr>
    	<th>ID Producto</th>
    	<th>Nombre</th>
    	<th>Precio</th>
    	<th>Stock</th>
    	<th>Destacado?</th>
    	<th>ID Categoria</th>
    	<th>Estado</th>
    	<th>Referencia</th>
    	<th>Editar</th>
	</tr>";

foreach ($catalogo as $producto) {
	$estado = $producto['estado'] == 1 ? 'Activado' : 'Desactivado';
	$destacado = $producto['destacado'] == 1 ? 'SI' : 'NO';

	echo "<tr>
			<td class='text'>" . $producto['id_producto'] . "</td>
			<td class='text'>" . $producto['nombre'] . "</td>
			<td class='text'>" . $producto['precio'] . "</td>
			<td class='text'>" . $producto['stock'] . "</td>
			<td class='text'>" . $destacado . "</td>
			<td class='text'>" . $producto['id_categoria'] . "</td>
			<td class='text'>" . $estado . "</td>
			<td class='text'>" . $producto['referencia'] . "</td>
			<td class='text'><a href='index.php?controller=Producto&action=botonEditarProducto&id_producto=" . $producto['id_producto'] . "'><img src='views/img/edit.svg' class='image_edit_icon'></a></td>
		</tr>";
}

echo "</table>
</div>
</div>";