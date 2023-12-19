<?php
echo "
<div class='admin-panel-content-container'>
	<div class='admin-panel-title-container'>
		<ul class='tituloMenu'>
		<li><h1 class='admin-panel-title'>Categorías</h1></li>
		<li class='derecha'><a class='admin-panel-add-link' href='index.php?controller=Categoria&action=botonCrearCategoria'>Añadir categoría</a></li>
		<li class='derecha'>
			<form action='' method='post' class='formCat buscador'>
				<label for='campo' name='Cbuscar'><img src='views/img/AdminLupa.png' alt='Buscar' width='20' height='20'></label>
				<input type='text' id='Cbuscar' name='Cbuscar'>
			</form>
		</li>
		</ul>
		<div class='blue-line'></div>
	</div>";

echo "<div class='table-container'>";
echo "<table class='admin-panel-page-table'>
    	<tr>
        	<th>ID Categoria</th>
        	<th>Nombre</th>
        	<th>Género</th>
        	<th>Estado</th>
			<th>Editar</th>
    	</tr>";

foreach ($catalogo as $categoria) {
	$estado = $categoria['estado'] == 1 ? 'Activado' : 'Desactivado';
	echo "<tr>
        	<td class='text'>" . $categoria['id_categoria'] . "</td>
        	<td class='text'>" . $categoria['nombre'] . "</td>
        	<td class='text'>" . $categoria['sexo'] . "</td>
        	<td class='text'>" . $estado . "</td>
			<td class='text'><a href='index.php?controller=Categoria&action=botonEditarCategoria&id_categoria=" . $categoria['id_categoria'] . "'><img src='views/img/edit.svg' class='image_edit_icon'></a></td>
    	</tr>";
}
echo "</table>
</div>
</div>";
?>
