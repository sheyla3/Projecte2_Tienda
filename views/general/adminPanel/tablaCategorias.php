<?php
echo "
<div class='admin-panel-content-container'>
<div class='admin-panel-title-container'>
		<h1 class='admin-panel-title'>Categorías</h1>
		<a class='admin-panel-add-link' href='index.php?controller=admin&action=botonCrearCategoria'>Añadir categoría</a><br>
		<div class='blue-line'></div>
	</div>";

	

echo "<table class='admin-panel-page-table'>
    	<tr>
        	<th>ID Categoria</th>
        	<th>Nombre</th>
        	<th>Género</th>
        	<th>Estado</th>
			<th>Editar</th>
    	</tr>";

foreach ($catalogo as $categoria) {
	echo "<tr>
        	<td class='text'>" . $categoria['id_categoria'] . "</td>
        	<td class='text'>" . $categoria['nombre'] . "</td>
        	<td class='text'>" . $categoria['sexo'] . "</td>
        	<td class='text'>" . $categoria['estado'] . "</td>
			<td class='text'><a href='index.php?controller=admin&action=botonEditarCategoria&id_categoria=" . $categoria['id_categoria'] . "'><img src='views/img/edit.svg' class='image_edit_icon'></a></td>
    	</tr>";
}
echo "</table>
</div>";
?>